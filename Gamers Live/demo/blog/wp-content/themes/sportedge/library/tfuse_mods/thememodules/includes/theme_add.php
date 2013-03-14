<?php 

if ( ! is_admin() ) {
	add_action( 'wp_print_styles', 'tfuse_add_css' );
	add_action( 'wp_print_scripts', 'tfuse_add_js' );
	
}


/* 
This function include  files of javascript
*/

if ( ! function_exists( 'tfuse_add_js' ) ) :

	function tfuse_add_js()
	{
		$template_directory = get_template_directory_uri();

        wp_enqueue_script( 'jquery' );

		wp_register_script( 'preloadCssImages', $template_directory.'/js/preloadCssImages.js' );
		wp_enqueue_script( 'preloadCssImages' );

        wp_register_script( 'jquery.color', $template_directory.'/js/jquery.color.js' );
		wp_enqueue_script( 'jquery.color' );

        wp_register_script( 'general', $template_directory.'/js/general.js' );
        wp_enqueue_script( 'general' );

        wp_register_script( 'tools', $template_directory.'/js/jquery.tools.min.js' );
        wp_enqueue_script( 'tools' );

		wp_register_script( 'easing', $template_directory.'/js/jquery.easing.1.3.js' );
		wp_enqueue_script( 'easing' );

        wp_register_script( 'slides', $template_directory.'/js/slides.jquery.js' );
		wp_enqueue_script( 'slides' );

        wp_register_script( 'prettyPhoto', $template_directory.'/js/jquery.prettyPhoto.js' );
        wp_enqueue_script( 'prettyPhoto' );


        wp_register_script( 'jquery.preloadify', $template_directory.'/js/jquery.preloadify.min.js' );
        wp_enqueue_script( 'jquery.preloadify' );


		wp_register_script( 'jcarousel', $template_directory.'/js/jquery.jcarousel.min.js' );
		wp_enqueue_script( 'jcarousel' );

        wp_register_script( 'jquery-ui-1.8.16.custom.min', $template_directory.'/js/jquery-ui-1.8.16.custom.min.js' );
        wp_enqueue_script( 'jquery-ui-1.8.16.custom.min' );

		wp_register_script( 'ui.selectmenu', $template_directory.'/js/ui.selectmenu.js' );
		wp_enqueue_script( 'ui.selectmenu' );

        wp_register_script( 'custom', $template_directory.'/js/custom.js' );
        wp_enqueue_script( 'custom' );

		// JS is include on the footer
		wp_register_script( 'shCore', $template_directory.'/js/shCore.js', array( 'jquery' )  );
		wp_enqueue_script( 'shCore' );

		wp_register_script( 'shBrushPlain', $template_directory.'/js/shBrushPlain.js', array( 'jquery' ) );
		wp_enqueue_script( 'shBrushPlain' );

		wp_register_script( 'SyntaxHighlighter', $template_directory.'/js/SyntaxHighlighter.js', array('jquery') );
		wp_enqueue_script( 'SyntaxHighlighter' );

         wp_register_script( 'maps.google.com', 'http://maps.google.com/maps/api/js?sensor=false', array('jquery') );
         wp_enqueue_script( 'maps.google.com' );

         wp_register_script( 'jquery.gmap.min', $template_directory.'/js/jquery.gmap.min.js', array('maps.google.com') );
         wp_enqueue_script( 'jquery.gmap.min' );

         $tfuse_param = tfuse_header_parametrs();
         if ( $tfuse_param['header_element'] == 'type1' )
         {
             wp_register_script( 'bxSlider.min', $template_directory.'/js/jquery.bxSlider.min.js', array('jquery') );
             wp_enqueue_script( 'bxSlider.min' );

             wp_register_script( 'bxSlider', $template_directory.'/js/bxSlider.js', array('bxSlider.min') );
             wp_enqueue_script( 'bxSlider' );

         }

	}	// End function tfuse_add_js()

endif;

/*
This function include  files of css
*/

if ( ! function_exists( 'tfuse_add_css' ) ) :

	function tfuse_add_css()
	{
		$template_directory = get_template_directory_uri();

       // wp_register_style( 'jquery-ui-1.8.16.custom.css', $template_directory.'/css/md-theme/jquery-ui-1.8.16.custom.css'  );
      //  wp_enqueue_style( 'jquery-ui-1.8.16.custom.css' );

		wp_register_style( 'skin', $template_directory.'/images/skins/tango/skin.css' );
	//	wp_register_style( 'selectmenu', $template_directory.'/css/ui.selectmenu.css' );

		wp_enqueue_style( 'skin' );
	//	wp_enqueue_style( 'selectmenu' );

		wp_register_style( 'prettyPhoto', $template_directory.'/css/prettyPhoto.css' );
		wp_enqueue_style( 'prettyPhoto' );

        $tfuse_browser_detect = tfuse_browser_body_class();
		if (  $tfuse_browser_detect[0] == 'ie7')
        {

            wp_enqueue_style('ie-style', $template_directory.'/css/ie.css');

            global $wp_styles;
            $wp_styles->add_data( 'ie7-style', 'conditional', 'lte IE' );
        }

		wp_register_style( 'shCore', $template_directory.'/css/shCore.css' );
		wp_enqueue_style( 'shCore' );
		
		wp_register_style( 'shThemeDefault', $template_directory.'/css/shThemeDefault.css'  );
		wp_enqueue_style( 'shThemeDefault' );
        $tfuse_param = tfuse_header_parametrs();
        if ( $tfuse_param['header_element'] == 'type1' )
        {
            wp_register_style( 'bxSlider', $template_directory.'/css/bxSlider.css' );
            wp_enqueue_style( 'bxSlider' );

        }



	}	// End function tfuse_add_css()
	
endif;

?>