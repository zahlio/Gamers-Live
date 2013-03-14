<?php
/* Initializes all the theme settings option fields for categories area. */
function category_option_fields(){
	global $tfuse, $category_options;
	$prefix = $tfuse->prefix;
	
	$category_options = array();
	
	/* Choise Header Bar Type */
	$category_options[] = array("name" 		=> "Choice Category Template",
								"desc" 		=> "Some themes have custom templates you can use for certain categories that might have additional features or custom layouts. If so, you'll see them above.",
								"id" 		=> "{$prefix}_category_template",
								"std" 		=> "social",
								"type"		=> "select",
								"options" 	=> tfuse_category_template());


	// Sidebar Position
	$category_options[] = array("name"  	=> "Category Sidebar Position",
								"desc"  	=> "Select your preferred Category Sidebar Position.",
								"id"    	=> "{$prefix}_category_sidebar_position",
								"std"   	=> "default",
                                "options" 	=> array("default" => "Default Sidebar", "full" =>"Full Width", "left" =>"Left Sidebar", "right" =>"Right Sidebar"),
								"type"  	=> "select");

	/* Header Slider Thin */
	$category_options[] = array("name" 	    => "Select Element of Hedear Category ",
								"desc" 		=> "This will select the type of header Category .",
								"id" 		=> "{$prefix}_category_select_header_element",
								"std" 		=> "type2",
                                "options" 	=> array("type1" => "Slider on Header", "type2" => "Image on Header"),
								"type"  	=> "select");

	/* Header Slider */
	$category_options[] = array("name"  	=> "Select populated method for Slider",
								"desc" 		=> "This is select the method for your BXSlider.",
								"id" 		=> "{$prefix}_category_type_slider",
								"std" 		=> "Select Type of Slider",
                                "options" 	=> array("typeslider1" => "Category Posts", "typeslider2" => "Latest Posts", "typeslider3" => "Selected Posts"),
								"type"  	=> "select");

	// Extra Widget Areas for specific Posts
	$category_options[] = array("name"  	=> "Selected Posts",
								"desc"  	=> "Here you can add slides for single post slider",
								"id"    	=> "{$prefix}_category_slider_posts",
								"type"  	=> "multi",
								"subtype" 	=> "post");



	/* Custom Header Image */
	$category_options[] = array("name" 		=> "Image on Header(960x142)",
								"desc" 		=> "Upload an image for your header",
								"id" 		=> "{$prefix}_category_image_header",
								"std" 		=> "",
								"type" 		=> "upload");
	// Blog Category Option
	$category_options[] = array("name"  	=> "Category Posts",
								"desc"  	=> "",
								"id"    	=> "{$prefix}_category_slider_cat",
								"std"   	=> "",
								"type"  	=> "dropdown_categories");

	$category_options[] = array("name" 		=> "Insert number of post",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_category_number_post",
								"std" 		=> "2",
								"type"  	=> "text");
	// Sidebar Position
	$category_options[] = array("name"  	=> "Enable Search",
								"desc"  	=> "Show or Hide SearchForm.",
								"id"    	=> "{$prefix}_category_title_searchform",
								"std"   	=> "true",
								"type"  	=> "checkbox");

	// Enable Single Page Comments
	$category_options[] = array("name" 		=> "Enable Featured Tabs",
								"desc" 		=> "Enable Featured Tabs",
								"id" 		=> "{$prefix}_category_featured_tabs",
								"std" 		=> "false",
								"type"		=> "checkbox");

    $category_options[] = array("name" 		=> "Enter name for 'Recent Tab'",
                                "desc" 		=> "Enter your prefered name for 'Recent Tab'",
                                "id" 		=> "{$prefix}_category_tab_name_recent",
                                "std" 		=> "Recent",
                                "type" 		=> "text");

    $category_options[] = array("name" 		=> "Enter name for 'Popular Tab'",
                                "desc" 		=> "Enter your prefered name for 'Popular Tab'",
                                "id" 		=> "{$prefix}_category_tab_name_popular",
                                "std" 		=> "Popular",
                                "type" 		=> "text");

    $category_options[] = array("name" 		=> "Enter name for 'Most Commented Tab'",
                                "desc" 		=> "Enter your prefered name for 'Most Commented Tab'",
                                "id" 		=> "{$prefix}_category_tab_name_most_commented",
                                "std" 		=> "Most Commented",
                                "type" 		=> "text");

    $category_options[] = array("name" 		=> "Enter number of post for 'Featured Tab'",
                                "desc" 		=> "Enter your prefered number for 'Featured Tab'",
                                "id" 		=> "{$prefix}_category_tab_number_posts",
                                "std" 		=> "7",
                                "type" 		=> "text");


    $category_options[] = array("name" 		=> "Custom Shortcode before Category",
                                "desc" 		=> "Enter your prefered custom shotcode.",
                                "id" 		=> "{$prefix}_category_content_top",
                                "std" 		=> "",
                                "type" 		=> "textarea");

    $category_options[] = array("name" 		=> "Custom Shortcode after Page",
                                "desc" 		=> "Enter your prefered custom shotcode.",
                                "id" 		=> "{$prefix}_category_content_bottom",
                                "std" 		=> "",
                                "type" 		=> "textarea");



	if(get_option("{$prefix}_deactivate_tfuse_seo")!='true') {
	$category_options[] = array("name" 		=> "SEO - Title",
								"desc" 		=> "Enter your prefered custom title or leave blank for deafault value.",
								"id" 		=> "{$prefix}_cat_seo_title",
								"std" 		=> "",
								"type" 		=> "text");
	
	$category_options[] = array("name" 		=> "SEO - Keywords",
								"desc" 		=> "Enter your prefered custom keywords or leave blank for deafault value.",
								"id" 		=> "{$prefix}_cat_seo_keywords",
								"std" 		=> "",
								"type" 		=> "textarea");
	
	$category_options[] = array("name" 		=> "SEO - Description",
								"desc" 		=> "Enter your prefered custom description or leave blank for deafault value.",
								"id" 		=> "{$prefix}_cat_seo_description",
								"std" 		=> "",
								"type" 		=> "textarea");
	}

	
	/* END custom_option_fields() */
	update_option("{$tfuse->prefix}_category_options",$category_options);
	// END custom_option_fields()
}

?>