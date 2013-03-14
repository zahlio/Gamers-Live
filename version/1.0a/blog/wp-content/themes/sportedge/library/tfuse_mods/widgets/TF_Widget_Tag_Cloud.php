<?php
class TF_Widget_Tag_Cloud extends WP_Widget {

	function TF_Widget_Tag_Cloud() {
		$widget_ops = array( 'description' => __( "Your most used tags in cloud format") );
		$this->WP_Widget('tag_cloud', __('TFuse Tag Cloud'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);



		$before_widget = '<div id="tag_cloud-3" class="widget-container widget_tag_cloud">';
		$after_widget = '</div>';
		$before_title = '<h3 class="widget-title">';
		$after_title = '</h3>';		
		

		echo $before_widget;
		$title = tfuse_qtranslate($title);
		if ( $title )echo $before_title . $title. $after_title;
		echo '<div class="tagcloud">';
		wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy) ) );
		echo "</div>\n";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = $new_instance['title'];
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'template' => '') );
		$current_taxonomy = $this->_get_current_taxonomy($instance);
?>


	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:') ?></label>
	<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
	<?php foreach ( get_object_taxonomies('post') as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
	</select></p>
    <?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}



function TFuse_Unregister_WP_Widget_Tag_Cloud() {
	unregister_widget('WP_Widget_Tag_Cloud');       
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Tag_Cloud');

register_widget('TF_Widget_Tag_Cloud');
?>