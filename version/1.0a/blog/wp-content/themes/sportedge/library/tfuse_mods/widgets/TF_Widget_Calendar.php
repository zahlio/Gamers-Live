<?php
class TF_Widget_Calendar extends WP_Widget {

	function TF_Widget_Calendar() {
		$widget_ops = array('classname' => 'widget_calendar', 'description' => __( 'A calendar of your site&#8217;s posts') );
		$this->WP_Widget('calendar', __('TFuse Calendar'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		$before_widget = ' <div id="calendar-3" class="widget-container widget_calendar"> ';
		$after_widget = '</div>';
		$before_title = '<h3>';
		$after_title = '</h3>';		
		
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div id="calendar_wrap">';
		get_calendar();
		echo '</div>';
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
?>
 
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

<?php
	}
}


function TFuse_Unregister_WP_Widget_Calendar() {
	unregister_widget('WP_Widget_Calendar');       
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Calendar');

register_widget('TF_Widget_Calendar');
?>