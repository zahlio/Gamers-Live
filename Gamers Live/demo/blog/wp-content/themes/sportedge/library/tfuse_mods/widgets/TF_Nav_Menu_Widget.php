<?php
class TF_Nav_Menu_Widget extends WP_Widget {

	function TF_Nav_Menu_Widget() {
		$widget_ops = array( 'description' => __('Add a custom menus as a widget.') );
		parent::WP_Widget( 'nav_menu', __('TFuse Custom Menu'), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );

		if ( !$nav_menu )
			return;
        $template = empty( $instance['template'] ) ? '' : $instance['template'];
		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		$args['before_widget'] = '<div id="categories-5" class="widget-container widget_nav_menu '.$template .'">';
		$args['after_widget'] = '</div>';
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title'] = '</h3>';

		echo $args['before_widget'];

		$instance['title'] = tfuse_qtranslate($instance['title']);
		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

			wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'link_before'=> '<span>', 'link_after' => '</span>') );

			echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title']    =  $new_instance['title'] ;
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['template'] = $new_instance['template'];
       
		return $instance;
	}

	function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '','nav_menu' => '', 'template'=>'') );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
        
		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		
        <p>
            <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e( 'Widget Template:' ); ?></label>
            <select name="<?php echo $this->get_field_name('template'); ?>" id="<?php echo $this->get_field_id('template'); ?>" class="widefat">
                <option value="widget_box_white" <?php selected($instance['template'], 'widget_box_white' ); ?>><?php _e('White Widget Backround'); ?></option>
                <option value="no_background" <?php selected( $instance['template'], 'no_background' ); ?>><?php _e('Transparent Widget Background'); ?></option>
            </select>
        </p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}


function TFuse_Unregister_WP_Nav_Menu_Widget() {
	unregister_widget('WP_Nav_Menu_Widget');       
}
add_action('widgets_init','TFuse_Unregister_WP_Nav_Menu_Widget');

register_widget('TF_Nav_Menu_Widget');
?>