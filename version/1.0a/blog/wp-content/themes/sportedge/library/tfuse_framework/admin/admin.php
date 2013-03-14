<?php
	/* Initialize the theme admin functionality. */
	add_action('init', 'tfuse_admin_init' );

	// Initializes the theme administration functions. Makes sure we have a theme settings page and a meta box on the edit post/page screen.
	function tfuse_admin_init() {
		global $tfuse;
		$prefix = $tfuse->prefix;
	
		/* Initialize the theme settings page. */
		add_action('admin_menu', 'tfuse_settings_page_init');
		
		/* Initialize the admin head js,css. Call tfuse_admin_head() from options/init_options.php */
		add_action('admin_head', 'tfuse_admin_head');
		
		/* Initialize the admin option fields. Call admin_option_fields() from options/admin_options.php */
		add_action('admin_head','admin_option_fields');
		add_action('admin_head','post_option_fields');
		add_action('admin_head','page_option_fields');
		add_action('admin_head','category_option_fields');
		//add_action('admin_head','tfuse_save_admin_options');

	}
	

	/* Initializes theme settings */
	function tfuse_settings_page_init() {
		global $tfuse, $innerdocs;

	// 30 noiembrie 2011
	$innerdocs = get_site_transient('themefuse_innerdocs_'.PREFIX);
	if (!$innerdocs)
	{
		$response = wp_remote_get( 'http://themefuse.com/pages/innerdocs/'.PREFIX.'/' );
		$innerdocs = ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
		? 'false' : ( ( maybe_unserialize( wp_remote_retrieve_body($response) ) == PREFIX ) ? 'true' : 'false' );
		set_site_transient('themefuse_innerdocs_'.PREFIX, $innerdocs, 60 * 60 * 48); // store for 48 hours
	}

		/* Get theme information. */
		$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
		
		$admin_interface_options = new AdminInterfaceOptions;
		/* Create the theme settings page. */
		if(function_exists('add_object_page')) {
			add_object_page('Page Title', $theme_data['Name'], 'read','tfuse', array($admin_interface_options, 'tfuse_create_settings_page'), ADMIN_IMAGES . '/framework-icon.png');
		} else {
			add_menu_page('Page Title', $theme_data['Name'], 'read','tfuse', array($admin_interface_options, 'tfuse_create_settings_page'), ADMIN_IMAGES . '/framework-icon.png'); 
		}
																							  // tfuse_create_settings_page() is located in admin_interface_page.php
																							  // This function generate base admin themplate

		add_submenu_page('tfuse', 'FuseFramework', 'FuseFramework', 'read', 'tfuse', array($admin_interface_options, 'tfuse_create_settings_page'));
		
		if ( is_file(WIDGETS.'/testimonial_widget.php') ) {
			$testimonials = new TestimonialOptions;																					  
			add_submenu_page('tfuse', 'Testimonials', 'Testimonials', 'read', 'tfuse_testimonials', array($testimonials, 'on_testimonials_page'));
		}

		add_submenu_page('tfuse', 'Newsletter', 'Newsletter', 'read', 'newsletter', 'tfuse_create_newsletter_page');
		
		if ( is_file(THEME_MODULES.'/shortcode_generator.php') ) {
			add_submenu_page('tfuse', 'Shortcode Generator', 'Shortcode Generator', 'read', 'shortcodes', 'tfuse_generate_shortcode_page');
		}

		add_submenu_page('tfuse', 'News & Promo', 'News & Promo', 'read', 'newspromo', 'tfuse_create_newspromo_page');
		add_submenu_page('tfuse', 'Suport', 'Support', 'read', 'support', 'tfuse_create_support_page');
		
	}


?>