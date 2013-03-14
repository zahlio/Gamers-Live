<?php

// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'tfuse' ),
    'footer' => __( 'Footer Navigation', 'tfuse' )
) );

function tfuse_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'tfuse_page_menu_args' );
add_filter('wp_nav_menu','add_last_item_class');

//*******************************************************//
class tfuse {

	var $prefix;
	
	var $admin_options;

	function init() {

		$this->constants();

		$this->functions();

		$this->admin();
		
		$this->theme_options();
		
		$this->theme_widgets();
		
		/* Theme init hook. */
		do_action( "{$this->prefix}_init" );
	}

	
	// Defines the constant paths for use within the theme.
	function constants() {
		define( 'THEME_DIR', 		get_template_directory() );
		define( 'THEME_URI', 		get_template_directory_uri() );
		define( 'CHILD_THEME_DIR', 	get_stylesheet_directory() );
		define( 'CHILD_THEME_URI', 	get_stylesheet_directory_uri() );

		define( 'THEME_LIBRARY', 	THEME_DIR 		. '/library' );
		define( 'THEME_INSTALL', 	THEME_DIR 		. '/library/install' );
		define( 'TFUSE_FRAMEWORK', 	THEME_DIR 		. '/library/tfuse_framework' );
		define( 'TFUSE_MODS', 		THEME_DIR 		. '/library/tfuse_mods' );
		
		
		define( 'THEME_ADMIN', 		TFUSE_FRAMEWORK . '/admin' );
		define( 'THEME_FUNCTIONS', 	TFUSE_FRAMEWORK . '/functions' );
		
		define( 'THEME_OPTIONS', 	TFUSE_MODS 		. '/options' );
		define( 'TEMPLATE_CAT', 	TFUSE_MODS 		. '/templates_cat' );
		define( 'TEMPLATE_POST', 	TFUSE_MODS 		. '/templates_post' );
		define( 'THEME_MODULES', 	TFUSE_MODS 		. '/thememodules' );
		define( 'THEME_INCLUDES', 	THEME_MODULES 		. '/includes' );
		define( 'WIDGETS', 			TFUSE_MODS 		. '/widgets' );
		
		define( 'ADMIN_IMAGES', 	THEME_URI 		. '/library/tfuse_framework/images' );
		define( 'ADMIN_CSS', 		THEME_URI 		. '/library/tfuse_framework/css' );
		define( 'ADMIN_JS', 		THEME_URI		. '/library/tfuse_framework/js' );
		define( 'THEME_IMAGES', 	THEME_URI 		. '/images' );
		define( 'THEME_CSS', 		THEME_URI 		. '/css' );
		define( 'THEME_JS', 		THEME_URI 		. '/js' );
	}

