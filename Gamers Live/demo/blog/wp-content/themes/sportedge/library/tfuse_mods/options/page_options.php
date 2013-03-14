<?php
/* Initializes all the theme settings option fields for pages area. */
function page_option_fields(){
	global $tfuse, $page_options;
	$prefix = $tfuse->prefix;

	$page_options = array();

 	/***********************************************************
		Sidebar
	************************************************************/

 	/* Single Page */
	$page_options[] = array(	"name"    	=> "Single Page",
								"id"      	=> "{$prefix}_page_side_media",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "side");

	// Enable Single Page Comments
	$page_options[] = array( 	"name" 		=> "Disable Page Comments",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_page_single_comments",
								"std" 		=> "true",
								"type"		=> "checkbox");

	// Enable Single Page Comments
	$page_options[] = array( 	"name" 		=> "Disable Page Title",
								"desc" 		=> "Disable page title",
								"id" 		=> "{$prefix}_page_show_the_title",
								"std" 		=> "false",
								"type"		=> "checkbox");

	// Sidebar Position
	$page_options[] = array( 	"name"  	=> "Page Sidebar Position",
								"desc"  	=> "Select your preferred Page Sidebar Position.",
								"id"    	=> "{$prefix}_page_sidebar_position",
								"std"   	=> "default",
                                "options" 	=> array("default" => "Default Sidebar", "full" =>"Full Width", "left" =>"Left Sidebar", "right" =>"Right Sidebar"),
								"type"  	=> "select");
 	// Blog Category Option
	$page_options[] = array(	"name"  	=> "Blog Category",
								"desc"  	=> "Which category to display in case if you choose this page like a blog themplate.",
								"id"    	=> "{$prefix}_blog_page_cat",
								"std"   	=> "",
								"type"  	=> "dropdown_categories",
								"install"   => 'cat');


 	/***********************************************************
		Normal
	************************************************************/



 	/* Header Panel */
	$page_options[] = array(	"name"    	=> "Page Featured Tabs Options",
								"id"      	=> "{$prefix}_page_featured_tabs_options",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "normal");
								
	// Enable Single Page Comments
	$page_options[] = array( 	"name" 		=> "Enable Featured Tabs",
								"desc" 		=> "Enable Featured Tabs",
								"id" 		=> "{$prefix}_page_featured_tabs",
								"std" 		=> "false",
								"type"		=> "checkbox");
								
     $page_options[] = array(	"name" 		=> "Enter name for 'Recent Tab'",
                                "desc" 		=> "Enter your prefered name for <br />'Recent Tab'",
                                "id" 		=> "{$prefix}_page_tab_name_recent",
                                "std" 		=> "Recent",
                                "type" 		=> "text");
								
    $page_options[] = array(	"name" 		=> "Enter name for 'Popular Tab'",
                                "desc" 		=> "Enter your prefered name for <br />'Popular Tab'",
                                "id" 		=> "{$prefix}_page_tab_name_popular",
                                "std" 		=> "Popular",
                                "type" 		=> "text");
								
    $page_options[] = array(	"name" 		=> "Enter name for 'Most Commented Tab'",
                                "desc" 		=> "Enter your prefered name for <br />'Most Commented Tab'",
                                "id" 		=> "{$prefix}_page_tab_name_most_commented",
                                "std" 		=> "Most Commented",
                                "type" 		=> "text");
								
    $page_options[] = array(	"name" 		=> "Enter number of posts for 'Featured Tab'",
                                "desc" 		=> "Enter your prefered number for 'Featured Tab'",
                                "id" 		=> "{$prefix}_page_tab_number_posts",
                                "std" 		=> "7",
                                "type" 		=> "text");


 	/* Header Panel */
	$page_options[] = array(	"name"    	=> "Page Bottom Options",
								"id"      	=> "{$prefix}_page_bottom_option",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "normal");

	// Enable Single Page Comments
	$page_options[] = array( 	"name" 		=> "Enable Bottom Content",
								"desc" 		=> "Enable Bottom Boxes",
								"id" 		=> "{$prefix}_page_bottom_boxes",
								"std" 		=> "false",
								"type"		=> "checkbox");

	// Extra Widget Areas for specific Posts
	$page_options[] = array(	"name"  	=> "Category Posts",
								"desc"  	=> "Select category Posts",
								"id"    	=> "{$prefix}_page_bottom_cat",
								"type"  	=> "multi",
								"subtype" 	=> "category");


    $page_options[] = array(	"name" 		=> "Enter number of posts for 'Bottom Boxes'",
                                "desc" 		=> "Enter your prefered number for 'Bottom Boxes'",
                                "id" 		=> "{$prefix}_page_btm_number_posts",
                                "std" 		=> "7",
                                "type" 		=> "text");


 	/* Header Panel */
	$page_options[] = array(	"name"    	=> "Page Header Options",
								"id"      	=> "{$prefix}_page_slider_option",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "normal");

		/* Header Slider Thin */
	$page_options[] = array( 	"name" 		=> "Select Element of Hedear Page ",
								"desc" 		=> "This will select the type of header Page .",
								"id" 		=> "{$prefix}_page_select_header_element",
								"std" 		=> "type2",
                                "options" 	=> array("type1" => "Slider on Header", "type2" => "Image on Header"),
								"type"  	=> "select");

	// Select type of slider
	$page_options[] = array( 	"name" 		=> "Select populated method for Slider",
								"desc" 		=> "This is select the method for your BXSlider",
								"id" 		=> "{$prefix}_page_select_type_slider",
								"std" 		=> "typeslider1",
								"options" 	=> array("typeslider1" => "Category Posts", "typeslider2" => "Image uploader", "typeslider3" => "Latest Posts", "typeslider4" => "Selected Posts"),
								"type"  	=> "select");

	/* Custom Header Image */
	$page_options[] = array(	"name" 		=> "Image on Header",
								"desc" 		=> "Upload an image for your header",
								"id" 		=> "{$prefix}_page_image_header_upload",
								"std" 		=> "",
								"type" 		=> "upload");

	// Extra Widget Areas for specific Posts
	$page_options[] = array(	"name"  	=> "Selected Posts",
								"desc"  	=> "Here you can add slides for single page slider",
								"id"    	=> "{$prefix}_page_slider_posts",
								"type"  	=> "multi",
								"subtype" 	=> "post");

    
	// Blog Category Option
	$page_options[] = array(	"name"  	=> "Category Posts",
								"desc"  	=> "",
								"id"    	=> "{$prefix}_page_slider_cat",
								"std"   	=> "",
								"type"  	=> "dropdown_categories");

	$page_options[] = array( 	"name" 		=> "Insert number of post",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_page_number_post",
								"std" 		=> "2",
								"type"  	=> "text");


 	/* SliderImage Upload */
	$page_options[] = array( 	"name" 		=> "Image uploader",
								"desc" 		=> "Add content for Page Image Uploader Slider",
								"id" 		=> "{$prefix}_page_slider_data",
								"std" 		=> "",
								"type"		=> "slider",
								"c_field"	=> "{$prefix}_page_slider_image",
								"fields"	=> array(

													array(	'id' 		=> 'slider_page_title',
															'desc' 		=> 'slider title',
															'type' 		=> 'text',
															'std' 		=> ''),

                                                    array(	'id' 		=> 'slider_page_category',
                                                            'desc' 		=> 'Enter Category for Image',
                                                            'type' 		=> 'text',
                                                            'std' 		=> ''),

													array(	'id' 		=> 'slider_page_link',
															'desc' 		=> 'http://',
															'type' 		=> 'text',
															'std' 		=> ''),

                                                    array(	'id' 		=> 'slider_page_target',
                                                            'desc' 		=> 'http://',
                                                            'type' 		=> 'select',
                                                            'std' 		=> '_self',
                                                            'options'	=> array('_self' => 'Open link in same window', '_blank' => 'Open link in new window') )
                                                    ));

    /* Gallery Panel */
	$page_options[] = array(	"name"    	=> "Author Box Options",
								"id"      	=> "{$prefix}_page_author_options",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "normal");


	// Enable Single Page Comments
	$page_options[] = array( 	"name" 		=> "Enable Authors Box",
								"desc" 		=> "Enable Authors Box",
								"id" 		=> "{$prefix}_page_authors_box",
								"std" 		=> "false",
								"type"		=> "checkbox");

	// Enable Single Page Comments
	$page_options[] = array( 	"name" 		=> "Authors Title Box",
								"desc" 		=> "Authors Title Box",
								"id" 		=> "{$prefix}_page_authors_box_title",
								"std" 		=> "Our Executive team",
								"type"		=> "text");



    /* Gallery Panel */
	$page_options[] = array(	"name"    	=> "Shortcode",
								"id"      	=> "{$prefix}_page_shortcode",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "normal");

    $page_options[] = array(	"name" 		=> "Custom Shortcode before Page",
                                "desc" 		=> "Enter your prefered custom shotcode. For Blog Template Page",
                                "id" 		=> "{$prefix}_page_content_top",
                                "std" 		=> "",
                                "type" 		=> "textarea");

    $page_options[] = array(	"name" 		=> "Custom Shortcode after Page",
                                "desc" 		=> "Enter your prefered custom shotcode.",
                                "id" 		=> "{$prefix}_page_content_bottom",
                                "std" 		=> "",
                                "type" 		=> "textarea");

	if(get_option("{$prefix}_deactivate_tfuse_seo")!='true') {
	/* SEO Panel */
	$page_options[] = array(	"name"    	=> "SEO",
								"id"      	=> "{$prefix}_page_seo",
								"page"		=> "page",
								"type"		=> "metabox",
								"context"	=> "normal");

	$page_options[] = array(	"name" 		=> "Custom Post Title",
								"desc" 		=> "Enter your prefered custom title or leave blank for deafault value.",
								"id" 		=> "{$prefix}_page_seo_title",
								"std" 		=> "",
								"type" 		=> "text");

	$page_options[] = array(	"name" 		=> "Custom Post Keywords",
								"desc" 		=> "Enter your prefered custom keywords or leave blank for deafault value.",
								"id" 		=> "{$prefix}_page_seo_keywords",
								"std" 		=> "",
								"type" 		=> "textarea");

	$page_options[] = array(	"name" 		=> "Custom Post Description",
								"desc" 		=> "Enter your prefered custom description or leave blank for deafault value.",
								"id" 		=> "{$prefix}_page_seo_description",
								"std" 		=> "",
								"type" 		=> "textarea");
	
	}


 	/***********************************************************
		Advanced
	************************************************************/


	/* END custom_option_fields() */
	update_option("{$tfuse->prefix}_page_options",$page_options);
	// END custom_option_fields()
}

?>