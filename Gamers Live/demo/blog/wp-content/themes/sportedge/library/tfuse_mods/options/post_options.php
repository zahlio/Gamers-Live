<?php
/* Initializes all the theme settings option fields for posts area. */
function post_option_fields(){
	global $tfuse, $post_options;
	$prefix = $tfuse->prefix;
	
	$post_options = array();

	
 	/***********************************************************
		Normal
	************************************************************/

	/* Single Post */ 
	$post_options[] = array(	"name"    	=> "Single Post",
								"id"      	=> "{$prefix}_post_side_media",
								"page"		=> "post",
								"type"		=> "metabox",
								"context"	=> "side");

	/* Disable Single Post Image */
	$post_options[] = array( 	"name" 		=> "Disable Single Post Image",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_single_image",
								"std" 		=> "false",
								"type"		=> "checkbox");

	/* Disable Single Post Video */
	$post_options[] = array( 	"name" 		=> "Disable Single Post Video",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_single_video",
								"std" 		=> "true",
								"type"		=> "checkbox");

	/* Disable Single Post Video */
	$post_options[] = array( 	"name" 		=> "Disable Single Post Comments",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_single_comments",
								"std" 		=> "false",
								"type"		=> "checkbox");

    /* Enable Info about Author */
	$post_options[] = array( 	"name" 		=> "Disable Author Info Box",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_meta_about_author",
								"std" 		=> "false",
								"type"		=> "checkbox");

     /* Enable Info about Author */
	$post_options[] = array( 	"name" 		=> "Disable Social Share Buttons",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_share_button",
								"std" 		=> "false",
								"type"		=> "checkbox");

	// Enable  Page Title
	$post_options[] = array( 	"name" 		=> "Disable Published Date",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_published_date",
								"std" 		=> "false",
								"type"		=> "checkbox");
	// Enable  Page Title
	$post_options[] = array( 	"name" 		=> "Disable Category Title on bottom of the Page",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_category_title",
								"std" 		=> "false",
								"type"		=> "checkbox");

	// Sidebar Position
	$post_options[] = array( 	"name"  	=> "Post Sidebar Position",
								"desc"  	=> "Select your preferred Post Sidebar Position.",
								"id"    	=> "{$prefix}_post_sidebar_position",
								"std"   	=> "default",
                                "options" 	=> array("default" => "Default Sidebar", "full" =>"Full Width", "left" =>"Left Sidebar", "right" =>"Right Sidebar"),
								"type"  	=> "select");

	/* Post Data Panel */
	$post_options[] = array(	"name"    	=> "Post Media",
								"id"      	=> "{$prefix}_post_data",
								"page"		=> "post",
								"type"		=> "metabox",
								"context"	=> "normal");

	 /* Custom Header Image */
	$post_options[] = array(	"name" 		=> "Main Image <br> (Large format)",
								"desc" 		=> "Upload an image for your post, or specify an online address for your image (http://yoursite.com/image.png). This image is the one that loads in the lightbox and also used to replace the rest of the images if you don't specify otherwise.",
								"id" 		=> "{$prefix}_post_image",
								"std" 		=> "",
								"type" 		=> "upload");
	 /* Custom Header Image */
	$post_options[] = array(	"name" 		=> "Single Post Image",
								"desc" 		=> "Upload an image for your post, or specify an online address for your image (http://yoursite.com/image.png). This image appears when you open the post. If you don't upload an image, the resized main image will be used.",
								"id" 		=> "{$prefix}_post_image_medium",
								"std" 		=> "",
								"type" 		=> "upload");

	 /* Custom Header Image */
	$post_options[] = array(	"name" 		=> "Custom Post Video",
								"desc" 		=> "Read <a target='_blank' href='http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/'>prettyPhoto documentation</a> for info on how to add video or flash in this URL.",
								"id" 		=> "{$prefix}_post_video",
								"std" 		=> "",
								"type" 		=> "text");
								
	/* Post Data Panel */
	$post_options[] = array(	"name"    	=> "Post Media Sizes",
								"id"      	=> "{$prefix}_post_media_sizes",
								"page"		=> "post",
								"type"		=> "metabox",
								"context"	=> "normal");

	// Sidebar Position
	$post_options[] = array( 	"name"  	=> "Single Post Image Position",
								"desc"  	=> "Select your preferred Single Post Image Position",
								"id"    	=> "{$prefix}_post_image_position",
								"std"   	=> "default",
                                "options" 	=> array("default" =>"Default", "imgalignleft" =>"Left", "imgalignright" =>"Right"),
								"type"  	=> "select");

  	// Sidebar Position
    $post_options[] = array( 	"name" 		=> "Single Post Image Width",
                                "desc" 		=> "Enter Single Post Image Width",
                                "id" 		=> "{$prefix}_post_image_width",
                                "std" 		=> "",
                                "type" 		=> "text");

    $post_options[] = array( 	"name" 		=> "Single Post Image Height",
                                "desc" 		=> "Enter Single Post Image Height",
                                "id" 		=> "{$prefix}_post_image_height",
                                "std" 		=> "",
                                "type" 		=> "text");
																
	// Sidebar Position
	$post_options[] = array( 	"name"  	=> "Thumbnail Posts Position",
								"desc"  	=> "Select your preferred Thumbnail Posts Position.",
								"id"    	=> "{$prefix}_thumbnail_post_position",
								"std"   	=> "default",
                                "options" 	=> array("default" =>"Default", "imgalignleft" =>"Left", "imgalignright" =>"Right"),
								"type"  	=> "select");

    $post_options[] = array( 	"name" 		=> "Posts Thumbnail Width ",
                                "desc" 		=> "Done Posts Thumbnail Width.",
                                "id" 		=> "{$prefix}_thumbnail_post_width",
                                "std" 		=> "",
                                "type" 		=> "text");

    $post_options[] = array( 	"name" 		=> "Posts Thumbnail Height ",
                                "desc" 		=> "Done Posts Thumbnail Height.",
                                "id" 		=> "{$prefix}_thumbnail_post_height",
                                "std" 		=> "",
                                "type" 		=> "text");

	// Sidebar Position
	$post_options[] = array( 	"name"  	=> "Single Post Video Position",
								"desc"  	=> "Select your preferred Single Post Video Position.",
								"id"    	=> "{$prefix}_post_video_position",
								"std"   	=> "default",
                                "options" 	=> array("default" =>"Default", "imgalignleft" =>"Left", "imgalignright" =>"Right"),
								"type"  	=> "select");

 	// Sidebar Position
    $post_options[] = array( 	"name" 		=> "Single Post Video Width",
                                "desc" 		=> "Enter Single Post Video Width",
                                "id" 		=> "{$prefix}_post_video_width",
                                "std" 		=> "",
                                "type" 		=> "text");

    $post_options[] = array( 	"name" 		=> "Single Post Video Height",
                                "desc" 		=> "Enter Single Post Video Height",
                                "id" 		=> "{$prefix}_post_video_height",
                                "std" 		=> "",
                                "type" 		=> "text");

   	/* Header Panel */
	$post_options[] = array(	"name"    	=> "Bottom Post Options",
								"id"      	=> "{$prefix}_post_bottom_option",
								"page"		=> "post",
								"type"		=> "metabox",
								"context"	=> "normal");

    $post_options[] = array( 	"name" 		=> "Enable Bottom 'Related Posts'",
                                "desc" 		=> "Enable Bottom Related Posts",
                                "id" 		=> "{$prefix}_post_bottom_posts",
                                "std" 		=> "true",
                                "type" 		=> "checkbox");

    $post_options[] = array( 	"name" 		=> "Enter Number for 'Related Posts'",
                                "desc" 		=> "Numeber for 'Related Posts'",
                                "id" 		=> "{$prefix}_post_bottom_number",
                                "std" 		=> "3",
                                "type" 		=> "text");

   	/* Header Panel */
	$post_options[] = array(	"name"    	=> "Post Header Options",
								"id"      	=> "{$prefix}_post_slider_option",
								"page"		=> "post",
								"type"		=> "metabox",
								"context"	=> "normal");

		/* Header Slider Thin */
	$post_options[] = array( 	"name" 		=> "Select Element of Hedear Post ",
								"desc" 		=> "This will select the type of header Post .",
								"id" 		=> "{$prefix}_post_select_header_element",
								"std" 		=> "type2",
                                "options" 	=> array("type1" => "Slider on Header", "type2" => "Image on Header"),
								"type"  	=> "select");

	// Select type of slider
	$post_options[] = array( 	"name" 		=> "Select populated method for Slider",
								"desc" 		=> "This is select the method for your BXSlider",
								"id" 		=> "{$prefix}_post_select_type_slider",
								"std" 		=> "typeslider1",
								"options" 	=> array("typeslider1" => "Category Posts", "typeslider2" => "Image uploader", "typeslider3" => "Latest Posts", "typeslider4" => "Selected Posts"),
								"type"  	=> "select");

	/* Custom Header Image */
	$post_options[] = array(	"name" 		=> "Image on Header",
								"desc" 		=> "Upload an image for your header",
								"id" 		=> "{$prefix}_post_image_header",
								"std" 		=> "",
								"type" 		=> "upload");

	// Extra Widget Areas for specific Posts
	$post_options[] = array(	"name"  	=> "Selected Posts",
								"desc"  	=> "Here you can add slides for single post slider",
								"id"    	=> "{$prefix}_post_slider_posts",
								"type"  	=> "multi",
								"subtype" 	=> "post");


	// Blog Category Option
	$post_options[] = array(	"name"  	=> "Category Posts",
								"desc"  	=> "",
								"id"    	=> "{$prefix}_post_slider_cat",
								"std"   	=> "",
								"type"  	=> "dropdown_categories");

	$post_options[] = array( 	"name" 		=> "Insert number of post",
								"desc" 		=> "",
								"id" 		=> "{$prefix}_post_number_post",
								"std" 		=> "2",
								"type"  	=> "text");


 	/* SliderImage Upload */
	$post_options[] = array( 	"name" 		=> "Image uploader",
								"desc" 		=> "Add content for Post Image Uploader Slider",
								"id" 		=> "{$prefix}_post_slider_data",
								"std" 		=> "",
								"type"		=> "slider",
								"c_field"	=> "{$prefix}_post_slider_image",
								"fields"	=> array(

													array(	'id' 		=> 'slider_post_title',
															'desc' 		=> 'slider title',
															'type' 		=> 'text',
															'std' 		=> ''),

                                                    array(	'id' 		=> 'slider_post_category',
                                                            'desc' 		=> 'Enter Category for Image',
                                                            'type' 		=> 'text',
                                                            'std' 		=> ''),

													array(	'id' 		=> 'slider_post_link',
															'desc' 		=> 'http://',
															'type' 		=> 'text',
															'std' 		=> ''),

													));
    /* Gallery Panel */
	$post_options[] = array(	"name"    	=> "Shortcode",
								"id"      	=> "{$prefix}_post_shortcode",
								"page"		=> "post",
								"type"		=> "metabox",
								"context"	=> "normal");

    $post_options[] = array(	"name" 		=> "Custom Shortcode after Post",
                                "desc" 		=> "Enter your prefered custom shotcode.",
                                "id" 		=> "{$prefix}_post_content_bottom",
                                "std" 		=> "",
                                "type" 		=> "textarea");

    $post_options[] = array(	"name" 		=> "Custom Shortcode after Post",
                                "desc" 		=> "Enter your prefered custom shotcode.",
                                "id" 		=> "{$prefix}_post_content_top",
                                "std" 		=> "",
                                "type" 		=> "textarea");



	if(get_option("{$prefix}_deactivate_tfuse_seo")!='true') {
 	/* SEO Panel */
	$post_options[] = array(	"name"    	=> "SEO",
								"id"      	=> "{$prefix}_post_seo",
								"page"		=> "post",
								"type"		=> "metabox",				 
								"context"	=> "normal");
	
	$post_options[] = array(	"name" 		=> "Custom Post Title",
								"desc" 		=> "Enter your prefered custom title or leave blank for deafault value.",
								"id" 		=> "{$prefix}_post_seo_title",
								"std" 		=> "",
								"type" 		=> "text");
	
	$post_options[] = array(	"name" 		=> "Custom Post Keywords",
								"desc" 		=> "Enter your prefered custom keywords or leave blank for deafault value.",
								"id" 		=> "{$prefix}_post_seo_keywords",
								"std" 		=> "",
								"type" 		=> "textarea");
	
	$post_options[] = array(	"name" 		=> "Custom Post Description",
								"desc" 		=> "Enter your prefered custom description or leave blank for deafault value.",
								"id" 		=> "{$prefix}_post_seo_description",
								"std" 		=> "",
								"type" 		=> "textarea");													
	}


	/* END custom_option_fields() */
	update_option("{$tfuse->prefix}_post_options",$post_options);
	// END custom_option_fields()
}

?>