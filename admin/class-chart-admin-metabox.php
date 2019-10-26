<?php

//Register Meta Box
function chart_register_meta_box() {
    add_meta_box( 'chart-meta-box-info', esc_html__( 'chart Info', 'chart' ), 'chart_info_meta_box_callback', 'chart', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'chart_register_meta_box');
 
//Add field
function chart_info_meta_box_callback( $meta_id ) { 
    wp_nonce_field(basename(__FILE__), "meta-box-nonce"); 
    $get_meta_chart_data = get_post_meta($meta_id->ID, "meta_chart_data", true);
    $meta_chart_name = get_post_meta($meta_id->ID, "meta_chart_name", true);
    $meta_chart_column_name = get_post_meta($meta_id->ID, "meta_chart_column_name", true);
    $meta_chart_column_color = get_post_meta($meta_id->ID, "meta_chart_column_color", true);
    $i = 0; ?> 

    <table style="width:100%">
        <tr>
            <th>Chart type</th>
            <select name="meta-box-chart-type">
                <option value="line">Line</option>
                <option value="bar">Bar</option>
                <option value="radar">Radar</option>
                <option value="polarArea">Polar Area</option>
                <option value="bubble">Bubble</option>
                <option value="scatter">Scatter</option>
            </select>
        </tr>
    </table>

    <table id="chart-data-table" data-chartid="<?php echo $meta_id->ID; ?>" data-chart-loop="<?php echo $i; ?>" style="width:100%">
        <tr>
            <td><button id="meta-box-btn" type="button">Add Line</button></td>
            <td><button id="meta-box-btn-add-row" type="button">Add Row</button></td>
        </tr>
        <?php $i = 0; ?> 
        <?php $y = 0; ?> 

        <tr>
            <th></th>
            <th></th>
            <th></th>
            <?php $i = 0; ?>
            <?php foreach ($get_meta_chart_data as $meta_chart_data) {
                echo '<th><input name="meta-box-chart-column-name[]" type="text" id="meta-box-chart-column-name" value="' . $meta_chart_column_name[$i] . '" size="15"></th>';
                $i++;
            } ?>
         </tr>
         
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <?php $i = 0; ?>
            <?php foreach ($get_meta_chart_data as $meta_chart_data) { ?>
                <th><select name="meta-box-chart-column-color[]">
                    <option value="red">Red</option>
                    <option value="orange">Orange</option>
                    <option value="yellow">Yellow</option>
                    <option value="green">Green</option>
                    <option value="blue">Blue</option>
                    <option value="purple">Purple</option>
                    <option value="grey">Grey</option>
                </select></th>
                <?php $i++;
            } ?>
         </tr>



         <?php $i = 0; ?>
        <?php foreach ($get_meta_chart_data[$i] as $meta_chart_value) { 
                 
                $y = 0;

                echo '<tr id="tr-char-' . $i . '" class="tr-char">';
                echo '<th>Chart name</th>';
                echo '<td><input name="meta-box-chart-name[]" type="text" id="meta-box-chart-name" value="' . $meta_chart_name[$i] . '" size="30"></td>';

                echo '<th>Chart data</th>';
                foreach ($get_meta_chart_data as $meta_chart_data) {
                    echo '<td><input name="meta-box-chart[' . $y . '][' . $i . ']" type="number" id="meta-box-chart" value="' . $meta_chart_data[$i] . '" size="30"></td>';
                    $y++;
                }

                echo '<td class="btn-remove"><div id="btn-remove-' . $i . '" class="meta-box-btn-remove" data-id="' . $i . '">Remove</div></td>';
                echo '</tr>';
            $i++;
        } ?>

    </table>

<?php }

function save_chart_info_meta_box($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
    return $post_id;
    if(!current_user_can("edit_post", $post_id))
        return $post_id;
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;
    $slug = "chart";
    if($slug != $post->post_type)
        return $post_id;

    if( ! isset( $_POST['meta-box-chart-type'] ) )
    return; 
    
    update_post_meta( $post_id, "meta_chart_type", $_POST['meta-box-chart-type'] );
    
    if( ! isset( $_POST['meta-box-chart'] ) )
    return; 
    
    update_post_meta( $post_id, "meta_chart_data", $_POST['meta-box-chart'] );

    if( ! isset( $_POST['meta-box-chart-name'] ) )
    return; 
    
    update_post_meta( $post_id, "meta_chart_name", $_POST['meta-box-chart-name'] );

    if( ! isset( $_POST['meta-box-chart-column-name'] ) )
    return; 
    
    update_post_meta( $post_id, "meta_chart_column_name", $_POST['meta-box-chart-column-name'] );

    if( ! isset( $_POST['meta-box-chart-column-color'] ) )
    return; 
    
    update_post_meta( $post_id, "meta_chart_column_color", $_POST['meta-box-chart-column-color'] );
}
add_action("save_post", "save_chart_info_meta_box", 10, 3);


add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here
function my_action_javascript() { ?>
	<script type="text/javascript" >
    function add_chart_data($) {

        $("#meta-box-btn").on( "click", function(event) {
		event.preventDefault();

            var data = {
                'action': 'my_action',
                'postid': $("#chart-data-table").attr('data-chartid'),
                'whatever': $(".tr-char").length,
                'count_del': $(".meta-box-btn-remove").length,
                'count': $("#tr-char-0 #meta-box-chart").length
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                console.log(response);
                $("#chart-data-table").append(response);
                remove_chart_data($);
            });

        });

    }
    jQuery(document).ready(function($) {
        add_chart_data($);
    });
	</script> <?php
}

