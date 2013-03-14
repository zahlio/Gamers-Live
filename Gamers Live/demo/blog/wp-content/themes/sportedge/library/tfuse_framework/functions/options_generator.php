<?php

//----------------------------------------------------------------------------//	

//Generate a text field
function tfuse_text($value) {

	$val = $value ['std'];
	if (tfuse_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}

	return '<input name="' . $value ['id'] . '" id="' . $value ['id'] . '" type="' . $value ['type'] . '" value="' . $val . '" />';

} //END tfuse_text()

//----------------------------------------------------------------------------//

//Generate a colorpicker field
function tfuse_colorpicker($value) {

	$val = $value ['std'];
	if (tfuse_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}

	return '<input  class="tf_color_select" name="' . $value ['id'] . '" id="' . $value ['id'] . '" type="' . $value ['type'] . '" value="' . $val . '" />';

} //END tfuse_text()

//----------------------------------------------------------------------------//	

//Generate fields with array type
function tfuse_array_type($value) {
	global $post;

	$output = '';
	foreach ( $value ['type'] as $array ) {
		$id = $array ['id'];
		$val = $array ['std'];
		$meta = $array ['meta'];
		
		if (tfuse_option_exist ( $id ))
				 $val = get_option ( $id );
		/*
		if ($_REQUEST ['page'] == 'tfuse') {
			if (tfuse_option_exist ( $id ))
				$val = get_option ( $id );
		} else {
			if (tfuse_meta_exist ( $id ))
				$val = get_post_meta ( $post->ID, $id, true );
		}
		*/
		if ($array ['type'] == 'text') {
			$output .= '<input class="input-text-small" name="' . $id . '" id="' . $id . '" type="text" value="' . $val . '" /> <span class="meta-two">' . $meta . '</span>';
		}
	}
	
	return $output;

} //END tfuse_array_type()

//----------------------------------------------------------------------------//

function tfuse_textarea($value) {
	if(!isset($value['options'])) {
		$ta_options['cols']=5;
	} else {
		$ta_options = $value['options'];
	}
    	$val = $value['std'];
    
	if (tfuse_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}

	return '<textarea name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $ta_options['cols'] .'" rows="8">'.$val.'</textarea>';
		
} //END tfuse_textarea()


//----------------------------------------------------------------------------//

function tfuse_checkbox($value) {
	
	$val = $value ['std'];
	
	if (tfuse_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}
	
	if ($val == 'true') {
		$checked = 'checked="checked"';
	} else {
		$checked = '';
	}

	$output = '<input type="checkbox" class="single_checkbox" name="' . $value ['id'] . '" id="' . $value ['id'] . '" value="true" ' . $checked . ' />';
	
	return $output;

} //END tfuse_checkbox()


//----------------------------------------------------------------------------//


//Generate multi checkboxes
function tfuse_multicheck($value) {
	global $post;
	
	$output = '';
	if(!isset($_REQUEST ['page'])) $_REQUEST ['page'] = '';
	if(!isset($_REQUEST ['taxonomy'])) $_REQUEST ['taxonomy'] = '';
	
	foreach ( $value ['options'] as $key => $option ) {
		if ($key === 0) continue;
		
		$val = $value ['std'];
		$tfuse_key = $value ['id'] . '_' . $key;
		
		if ($_REQUEST ['page'] == 'tfuse' || $_REQUEST['taxonomy'] == "category") {
			if (tfuse_option_exist ( $tfuse_key ))
				$val = get_option ( $tfuse_key );
		} else {
			if (tfuse_meta_exist ( $tfuse_key ))
				$val = get_post_meta ( $post->ID, $tfuse_key, true );
		}
		
		if ($val == 'true' or $val == $key) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		
		$output .= '
			<div class="multicheckbox"><input type="checkbox" class="checkbox" name="' . $tfuse_key . '" id="' . $tfuse_key . '" value="true" ' . $checked . ' /> 
			' . $option . '</div>';
	}
	
	return $output;

} //END tfuse_multicheck() 


//----------------------------------------------------------------------------//  

