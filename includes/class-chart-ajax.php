<?php
/* Enqueue Script */
add_action( 'wp_enqueue_scripts', 'wp_chart_ajax_scripts' );
/**
 * Scripts
 */
function wp_chart_ajax_scripts() {
	/* Plugin DIR URL */
	$url = trailingslashit( plugin_dir_url( __FILE__ ) );
	//
	if ( is_user_logged_in() ) {
		wp_register_script( 'wp-get-ajax-scripts', $url . "js/ajax.get.js", array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'wp-get-ajax-scripts', 'get_ajax_url', admin_url( 'admin-ajax.php' ) );
        wp_enqueue_script( 'wp-get-ajax-scripts' );	
	}
}

add_action( 'wp_ajax_get_chart', 'ajax_get_chart' );
add_action( 'wp_ajax_nopriv_get_chart', 'ajax_get_chart' );
function ajax_get_chart($post) {

    $object_id = $_POST['object_id'];

    $post = get_post( $object_id );

    $chart_data = get_post_meta($post->ID, "meta_chart_data", true);
    $chart_name = get_post_meta($post->ID, "meta_chart_name", true);
    $column_name = get_post_meta($post->ID, "meta_chart_column_name", true);
    $column_color = get_post_meta($post->ID, "meta_chart_column_color", true);

    $html[0] = $chart_name;

    $html[1] = $column_name;

    $html[2] = $column_color;

    foreach ($chart_data as $chart_value) {
        $html[3][] = $chart_value;
    }

    $arr = implode("", $html);

    return wp_send_json ($html); 
}

?>