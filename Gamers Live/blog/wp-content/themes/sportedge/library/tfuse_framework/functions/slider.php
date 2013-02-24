<?php

function tfuse_slider($option) {
	global $post;
	
	$output = '';	
	$output .= '<div class="option option-' . $option ['type'] . '">' . "\n" . '<div class="option-inner">' . "\n";
	$output .= '<label class="titledesc">' . $option ['name'] . ' </label>' . "\n";
	$output .= '<div class="formcontainer">' . "\n" . '<div class="forminp">' . "\n";
	
	$output .= '<div class="how_to_populate">';
	
	if(basename($_SERVER['PHP_SELF']) == "page.php" 
	|| basename($_SERVER['PHP_SELF']) == "page-new.php" 
	|| basename($_SERVER['PHP_SELF']) == "post-new.php" 
	|| basename($_SERVER['PHP_SELF']) == "post.php"
	|| basename($_SERVER['PHP_SELF']) == "media-upload.php") 
	{
		$slider_type = 'upload';
			
	} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {

			//select slider type
			$output .= 'Select populate method for slideshow';
			$output .= '<select class="postform selector" id="' . $option ['id'] . '_type" name="' . $option ['id'] . '_type"> ';
			
			$s1 = $s2 = $s3 = $h1 = $h2 = $h3 = '';
			
			$slider_type = get_option ( $option ['id'] . '_type' );
		
			if ($slider_type == 'posts') {
				$s1 = 'selected="selected"';
			} elseif ($slider_type == 'categories') {
				$s2 = 'selected="selected"';
			} elseif ($slider_type == 'upload') {
				$s3 = 'selected="selected"';
			} else {
				//selected by defoult
				$s3 = 'selected="selected"';
			}
			
			$output .= '<option ' . $s1 . ' value="posts">Get images from posts</option>' . "\n";
			$output .= '<option ' . $s2 . ' value="categories">Get images from categories</option>' . "\n";
			$output .= '<option ' . $s3 . ' value="upload">Upload your own images</option>' . "\n";
			$output .= '</select>' . "\n";
	
		
		//------ get from posts ------//
		if ($slider_type != "posts") $h1 = "hidden";
		$output .= '<span class="selected_posts ' . $h1 . '">' . "\n";
	
		$all_post_tags = tfuse_tags(array('count_images' => 1, 'imgsource' => $option ['c_field']));
		
		if (count ( $all_post_tags ) > 1) {
			
			//create a multiple box
			$output .= '<div class="multiple_box">';
			$hidden_name_posts = $option ['id'] . '_posts_tags_hidden';
	
			$tagsList = get_option ( $option ['id'] . "_posts_tags" );
			
			$tagsArray = array();
			if ($tagsList != '') $tagsArray = explode ( ",", $tagsList );
	
			$settings_hidden_name_posts = count ( $tagsArray );
			
			if ($settings_hidden_name_posts == 0) {
				$settings_hidden_name_posts = 1;
				//$tagsArray[0]=0;
			}
			else {
				$settings_hidden_name_posts ++;
			}
				
			//create multiple selects
			for($i = 0; $i < $settings_hidden_name_posts; $i ++) {
				$output .= '<select class="postform multiply_me disable_me" id="' . $option ['id'] . '_posts_tags_' . $i . '" name="' . $option ['id'] . '_posts_tags_' . $i . '"> ' . "\n";
				$tags = '';
				//get tags list
				foreach ( $all_post_tags as $key => $tag_name ) {
					
					if(isset($tagsArray[$i])) $val1 = $tagsArray [$i]; else $val1 = ''; //strtolower ( trim ( $tagsArray [$i] ) );
					$val2 = $key; //strtolower ( trim ( $tags_data->name ) );
					
					if ($val1 == $val2) {
						$selected = "selected='selected'";
					} else {
						$selected = "";
					}
					
					$tags .= "<option $selected value='" . $key . "'>" . $tag_name . "</option>";
				}
				$output .= $tags;
				//$tags = '';
				$output .= '</select>' . "\n";
			
			}
			
			//if(isset($settings_hidden_name)) $option['std'] = $settings_hidden_name;		
			$output .= '<input name="' . $hidden_name_posts . '" class="' . $hidden_name_posts . '" type="hidden" value="' . $settings_hidden_name_posts . '" />' . "\n";
			$output .= '</div>' . "\n" . "\n";
		
		} else {
			//if no tags
			$output .= '1. Please go to the <a href="edit-tags.php">tags page</a> and add a tag that you would like to have displayed in the slideshow." <br />
									2. Add this tag to posts witch have images for slideshow. 
									';
		}
		
		$output .= "</span>";
		//end posts
		
	
		//------ get from categories ------//
		if ($slider_type != "categories") $h2 = "hidden";
		$output .= '<span class="selected_categories ' . $h2 . '">' . "\n";
	
		$all_categories = tfuse_categories();
		$categories = '';
		
		if (count ( $all_categories ) > 1) {
			
			//create a multiple box
			$output .= '<div class="multiple_box">';
			$hidden_name_cat = $option ['id'] . '_cat_hidden';
			
			$categoriesList = get_option ( $option ['id'] . "_categories" );
			
			$categoriesArray = array();
			if ($categoriesList != '') $categoriesArray = explode ( ",", get_option ( $option ['id'] . "_categories" ) );
			
			$settings_hidden_name_cat = count ( $categoriesArray );
			
			if ($settings_hidden_name_cat == 0) {
				$settings_hidden_name_cat = 1;
				//$categoriesArray[0] = 0;
			} else {
				$settings_hidden_name_cat ++;
			}
				
			//create multiple selects
			for($i = 0; $i < $settings_hidden_name_cat; $i ++) {
				$output .= '<select class="postform multiply_me disable_me" id="' . $option ['id'] . '_cat_' . $i . '" name="' . $option ['id'] . '_cat_' . $i . '"> ' . "\n";
	
				//get categories list
				foreach ( $all_categories as $key => $cat_name ) {
					
					if(isset($categoriesArray[$i])) $val1 = $categoriesArray [$i]; else $val1=''; //strtolower ( trim ( $tagsArray [$i] ) );
					$val2 = $key; //strtolower ( trim ( $tags_data->name ) );
					
					if ($val1 == $val2) {
						$selected = "selected='selected'";
					} else {
						$selected = "";
					}
					
					$categories .= "<option $selected value='" . $key . "'>" . $cat_name . "</option>";
				}
				$output .= $categories;
				$categories = '';
				$output .= '</select>' . "\n";
			
			}
			
			//if(isset($settings_hidden_name)) $option['std'] = $settings_hidden_name;		
			$output .= '<input name="' . $hidden_name_cat . '" class="' . $hidden_name_cat . '" type="hidden" value="' . $settings_hidden_name_cat . '" />' . "\n";
			$output .= '</div>' . "\n" . "\n";
		
		}
		
		$output .= "</span>";
		//end categories
	
	} // END admin page
	
	
	
	
	
	
	
	//------ upload ------//
	if (! isset ( $slider_type ) || $slider_type == '') $slider_type = 'upload';
	$h3 = '';
	if ($slider_type != "upload") $h3 = "hidden";
	
	$output .= '<span class="selected_upload ' . $h3 . '">' . "\n";
	$output .= tfuse_upload( $option );
	
	$out_ID = $option ['id'];

	$template_url = get_bloginfo ( 'template_url' );
	
	$output .= '<ul id="files_' . $option ['id'] . '" class="slider">' . "\n";
	
	$out_count_images = 0;
	//count images
	if(basename($_SERVER['PHP_SELF']) == "page.php" 
	|| basename($_SERVER['PHP_SELF']) == "page-new.php" 
	|| basename($_SERVER['PHP_SELF']) == "post-new.php" 
	|| basename($_SERVER['PHP_SELF']) == "post.php"
	|| basename($_SERVER['PHP_SELF']) == "media-upload.php") 
	{
		$k = 1;
		while( tfuse_meta_exist($out_ID . "_sliderdata_" . $k, $post->ID) ) {
			$out_count_images++;
			$k++;
		}
		
	} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
		$out_count_images = get_option( $out_ID . "_img_count" );
	}
	
	for($k = 1; $k <= $out_count_images; $k ++) {

		if(basename($_SERVER['PHP_SELF']) == 'post.php' || basename($_SERVER['PHP_SELF']) == 'page.php' ) {
			$image = get_post_meta( $post->ID, $out_ID . "_sliderdata_" . $k, true );
		} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
			$image = get_option( $out_ID . "_sliderdata_" . $k );
		}
		if(!$image) continue;

		$output .= '<li class="ui-state-default">';
		$output .= '<input type="hidden" name="'.$out_ID.'_sliderdata['.$k.'][img]" value="'.$image["img"].'" />';
		$output .= '<table class="added_image"><tr><td width="60px" valign="top">';
		$output .= tfuse_get_image(50,'','img',$image["img"],'',true);
		$output .= '<br/><br/><img src="'.ADMIN_IMAGES.'/drag.png" alt="Drag" title="Drag and Move this item" />';
		$output .= '</td><td valign="top">';
		$output .= '<div>'.basename($image["img"]).'<div style="float:right; width:35px;"><a href="#" class="remove" onclick="return false" ><img src="'.ADMIN_IMAGES.'/bin.gif" alt="Remove" title="Remove" /></a></div></div>';

		foreach($option['fields'] as $field ) {
			$field_id = $field['id'];
			$field_desc = $field['desc'];
			$field_val = $image[$field_id];		
			
			if($field['type']=='text') {
				$output .= '<div><input type="text" name="'.$out_ID.'_sliderdata['.$k.']['.$field_id.']" value="'.$field_val.'" class="slider_text slider_'.$field_id.'" title="'.$field_desc.'"  /></div>';
			} elseif ($field['type'] == 'textarea') {
				$output .= '<div><textarea name="'.$out_ID.'_sliderdata['.$k.']['.$field_id.']" class="slider_textarea slider_'.$field_id.'" title="'.$field_desc.'" >' .$field_val. '</textarea></div>';  
			} elseif ($field['type'] == 'select') {
				$output .= '<div><select name="'.$out_ID.'_sliderdata['.$k.']['.$field_id.']" class="slider_select slider_'.$field_id.'" >';

				foreach($field['options'] as $fkey => $fvalue)
				{
					$selected = '';
					if($fkey == $field_val) $selected = ' selected="selected"';
					$output .= '<option '.$selected.' value="'.$fkey.'" >' . $field["options"][$fkey] . '</option>';
				}
				$output .= '</select></div>';
				  
			}	
		}
		$output .= '</td></tr></table>';
		$output .= '</li>' . "\n";	
	}
	$output .= '</ul>' . "\n";
	$output .= '<input name="'.$out_ID .'_img_count" class="'.$out_ID .'_img_count" type="hidden" value="' . $out_count_images . '" />' . "\n";
	$output .= '</span>' . "\n";
	//end upload
	
	$output .= '</div><br/>' . "\n";
	
	$output .= '</div><div class="desc">' . $option ['desc'] . ' </div></div>' . "\n";
	$output .= '</div></div><div class="clear"></div>' . "\n";
	
	return $output;

} // END tfuse_slider()


?>