function tfuse_radio($value) {
	
	$output = '';
	foreach ( $value ['options'] as $key => $option ) {
		if ($key === 0) continue;
		
		if (tfuse_option_exist ( $value ['id'] )) {
			$val = get_option ( $value ['id'] );
		} else {
			$val = $value ['std'];
		}

		if ($val == $key) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		
		$output .= '
			<div class="multicheckbox"><input type="radio" class="checkbox ' . $value ['id'] . ' " name="' . $value ['id'] . '"  value="' . $key . '" ' . $checked . ' /> 
			' . $option . '</div>';
	}
	return $output;
	
} //END tfuse_radio()


//----------------------------------------------------------------------------//

function tfuse_select($value) {

	$output = '<select name="' . $value ['id'] . '" id="' . $value ['id'] . '">';
	
	foreach ( $value ['options'] as $key => $option ) {
		
		if (tfuse_option_exist ( $value ['id'] )) {
			$val = get_option ( $value ['id'] );
		} else {
			$val = $value ['std'];
		}
		
		if ($val == $key) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}

		
		$output .= '<option' . $selected . ' value="' . $key . '">';
		$output .= $option;
		$output .= '</option>';
	}
	
	$output .= '</select>';
	
	return $output;

} // END tfuse_select()


//----------------------------------------------------------------------------//

function tfuse_styles() {

	$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
	$alt_stylesheets = array();
	
	if ( is_dir($alt_stylesheet_path) ) {
		if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
			while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
				if(stristr($alt_stylesheet_file, ".css") !== false) {
					$alt_stylesheets[$alt_stylesheet_file] = $alt_stylesheet_file;
				}
			}    
		}
	}
	
	return $alt_stylesheets;

}  // END tfuse_styles()


//----------------------------------------------------------------------------//

function tfuse_category_template() {

	 $alt_category_template_path = TEMPLATE_CAT;
	 $alt_category_template = array();
	 
	 if ( is_dir($alt_category_template_path) ) {
	 	if ($alt_category_template_dir = opendir($alt_category_template_path) ) { 
	 		while ( ($alt_category_template_file = readdir($alt_category_template_dir)) !== false ) {
	    		if(stristr($alt_category_template_file, ".php") !== false) {
	     			$alt_category_template[$alt_category_template_file] = $alt_category_template_file;
	    		}
	 		}    
	  	}
	 }
	 
	 return $alt_category_template;
}  // END tfuse_category_template()


//----------------------------------------------------------------------------//

function tfuse_single_template() {

	 $alt_single_template_path = TEMPLATE_POST;
	 $alt_single_template = array();
	 
	 if ( is_dir($alt_single_template_path) ) {
	 	if ($alt_single_template_dir = opendir($alt_single_template_path) ) { 
	 		while ( ($alt_single_template_file = readdir($alt_single_template_dir)) !== false ) {
	    		if(stristr($alt_single_template_file, ".php") !== false) {
	     			$alt_single_template[$alt_single_template_file] = $alt_single_template_file;
	    		}
	 		}    
	  	}
	 }
	 
	 return $alt_single_template;
}  // END tfuse_single_template()


//----------------------------------------------------------------------------//

//get all categories
function tfuse_categories($args = array()) {

	if (!isset($args ['hide_empty'])) $args ['hide_empty'] = 0;
	
	$tfuse_categories = array ();
	$tfuse_categories [0] = "Select a category:";
	$tfuse_categories_obj = get_categories ( $args );
	
	if (is_array ( $tfuse_categories_obj )) {
		foreach ( $tfuse_categories_obj as $tfuse_cat ) {
			$tfuse_categories [$tfuse_cat->cat_ID] = $tfuse_cat->cat_name;
		}
	}
	 
	return $tfuse_categories;
	
}  //END tfuse_categories()


//----------------------------------------------------------------------------//

//get dropdown categories select box
function tfuse_dropdown_categories($value) {

	if(isset($value['options'])) $args = $value ['options'];
	$args ['echo'] = 0;
	
	if (tfuse_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	} else {
		$val = $value ['std'];
	}
	
	if (!isset($args['selected'])) {
		$args['selected'] = $val;
	}
	if (!isset($args['show_option_none'])) {
		$args['show_option_none'] = __ ( 'Select a category:' );
	}
	if (!isset($args['name'])) {
		$args['name'] = $value ['id'];
	}
	if (!isset($args['id'])) {
		$args['id'] = $value ['id'];
	}
	if (!isset($args['hide_empty'])) {
		$args['hide_empty'] = 0;
	}
	if (!isset($args['hierarchical'])) {
		$args['hierarchical'] = 1;
	}
	
	$tfuse_categories = wp_dropdown_categories ( $args );
	
	return $tfuse_categories;
	
} //END tfuse_dropdown_categories()


