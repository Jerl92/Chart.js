<?php
/**
 * chart Widget Class
 */
class chart_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function chart_widget() {
        parent::WP_Widget(false, $name = 'Chart Widget');	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $postid 	= $instance['postid'];
        $post_chart_type = get_post_meta($postid, "meta_chart_type", true);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>                                        
                                <li><canvas id="canvas-widget" data-chartid="<?php echo $postid; ?>" data-chart-type="<?php echo $post_chart_type; ?>" ></canvas></li>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['postid'] = strip_tags($new_instance['postid']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
 
        $title 		= esc_attr($instance['title']);
        $postid	= esc_attr($instance['postid']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('postid'); ?>"><?php _e('Chart Post ID:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('postid'); ?>" name="<?php echo $this->get_field_name('postid'); ?>" type="text" value="<?php echo $postid; ?>" />
        </p>
        <?php 
    }
 
 
} // end class chart_widget
add_action('widgets_init', create_function('', 'return register_widget("chart_widget");'));
?>