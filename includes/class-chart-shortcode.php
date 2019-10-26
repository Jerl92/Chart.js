<?php
function chart_func( $atts ){
    $postid = $atts['postid'];
    $post_chart_type = get_post_meta($postid, "meta_chart_type", true);
    $meta_chart_name = get_post_meta($postid, "meta_chart_name", true);
    $get_meta_chart_data = get_post_meta($postid, "meta_chart_data", true);
    $column_name = get_post_meta($postid, "meta_chart_column_name", true);
    $column_color = get_post_meta($postid, "meta_chart_column_color", true);
    $i = 0;

    echo '<canvas id="canvas" data-chartid="' . $postid . '" data-chart-type="' . $post_chart_type .'"></canvas>';
    
    echo '<table>';
    echo '<tr>';
    echo '<th>';
    echo '</th>';
    foreach ($meta_chart_name as $chart_name) {
        echo '<th>';
        echo $chart_name;
        echo '</th>';
    }
    echo '<th>';
        echo 'Moyenne';
    echo '</th>';
    echo '</tr>';
    foreach ($get_meta_chart_data as $meta_chart_data) {
        echo '<tr>';
        echo '<td>';
            echo $column_name[$i];
        echo '</td>';
        $y = 0;
        foreach ($meta_chart_data as $meta_chart_value) {
            echo '<td>';
            echo $meta_chart_value;
            echo '</td>';
            $y++;
        }
        echo '<td>';
            echo (array_sum($meta_chart_data) / $y);
        echo '</td>';
        echo '</tr>';
        $i++;
    }
    echo '</table>';
}
add_shortcode( 'chart', 'chart_func' );
?>