//----------------------------------------------------------------------------//

//get all pages
function tfuse_pages($args = array()) {

	if ($args == '') $args = 'sort_column=post_parent,menu_order';
	$tfuse_pages = array ();
	$tfuse_pages [0] = "Select a page:";
	$tfuse_pages_obj = get_pages ( $args );
	
	if (is_array ( $tfuse_pages_obj )) {
		foreach ( $tfuse_pages_obj as $tfuse_page ) {
			$tfuse_pages [$tfuse_page->ID] = $tfuse_page->post_title;
		}
	}
	
	return $tfuse_pages;
	
}  //END tfuse_pages()


//get all posts
function tfuse_posts($args = array()) {

	if ($args == '') $args = 'numberposts=-1';
	$tfuse_posts = array ();
	$tfuse_posts [0] = "Select a post:";
	$tfuse_posts_obj = get_posts('numberposts=-1');
	
	if (is_array ( $tfuse_posts_obj )) {
		foreach ( $tfuse_posts_obj as $tfuse_post ) {
			$tfuse_posts [$tfuse_post->ID] = $tfuse_post->post_title;
		}
	}
	
	return $tfuse_posts;
	
}  //END tfuse_posts()


//----------------------------------------------------------------------------//

//get dropdown pages select box
function tfuse_dropdown_pages($value) {

	if(isset($value['options'])) $args = $value ['options'];
	$args ['echo'] = 0;
	
	if (tfuse_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	} else {
		$val = $value ['std'];
	}
	
	if (!isset($args['selected'])) {
		$args['selected'] = $val;
	}
	if (!isset($args['show_option_none'])) {
		$args['show_option_none'] = __ ( 'Select a page:' );
	}
	if (!isset($args['name'])) {
		$args['name'] = $value ['id'];
	}
	if (!isset($args['id'])) {
		$args['id'] = $value ['id'];
	}
	if (!isset($args['hide_empty'])) {
		$args['hide_empty'] = 0;
	}
	
	$tfuse_categories = wp_dropdown_pages ( $args );
	
	return $tfuse_categories;
	
} //END tfuse_dropdown_pages()


//----------------------------------------------------------------------------//

//get all tags
function tfuse_tags($args = array('get' => 'all')) {

	if (!isset($args ['get'])) $args ['get'] = 'all';
	
	$post_txt = 'posts';
	$images_txt = 'with images';
	
	if (isset($args['short'])) {
		$post_txt = $images_txt = '';
	}
	
	$all_post_tags = array ();
	$all_post_tags = get_terms ( 'post_tag', $args );
	$tfuse_tags [0] = "Select a tag:";
	
	if (isset($args['count_images']) or isset($args['count_posts'])) {
		//get nr of posts with images for each tag
		$posts_images_tag = array ();
		foreach ( $all_post_tags as $post_tags ) {
			
			//query_posts ( "tag=" . $post_tags->slug . "" );
			$counttagposts = get_posts ( "tag=" . $post_tags->slug . "" );
			$i = 0;
			
			//The Loop
			foreach($counttagposts as $post) :
   			setup_postdata($post);
   			$key = $args['imgsource']; 
				if( tfuse_get_image(1, 1, 'src', $key, $post->ID, true) != '' ) {
					$i ++;
				}
					
			endforeach;
			
			$posts_images_tag [$post_tags->slug] = $i; //nr of posts with images for this tag	
			
			$tfuse_tags [$post_tags->slug] = $post_tags->name . " (" . $post_tags->count . " $post_txt/" . $posts_images_tag [$post_tags->slug] . " $images_txt)";
		}
		
	} //end count images
else {
		//get nr of posts with images for each tag
		foreach ( $all_post_tags as $post_tags ) {
			$tfuse_tags [$post_tags->slug] = $post_tags->name;
		
		}
	}
	
	return $tfuse_tags;
	
} //END tfuse_tags()


