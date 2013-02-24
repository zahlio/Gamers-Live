<?php
/* Initializes all the theme settings option fields for admin area. */ 	
function admin_option_fields(){
	global $admin_options, $tfuse;	
	$prefix = $tfuse->prefix;
	
	$admin_options = array();  
  	
	/* General Tab */
 	$admin_options[] = array( 	"name"  	=> "General",
								"type"  	=> "tab",
								"id"    	=> "general");
	
	/* General Settings Panel */
	$admin_options[] = array( 	"name"  	=> "General Settings",
								"type"  	=> "heading");
	
	// Custom Logo Option  
	 $admin_options[] = array( "name" 		=> "Custom Logo",
								"desc" 		=> "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
								"id" 		=> "{$prefix}_logo",
								"std" 		=> "",
								"type" 		=> "upload"); 
	 
	// Custom Favicon Option  
	$admin_options[] = array( 	"name"  	=> "Custom Favicon",
								"desc"  	=> "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
								"id"    	=> "{$prefix}_custom_favicon",
								"std"   	=> "",
								"type"  	=> "upload");

	// Adress Box Text
	$admin_options[] = array(	"name"  	=> "Contact Box text",
								"desc"  	=> "Enter your Contact Adress",
								"id"    	=> "{$prefix}_custom_contact_adress",
								"std"   	=> "",
								"type"  	=> "textarea");

	// SignIn
	$admin_options[] = array(	"name"  	=> "SignIn Button",
								"desc"  	=> "Show singin buton in header",
								"id"    	=> "{$prefix}_signin_button",
								"std"   	=> "true",
								"type"  	=> "checkbox");
	// Tracking Code Option
	$admin_options[] = array( 	"name"  	=> "Tracking Code",
								"desc"  	=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
								"id"    	=> "{$prefix}_google_analytics",
								"std"   	=> "",
								"type"  	=> "textarea");
	// Custom CSS Option
	$admin_options[] = array( 	"name"  	=> "Custom CSS",
							  	"desc"  	=> "Quickly add some CSS to your theme by adding it to this block.",
								"id"    	=> "{$prefix}_custom_css",
								"std"   	=> "",
								"type"  	=> "textarea");

	/* General Settings Panel */
	$admin_options[] = array( 	"name"  	=> "Social Settings",
								"type"  	=> "heading");

	
	// RSS URL Option  
	$admin_options[] = array( 	"name"  	=> "RSS URL",
								"desc"  	=> "Enter your preferred RSS URL. (Feedburner or other)",
								"id"    	=> "{$prefix}_feedburner_url",
								"std"   	=> "",
								"type"  	=> "text");
								
	// E-Mail URL Option  
	$admin_options[] = array(	"name"  	=> "E-Mail URL",
								"desc"  	=> "Enter your preferred E-mail subscription URL. (Feedburner or other)",
								"id"    	=> "{$prefix}_feedburner_id",
								"std"   	=> "",
								"type"  	=> "text");
	// Twitter URL
	$admin_options[] = array(	"name"  	=> "Twitter URL",
								"desc"  	=> "Enter Twitter URL",
								"id"    	=> "{$prefix}_twitter",
								"std"   	=> "",
								"type"  	=> "text");
	// Facebook URL
	$admin_options[] = array(	"name"  	=> "Facebook URL",
								"desc"  	=> "Enter Facebook URL",
								"id"    	=> "{$prefix}_facebook",
								"std"   	=> "",
								"type"  	=> "text");
	// Flickr URL
	$admin_options[] = array(	"name"  	=> "Flickr URL",
								"desc"  	=> "Enter Flickr URL",
								"id"    	=> "{$prefix}_flickr",
								"std"   	=> "",
								"type"  	=> "text");

	
	/* Sidebar Panel */
	$admin_options[] = array(	"name"  	=> "Sidebar",
					    	  	"type"  	=> "heading"); 
								
	// Sidebar Position  
	$admin_options[] = array( 	"name"  	=> "Default Sidebars Position",
								"desc"  	=> "Select your preferred Default Sidebars Position.",
								"id"    	=> "{$prefix}_sidebar_position",
								"std"   	=> "left",
                                "options" 	=> array("full" =>"Full Width", "left" =>"Left Sidebar", "right" =>"Right Sidebar"),
								"type"  	=> "select");        

	// Extra Widget Areas for specific Pages Option  
 	$admin_options[] = array(	"name"  	=> "Extra Widget Areas for specific Pages",
								"desc"  	=> "Here you can add widget areas for single pages. That way you can put different content for each page into your sidebar.<br/>
												After you have choosen the Pages press the 'Save Changes' button and then start adding widgets to your new widget areas <a href='widgets.php'>here</a>.<br/><br/>
												<strong>Attention</strong> when removing areas: You have to be carefull when deleting widget areas that are not the last one in the list.<br/> It is recommended to avoid this. If you want to know more about this topic please read the documentation that comes with this theme.<br/>",
								"id"    	=> "{$prefix}_multi_widget_pages",
								"type"  	=> "multi",
								"subtype" 	=> "page");
	
	// Extra Widget Areas for specific Categories Option  
	$admin_options[] = array(	"name"  	=> "Extra Widget Areas for specific Categories",
								"desc"  	=> "Here you can add widget areas for single categories. That way you can put different content for each category into your sidebar.<br/>
												After you have choosen the Pages press the 'Save Changes' button and then start adding widgets to your new widget areas <a href='widgets.php'>here</a>.<br/><br/>
												<strong>Attention</strong> when removing areas: You have to be carefull when deleting widget areas that are not the last one in the list.<br/> It is recommended to avoid this. If you want to know more about this topic please read the documentation that comes with this theme.<br/>",
								"id"    	=> "{$prefix}_multi_widget_categories",
								"type"  	=> "multi",
								"subtype" 	=> "category");
	
	// Extra Widget Areas for specific Posts  
	$admin_options[] = array(	"name"  	=> "Extra Widget Areas for specific Posts",
								"desc"  	=> "Here you can add widget areas for single post. That way you can put different content for each post into your sidebar.<br/>
												After you have choosen the Posts press the 'Save Changes' button and then start adding widgets to your new widget areas <a href='widgets.php'>here</a>.<br/><br/>
												<strong>Attention</strong> when removing areas: You have to be carefull when deleting widget areas that are not the last one in the list.<br/> It is recommended to avoid this. If you want to know more about this topic please read the documentation that comes with this theme.<br/>",
								"id"    	=> "{$prefix}_multi_widget_posts",
								"type"  	=> "multi",
								"subtype" 	=> "post");
	
	/* Lightbox (prettyPhoto) Panel */
	$admin_options[] = array(   "name"  	=> "Lightbox (prettyPhoto)",
								"type"  	=> "heading");    

	// Disable posts lightbox (prettyPhoto) Option  
	$admin_options[] = array(	"name"  	=> "Disable lightbox",
								"desc"  	=> "Disable lightbox (prettyPhoto)",
								"id"    	=> "{$prefix}_disable_lightbox",
								"std"   	=> "false",
								"type"  	=> "checkbox");

	/* Disable SEO options */
	$admin_options[] = array(   "name"  	=> "Disable SEO options",
								"type"  	=> "heading");

	// Disable SEO
	$admin_options[] = array(	"name"  	=> "Disable SEO",
								"desc"  	=> "Disable framework SEO options",
								"id"    	=> "{$prefix}_deactivate_tfuse_seo",
								"std"   	=> "false",
								"type"  	=> "checkbox");
	
	/* Dynamic Images Panel */
	$admin_options[] = array( 	"name"  	=> "Dynamic Images",
								"type"  	=> "heading");    
	
	// Enable Dynamic Image Resizer Option  
	$admin_options[] = array( 	"name"  	=> "Enable Dynamic Image Resizer",
								"desc"  	=> "This will enable the thumb.php script. It dynamicaly resizes images on your site.",
								"id"    	=> "{$prefix}_resize",
								"std"   	=> "false",
								"type"  	=> "checkbox");    

    $admin_options[] = array( "name" => "Ads - Widget (300x250px)",
                        "type" => "heading");

    $admin_options[] = array( "name" => "Adsense code",
                        "desc" => "Enter your adsense code (or other ad network code) here.",
                        "id" => "{$prefix}_ad_300_adsense",
                        "std" => "",
                        "type" => "textarea");

    $admin_options[] = array( "name" => "Image Location",
                        "desc" => "Enter the URL for this banner ad.",
                        "id" => "{$prefix}_ad_300_image",
                        "std" => "http://themefuse.com/banners/300x250.jpg",
                        "type" => "upload");

    $admin_options[] = array( "name" => "Destination URL",
                        "desc" => "Enter the URL where this banner ad points to.",
                        "id" => "{$prefix}_ad_300_url",
                        "std" => "http://themefuse.com",
                        "type" => "text");

	 /* Footer Tab */
	$admin_options[] = array( 	"name"  	=> "Posts",
								"type"  	=> "tab",
								"id"    	=> "posts");

	$admin_options[] = array(   "name"  	=> "Posts Options",
								"type"  	=> "heading");

	
	$admin_options[] = array( 	"name"  	=> "Default Single Post Image Position",
								"desc"  	=> "Select your preferred Single Post Image Position",
								"id"    	=> "{$prefix}_image_posts_position",
								"std"   	=> "left",
                                "options" 	=> array("imgalignleft" =>"Left", "imgalignright" =>"Right"),
								"type"  	=> "select");

	// Sidebar Position
    $admin_options[] = array( 	"name" 		=> "Single Post Image Width",
                                "desc" 		=> "Enter Single Post Image Width",
                                "id" 		=> "{$prefix}_single_posts_width",
                                "std" 		=> "620",
                                "type" 		=> "text");

    $admin_options[] = array( 	"name" 		=> "Single Post Image Height",
                                "desc" 		=> "Enter Single Post Image Height",
                                "id" 		=> "{$prefix}_single_posts_height",
                                "std" 		=> "380",
                                "type" 		=> "text");
	
 	$admin_options[] = array( 	"name"  	=> "Default Thumbnail Post Position",
								"desc"  	=> "Select your preferred Thumbnail Post Position.",
								"id"    	=> "{$prefix}_thumbnail_posts_position",
								"std"   	=> "left",
                                "options" 	=> array("imgalignleft" =>"Left", "imgalignright" =>"Right"),
								"type"  	=> "select");

    $admin_options[] = array( 	"name" 		=> "Post Thumbnail Width ",
                                "desc" 		=> "Enter Post Thumbnail Width",
                                "id" 		=> "{$prefix}_thumbnail_posts_width",
                                "std" 		=> "120",
                                "type" 		=> "text");

    $admin_options[] = array( 	"name" 		=> "Post Thumbnail Height ",
                                "desc" 		=> "Enter Post Thumbnail Height",
                                "id" 		=> "{$prefix}_thumbnail_posts_height",
                                "std" 		=> "100",
                                "type" 		=> "text");
 
	$admin_options[] = array( 	"name"  	=> "Default Single Post Video Position",
								"desc"  	=> "Select your preferred Single Post Video Position",
								"id"    	=> "{$prefix}_video_posts_position",
								"std"   	=> "left",
                                "options" 	=> array("imgalignleft" =>"Left", "imgalignright" =>"Right"),
								"type"  	=> "select");

	// Sidebar Position
    $admin_options[] = array( 	"name" 		=> "Single Post Video Width",
                                "desc" 		=> "Enter Single Post Video Width",
                                "id" 		=> "{$prefix}_single_posts_video_width",
                                "std" 		=> "620",
                                "type" 		=> "text");

    $admin_options[] = array( 	"name" 		=> "Single Post Video Height",
                                "desc" 		=> "Enter Single Post Video Height",
                                "id" 		=> "{$prefix}_single_posts_video_height",
                                "std" 		=> "380",
                                "type" 		=> "text");
  								
	$admin_options[] = array(	"name"  	=> "Disable Author Info Box",
								"desc"  	=> "Disable Single Post Author Info Box",
								"id"    	=> "{$prefix}_disable_author_info_box",
								"std"   	=> "",
								"type"  	=> "checkbox");
  								
	$admin_options[] = array(	"name"  	=> "Disable Comments",
								"desc"  	=> "Disable Single Post Comments",
								"id"    	=> "{$prefix}_disable_single_post_comments",
								"std"   	=> "",
								"type"  	=> "checkbox");
  								
	$admin_options[] = array(	"name"  	=> "Disable Social Share Buttons",
								"desc"  	=> "Disable Social Share Buttons",
								"id"    	=> "{$prefix}_disable_social_share_buttons",
								"std"   	=> "",
								"type"  	=> "checkbox");
  								
	$admin_options[] = array(	"name"  	=> "Disable Published Date",
								"desc"  	=> "Disable Published Date",
								"id"    	=> "{$prefix}_disable_published_date",
								"std"   	=> "",
								"type"  	=> "checkbox");
								
	 /* Footer Tab */
	$admin_options[] = array( 	"name"  	=> "Footer",
								"type"  	=> "tab",
								"id"    	=> "footer");
	
	$admin_options[] = array(   "name"  	=> "Footer Content",
								"type"  	=> "heading");

    $admin_options[] = array( 	"name" 		=> "Footer Menu Title",
                                "desc" 		=> "Enter your title for menu.",
                                "id" 		=> "{$prefix}_footer_menu_name",
                                "std" 		=> "Footer Menu",
                                "type" 		=> "text");
	
	$admin_options[] = array( 	"name" 		=> "Footer Shortcodes",
								"desc" 		=> "Enter footer shortcodes.",
								"id" 		=> "{$prefix}_footer_shortcodes",
								"std" 		=> "",
								"type" 		=> "textarea");

	 /* ColorPicker Tab */
	$admin_options[] = array( 	"name"  	=> "Theme Style",
								"type"  	=> "tab",
								"id"    	=> "colorpicker");

    $admin_options[] = array(   "name"  	=> "Image Header",
                                "type"  	=> "heading");

    $admin_options[] = array( 	"name" 		=> "Header Pattern Background",
                                "desc" 		=> "Choose pattern background for header. Note that this will be overwritten if you have a Custom Header Background uploaded.",
                                "id" 		=> "{$prefix}_header_pattern_background",
                                "std" 		=> "header_golf.jpg",
                                "options" 	=> array("none" =>"No Image on Header", "header_golf.jpg" =>"Golf Header Image", "header_mlb.jpg" =>"Major league Baseball Header Image",  "header_nascar.jpg" =>"Nascar Header Image", "header_nba.jpg" =>"Basketball Header Image", "header_nfl.jpg" =>"American Football Header Image", "header_nhl.jpg" =>"Hockey Header Image", "header_soccer.jpg" =>"Soccer Header Image", "header_tennis.jpg" =>"Tennis Header Image"),
                                "type" 		=> "select");

	// Custom Header Option
	 $admin_options[] = array( "name" 		=> "Custom Header Image",
								"desc" 		=> "Upload a header image for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
								"id" 		=> "{$prefix}_header_image",
								"std" 		=> "",
								"type" 		=> "upload");


    $admin_options[] = array(   "name"  	=> "ColorPicker Options",
								"type"  	=> "heading");

    $admin_options[] = array( 	"name" 		=> "Header Background Color",
                                "desc" 		=> "Choose background Color",
                                "id" 		=> "{$prefix}_header_colorpicker",
                                "std" 		=> "",
                                "type" 		=> "colorpicker");

    $admin_options[] = array( 	"name" 		=> "Body Background Color",
                                "desc" 		=> "Choose background color for middle",
                                "id" 		=> "{$prefix}_body_colorpicker",
                                "std" 		=> "",
                                "type" 		=> "colorpicker");

    $admin_options[] = array( 	"name" 		=> "Footer Background Color",
                                "desc" 		=> "Choose background color for footer",
                                "id" 		=> "{$prefix}_footer_colorpicker",
                                "std" 		=> "",
                                "type" 		=> "colorpicker");


	if(get_option("{$prefix}_deactivate_tfuse_seo")!='true') { 
 	 /* SEO Tab */
	$admin_options[] = array( 	"name"  	=> "SEO",
								"type"  	=> "tab",
								"id"    	=> "seo");
	
	$admin_options[] = array(   "name"  	=> "META Data for HomePage",
								"type"  	=> "heading");
	
	$admin_options[] = array( 	"name" 		=> "Home Page Title",
								"desc" 		=> "Enter custom title for home page.",
								"id" 		=> "{$prefix}_homepage_title",
								"std" 		=> "",
								"type" 		=> "text");
	
	$admin_options[] = array( 	"name" 		=> "Keywords",
								"desc" 		=> "Enter custom keywords for home page.",
								"id" 		=> "{$prefix}_homepage_keywords",
								"std" 		=> "",
								"type" 		=> "textarea");
	
	$admin_options[] = array( 	"name" 		=> "Description",
								"desc" 		=> "Enter custom description for home page.",
								"id" 		=> "{$prefix}_homepage_description",
								"std" 		=> "",
								"type" 		=> "textarea");
	

	$admin_options[] = array(   "name"  	=> "General META",
								"type"  	=> "heading");
	
	$admin_options[] = array( 	"name" 		=> "Keywords",
								"desc" 		=> "Enter general keywords for home page, categories, arhives and other pages than single posts and pages.",
								"id" 		=> "{$prefix}_general_keywords",
								"std" 		=> "",
								"type" 		=> "textarea");
	
	$admin_options[] = array( 	"name" 		=> "Description",
								"desc" 		=> "Enter general description for home page, categories, arhives and other pages than single posts and pages.",
								"id" 		=> "{$prefix}_general_description",
								"std" 		=> "",
								"type" 		=> "textarea");
	}
	

									
	/* END admin_option_fields() */
	update_option("{$tfuse->prefix}_admin_options",$admin_options);
	// END admin_option_fields()
}

?>