	// Loads the core theme functions.
	function functions() {
		require     ( THEME_OPTIONS 	. '/theme_options.php' );
		require_once( THEME_FUNCTIONS 	. '/array_walk_recursive.php' );
		require_once( THEME_FUNCTIONS 	. '/core.php' );
		require_once( THEME_FUNCTIONS 	. '/get_image.php' );
		require_once( THEME_FUNCTIONS 	. '/get_embed.php' );
		require_once( THEME_FUNCTIONS 	. '/ajax_upload.php' );
		require_once( THEME_FUNCTIONS 	. '/upload.php' );

		if( is_file(  THEME_MODULES 	. '/slider.php')) 
		require_once( THEME_MODULES 	. '/slider.php' );
		else
		require_once( THEME_FUNCTIONS 	. '/slider.php' );
		
		require_once( THEME_FUNCTIONS 	. '/options_generator.php' );
		require_once( THEME_FUNCTIONS 	. '/save_options.php' );
		require_once( THEME_FUNCTIONS 	. '/install/install.php' );
		
		if( is_file(  THEME_MODULES 	. '/theme-comments.php')) 
		require_once( THEME_MODULES 	. '/theme-comments.php' );
		
		if( is_file(  THEME_MODULES 	. '/pagination.php')) 
		require_once( THEME_MODULES 	. '/pagination.php' );
		else
		require_once( THEME_FUNCTIONS 	. '/pagination.php' );
		
		if( is_file(  THEME_MODULES 	. '/tfuse_display_box.php')) 
		require_once( THEME_MODULES 	. '/tfuse_display_box.php' );
		else
		require_once( THEME_FUNCTIONS 	. '/tfuse_display_box.php' );
		
		if( is_file(  THEME_MODULES 	. '/sidebar_init.php')) 
		require_once( THEME_MODULES 	. '/sidebar_init.php' );
		else
		require_once( THEME_FUNCTIONS 	. '/sidebar_init.php' );
		
		if( is_file(  THEME_MODULES 	. '/shortcode.php')) 
		require_once( THEME_MODULES 	. '/shortcode.php' );
		else
		require_once( THEME_FUNCTIONS 	. '/shortcode.php' );
		
		if( is_file(  THEME_MODULES 	. '/includes/tfuse_include_shortcodes.php'))
		require_once( THEME_MODULES 	. '/includes/tfuse_include_shortcodes.php' );

		if( is_file(  THEME_MODULES 	. '/tinymce/tinymce.php')) 
		require_once( THEME_MODULES 	. '/tinymce/tinymce.php' );
		else
		require_once( THEME_FUNCTIONS 	. '/tinymce/tinymce.php' );
		
		if( is_file(  THEME_MODULES 	. '/tfuse_slider_include.php')) 
		require_once( THEME_MODULES 	. '/tfuse_slider_include.php' );
	
		if( is_file(  THEME_MODULES 	. '/tfuse_breadcrumbs.php')) 
		require_once( THEME_MODULES 	. '/tfuse_breadcrumbs.php' );
	
		if( is_file(  THEME_MODULES 	. '/includes/tfuse_sidebar_position.php'))
		require_once( THEME_MODULES 	. '/includes/tfuse_sidebar_position.php' );

        if( is_file(  THEME_MODULES 	. '/includes/tfuse_theme_functions.php'))
		require_once( THEME_MODULES 	. '/includes/tfuse_theme_functions.php' );

        if( is_file(  THEME_MODULES 	. '/includes/admin_hooks.php'))
		require_once( THEME_MODULES 	. '/includes/admin_hooks.php' );

         if( is_file(  THEME_MODULES 	. '/includes/theme_add.php'))
		require_once( THEME_MODULES 	. '/includes/theme_add.php' );

        if( is_file(  THEME_MODULES 	. '/includes/tfuse_slides.php'))
		require_once( THEME_MODULES 	. '/includes/tfuse_slides.php' );

        if( is_file(  THEME_MODULES 	. '/includes/tfuse_post_type.php'))
		require_once( THEME_MODULES 	. '/includes/tfuse_post_type.php' );

        if( is_file(  THEME_MODULES 	. '/includes/tfuse_single.php'))
		require_once( THEME_MODULES 	. '/includes/tfuse_single.php' );

         if( is_file(  THEME_MODULES 	. '/header_element/tfuse_date_box.php'))
		require_once( THEME_MODULES 	. '/header_element/tfuse_date_box.php' );

         if( is_file(  THEME_INCLUDES 	. '/tfuse_shortcode_posts.php'))
		require_once( THEME_INCLUDES 	. '/tfuse_shortcode_posts.php' );

         if( is_file(  THEME_INCLUDES 	. '/tfuse_featured_post.php'))
		require_once( THEME_INCLUDES 	. '/tfuse_featured_post.php' );

         if( is_file(  THEME_INCLUDES 	. '/tfuse_bottom_posts.php'))
		require_once( THEME_INCLUDES 	. '/tfuse_bottom_posts.php' );

	}

	//Load admin files.
	function admin() {
		if ( is_admin() ) {
			require_once( THEME_ADMIN   . '/admin.php' );
			require_once( THEME_ADMIN	. '/init_options.php' );
			require_once( THEME_ADMIN   . '/admin_interface_page.php' );
			require_once( THEME_ADMIN   . '/support_interface_page.php' );
			require_once( THEME_ADMIN   . '/newsletter_interface_page.php' );
			require_once( THEME_ADMIN   . '/newspromo_page.php' );
			require_once( THEME_MODULES . '/shortcode_generator.php' );
			require_once( THEME_ADMIN   . '/options_page_content.php' );
			require_once( THEME_ADMIN   . '/save_options.php' );
			require_once( THEME_ADMIN 	. '/meta_box_generator.php' );	
			require_once( THEME_ADMIN 	. '/testimonial_manager.php' );	
		}
	}
	
	function theme_options() {
			$alt_options_template_path = THEME_OPTIONS;
			$alt_options_template = array();
			 
			if ( is_dir($alt_options_template_path) ) {
				if ($alt_options_template_dir = opendir($alt_options_template_path) ) { 
					while ( ($alt_options_template_file = readdir($alt_options_template_dir)) !== false ) {
				   		if(stristr($alt_options_template_file, ".php") !== false) {
				   		
			     			require_once( THEME_OPTIONS	. '/'.  $alt_options_template_file );
			     			
			    		}
			 		}    
			 	}
			}
	}
	
	function theme_widgets() {		
			$alt_widgets_template_path = WIDGETS;
			$alt_widgets_template = array();
			 
			if ( is_dir($alt_widgets_template_path) ) {
				if ($alt_widgets_template_dir = opendir($alt_widgets_template_path) ) { 
					while ( ($alt_widgets_template_file = readdir($alt_widgets_template_dir)) !== false ) {
				   		if(stristr($alt_widgets_template_file, ".php") !== false) {
				   		
			     			require_once( WIDGETS	. '/'.  $alt_widgets_template_file );
			     			
			    		}
			 		}    
			 	}
			}
	}

}


?>