//----------------------------------------------------------------------------//


function tfuse_multi ($value) {
	global $post;

	$output =  '<div class="multiple_box">';
	$hidden_name = $value['id'].'_hidden';
	
	//get nr of entries
	if ($_REQUEST ['page'] == 'tfuse' || $_REQUEST['taxonomy'] == "category") {
		if (tfuse_option_exist ( $hidden_name ))
			$settings_hidden_name = get_option ( $hidden_name );
	} else {
		if (tfuse_meta_exist ( $hidden_name ))
			$settings_hidden_name = get_post_meta ( $post->ID, $hidden_name, true );
	}
	
	if(!isset($settings_hidden_name)) $settings_hidden_name = 1;
	 
	for($i = 0; $i < $settings_hidden_name; $i++)
	{
	
		if($value['subtype'] == 'page')
		{
			$select = 'Select additional page';
			$entries = get_pages('title_li=&orderby=name');
		}
		elseif($value['subtype'] == 'category')
		{
			$select = 'Select additional category';
			$entries = get_categories('title_li=&orderby=name&hide_empty=0');
		} 
		elseif($value['subtype'] == 'post')
		{
			$select = 'Select additional post';
			$entries = get_posts('numberposts=-1');
		}
		else
		{
			$select = 'Select additional category or page?';
			$entries_cat = get_categories('title_li=&orderby=name&hide_empty=0');
			$entries_page = get_pages('title_li=&orderby=name');
			$entries = array_merge($entries_page, $entries_cat);						
		}
	
		$output .=  '<select class="postform multiply_me disable_me" id="'. $value['id'] .'_'. $i .'" name="'. $value['id'] .'_'. $i .'"> ';
		$output .=  '<option value="0">'.$select .'</option>  ';
		
		$home_val = '';
		if ($_REQUEST ['page'] == 'tfuse' || $_REQUEST['taxonomy'] == "category") {
			if (tfuse_option_exist ( $value['id'] .'_'.$i ))
				$home_val = trim(get_option( $value['id'] .'_'.$i ) );
		} else {
			if (tfuse_meta_exist ( $value['id'] .'_'.$i ))
				$home_val = trim( get_post_meta( $post->ID, $value['id'] .'_'.$i, true ) );
		}
		
		if ( $home_val == "home" ) $selected = "selected='selected'";
		else                       $selected = "";
	 
	 	if ($value['subtype'] != 'category' && $value['subtype'] != 'page' && $value['subtype'] != 'post') $output .=  '<option '.$selected.' value="home">Home</option>  ';
	
		foreach ($entries as $entry)
		{
			$prefixt = '';
			
			if( $value['subtype'] == 'page' && $entry->post_title!='' )
			{
				if ($value['subtype'] != 'category' && $value['subtype'] != 'page' && $value['subtype'] != 'post') {
					$prefixt    = "Page - "; 
				}
				
				$id    = "pag_" . $entry->ID;  
				$title = $prefixt . $entry->post_title;
			}
			elseif( $value['subtype'] == 'post' && $entry->post_title!='' )
			{
				if ($value['subtype'] != 'category' && $value['subtype'] != 'page' && $value['subtype'] != 'post') {
					$prefixt    = "Post - "; 
				}
				
				$id    = "pos_" . $entry->ID;  
				$title = $prefixt . $entry->post_title;
			}
			else
			{
				if ($value['subtype'] != 'category' && $value['subtype'] != 'page' && $value['subtype'] != 'post') {
					$prefixt = "Category - ";
				} 
				
				$id    = "cat_" . $entry->term_id;
				$title = $prefixt . $entry->name;
			}
			
			$val = '';
			if ($_REQUEST ['page'] == 'tfuse' || $_REQUEST['taxonomy'] == "category") {
				if (tfuse_option_exist ( $value['id'] .'_'.$i ))
					$val = get_option( $value['id'] .'_'.$i );
			} else {
				if (tfuse_meta_exist ( $value['id'] .'_'.$i ))
					$val = get_post_meta( $post->ID, $value['id'] .'_'.$i, true );
			}
			
			if ( $val == $id ) {
				$selected = "selected='selected'";	
			} else {
				$selected = "";		
			}
			
			$output .= "<option $selected value='". $id."'>". $title."</option>";
		}
	
	$output .=  '</select>';
	} 
	
	if(isset($settings_hidden_name)) $value['std'] = $settings_hidden_name;
	
	$output .=  '<input name="'.$hidden_name.'" class="'.$hidden_name.'" type="hidden" value="'.$settings_hidden_name.'" />';
	  
	$output .=  '</div>';
	
	return $output;

}  // END tfuse_multi ()


