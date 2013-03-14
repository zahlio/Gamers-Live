<?php
class TF_Widget_Archives extends WP_Widget {

	function TF_Widget_Archives() {
		$widget_ops = array('classname' => 'widget_archive', 'description' => __( 'A monthly archive of your site&#8217;s posts') );
		$this->WP_Widget('archives', __('TFuse Archives'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$c = $instance['count'] ? '1' : '0';
		$d = $instance['dropdown'] ? '1' : '0';
        $template = empty( $instance['template'] ) ? '' : $instance['template'];

        $tfuse_widget_col_before = $tfuse_widget_col_after = '';

        		$title = apply_filters('widget_title', empty($instance['title']) ? __('Archives') : $instance['title'], $instance, $this->id_base);

		$before_widget = '<div id="archives-3" class="widget-container widget_archive '.$template.'">';
		$after_widget = '</div>';
		$before_title = '<h3 class="widget-title">';
		$after_title = '</h3>';

		echo $tfuse_widget_col_before .$before_widget;
		$title = tfuse_qtranslate($title);
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $d ) {
?>
		<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> <option value=""><?php echo esc_attr(__('Select Month')); ?></option> <?php wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $c))); ?> </select>
<?php
		} else {
?>
		<ul>
		<?php wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $c))); ?>
		</ul>
<?php
		}

		echo $after_widget . $tfuse_widget_col_after;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '', 'template'=>'') );
		$instance['title'] = $new_instance['title'];
		$instance['count'] = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;
		$instance['template'] = $new_instance['template'];

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '','template'=>'') );
		$title = $instance['title'];
		$count = $instance['count'] ? 'checked="checked"' : '';
		$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
?>
        <p>
            <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e( 'Widget Template:' ); ?></label>
            <select name="<?php echo $this->get_field_name('template'); ?>" id="<?php echo $this->get_field_id('template'); ?>" class="widefat">
                <option value="widget_box_white" <?php selected($instance['template'], 'widget_box_white' ); ?>><?php _e('White Widget Backround'); ?></option>
                <option value="no_background" <?php selected( $instance['template'], 'no_background' ); ?>><?php _e('Transparent Widget Background'); ?></option>
            </select>
        </p>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts'); ?></label>
			<br />
			<input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as a drop down'); ?></label>
        </p>
		
<?php
	}
}

function TFuse_Unregister_WP_Widget_Archives() {
	unregister_widget('WP_Widget_Archives');       
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Archives');

register_widget('TF_Widget_Archives');
?>