add_action( 'admin_footer', 'remove_data_javascript' ); // Write our JS below here
function remove_data_javascript() { ?>
	<script type="text/javascript" >
    function remove_chart_data($) {
    $(".meta-box-btn-remove").on( "click", function(event) {
		event.preventDefault();
            var data = {
                'action': 'remove_data',
                'postid': $("#chart-data-table").attr('data-chartid'),
                'whatever': $(this).attr('data-id'),
                'count_colums': $("#tr-char-0 #meta-box-chart").length,
                'count': $(".meta-box-btn-remove").length
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                console.log(response);
                $("#tr-char-"+data['whatever']).empty();
                add_chart_data($);
                remove_chart_data($);
            });

        });
    }

    jQuery(document).ready(function($) {
        remove_chart_data($);
    });
	</script> <?php
}

add_action( 'admin_footer', 'add_row_javascript' ); // Write our JS below here
function add_row_javascript() { ?>
	<script type="text/javascript" >
    function add_row_chart_data($) {
    $("#meta-box-btn-add-row").on( "click", function(event) {
		event.preventDefault();
            var data = {
                'action': 'add_row',
                'postid': $("#chart-data-table").attr('data-chartid'),
                'whatever': $(this).attr('data-id'),
                'count': $(".meta-box-btn-remove").length
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                console.log(response);
                var myform = $('#chart-data-table');
                var count = $("#tr-char-0 #meta-box-chart").length
                myform.find('tr').each(function(){
                    var trow = $(this);
                    if(trow.index() == 1){
                        trow.append('<th><input name="meta-box-chart-column-name[]" type="text" id="meta-box-chart-column-name" value="" size="15"></th>');
                    }
                    if(trow.index() == 2){
                        trow.append('<th><select name="meta-box-chart-column-color[]"><option value="red">Red</option><option value="orange">Orange</option><option value="yellow">Yellow</option><option value="green">Green</option><option value="blue">Blue</option><option value="purple">Purple</option><option value="grey">Grey</option></select></th>');
                    }
                    if(trow.index() > 2){
                        trow.append('<td><input name="meta-box-chart['+count+'][]" type="number" id="meta-box-chart" size="30" value=""></td>');
                    }
                    
                });
            });

        });
    }

    jQuery(document).ready(function($) {
        add_row_chart_data($);
    });
	</script> <?php
}

add_action( 'wp_ajax_my_action', 'my_action' );
function my_action() {
	global $wpdb; // this is how you get access to the database

    $whatever = intval( $_POST['whatever'] );
    $postid = intval( $_POST['postid'] );
    $count = intval( $_POST['count'] );
    $count_del = intval( $_POST['count_del'] );
    $i = 0;

    $html = '<tr id="tr-char-' . $count . '">';
        $html .= '<th>Chart name</th>';
        $html .= '<td><input name="meta-box-chart-name[]" type="text" id="meta-box-chart-name" size="30" value=""></td>';
        $html .= '<th>Chart data</th>';
        while ($i < $count) {
            $html .= '<td><input name="meta-box-chart[' . $i . '][' . $count_del .']" type="number" id="meta-box-chart" size="30" value=""></td>';
            $i++;
        }
        if ($count == 0) {
            $html .= '<td><input name="meta-box-chart[0][0]" type="number" id="meta-box-chart" size="30" value=""></td>';
        }

        $html .= '<td class="btn-remove"><div id="btn-remove-' . $whatever . '" class="meta-box-btn-remove" data-id="' . $whatever . '">Remove</div></td>';
    $html .= '</tr>';

    return wp_send_json ( $html );
}


add_action( 'wp_ajax_remove_data', 'remove_data' );

function remove_data() {
	global $wpdb; // this is how you get access to the database

    $whatever = intval( $_POST['whatever'] );
    $count = intval( $_POST['count'] );
    $postid = intval( $_POST['postid'] );
    $count_colums = intval( $_POST['count_colums'] );
    $i = 0;
    $get_meta_chart_data = get_post_meta($postid, "meta_chart_data", true);
    $meta_chart_name = get_post_meta($postid, "meta_chart_name", true);

    while ($i < $count_colums) {
        array_splice($get_meta_chart_data[$i], $whatever, 1);
        $i++;
    }
    unset($meta_chart_name[$whatever]);
    array_values($meta_chart_name);

    update_post_meta( $postid, "meta_chart_data", $get_meta_chart_data );
    update_post_meta( $postid, "meta_chart_name", $meta_chart_name );

    // delete_post_meta( $postid, "meta_chart_data");

    return wp_send_json ( $whatever ) ;
}

add_action( 'wp_ajax_add_row', 'add_row' );

function add_row() {
	global $wpdb; // this is how you get access to the database

    $whatever = intval( $_POST['whatever'] );
    $count = intval( $_POST['count'] );
    $postid = intval( $_POST['postid'] );
    $get_meta_chart_data = get_post_meta($postid, "meta_chart_data", true);
    $meta_chart_name = get_post_meta($postid, "meta_chart_name", true);

    return wp_send_json ( $count ) ;
}

?>