//----------------------------------------------------------------------------//

function tfuse_boxes($value) {
	
	$output = '';
	for ($i = 1; $i <= $value['count']; $i++)
	{
		
		$output .= '<div class="option option-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
		$output .= '<label class="titledesc">'. $value['name'] .' '. $i.'</label>'."\n";
		$output .= '<div class="formcontainer">'."\n".'<div class="forminp">'."\n";
		
 		$output .= '<div class="how_to_populate">';
		
		//select box
		$output .= '<select name="'.$value['id'].$i.'" class="postform selector">';
		$output .= '<option value="">HTML (simple placeholder text gets applied) </option>';
		
		$s1 = $s2 = $s3 = '';
		$box_type = get_option( $value['id'].$i );
		if ($box_type == 'post') 	$s1 = 'selected="selected"'; 
		if ($box_type == 'page') 	$s2 = 'selected="selected"'; 
		if ($box_type == 'widget') 	$s3 = 'selected="selected"'; 
	
		$output .= '<option '.$s1.' value="post">Post</option>';
		$output .= '<option '.$s2.' value="page">Page</option>';
		$output .= '<option '.$s3.' value="widget">Widget</option>';
				
		$output .= '</select><br/>';
		
		// 3 different dropdowns:
		
		//categories
		$s1 = $s2 = $s3 = '';
		if ($box_type != "post") $s1 = "hidden";
		
		$output .= '<span class="selected_post '.$s1.'">';
		$output .= '<select class="postform" id="'.$value['id'].$i.'_post" name="'.$value['id'].$i.'_post">'; 
		$output .= '<option value="">Select post category</option>';
		
		$categories = get_categories('title_li=&orderby=name&hide_empty=0');
		foreach ($categories as $category)
		{					
			if (get_option($value['id'].$i.'_post') == $category->term_id)
			{
				$selected = "selected='selected'";	
			}
			else
			{
				$selected = "";		
			}
			
			$output .= "<option $selected value='". $category->term_id."'>". $category->name."</option>";
		}
		$output .= '</select> <br/></span>';
		
		//pages
		if ($box_type != "page") $s2 = "hidden";	
		$output .= '<span class="selected_page '.$s2.'">';
		$output .= '<select class="postform" id="'.$value['id'].$i.'_page" name="'.$value['id'].$i.'_page">'; 
		$output .= '<option value="">Select page</option>';		
		
		$pages = get_pages('title_li=&orderby=name');
 		
		foreach ($pages as $page_data)
		{
			if ( get_option($value['id'].$i.'_page') == $page_data->ID )
			{
				$selected = "selected='selected'";	
			}
			else
			{
				$selected = "";		
			}
			
			$output .= "<option $selected value='". $page_data->ID."'>". $page_data->post_title."</option>";
		}
		$output .= '</select> <br/></span>';

		//widgets
		if ($box_type != "widget") $s3 = "hidden";	
		
		$output .= '<span class="selected_widget '.$s3.'">';
		$output .= 'Please save this page, then head over to the <a href="widgets.php">widget page</a> and add widgets to the <a href="widgets.php">"'.$value['name'].' '.$i.' Widget Area"</a>';
		$output .= '</span></div><br/>';
			
		$output .= '<br/>';
		//$output .= '<input type="hidden" name="'.$values['id'].$i.'" value="'.$values['count'].$i.'" />';
		$output .= '</div><div class="desc">'. $value['desc'] .' '. $i .'</div></div>'."\n";
		$output .= '</div></div><div class="clear"></div>'."\n";
	}
	
	return $output;

} //END tfuse_boxes()


//----------------------------------------------------------------------------//

?>