<?php

function tfuse_get_image($width = null, $height = null, $link = 'img', $key = 'attach', $id = null, $return = false, $class = '', $rel = '', $alt = '', $before = '', $after = '', $resize = null, $quality = 100, $order = 'ASC', $sizes = 'none') {
	
	# $link = img,src      return HTML image tag or src link
	# $key  = attach,thumb,content,image    get image from attachement, from thumbinal, from post/page content or get image custom field 

	$output = '';
	$sizes_str = '';

	//set the ID
	if(empty($id)) { 
		global $post;
		if(isset($post)) $id = $post->ID; else $id = 0;
		//$id= get_the_ID();
	}
	
	if(!isset($size)) { $size = 'full';	}
	//if($key=='') { $key = 'attach'; }
	if($width==0 or $width == '') $width = null;
	if($height==0 or $height == '') $height = null;

	
	//get image from medial ibrary
		$attachments = get_children( array(
			'post_parent' => $id,
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => $order, 
			'orderby' => 'menu_order date')
		);

	    if ( !empty($attachments) ) {

		    $size = 'full';
		    foreach ( $attachments as $att_id => $attachment ) {       
		    	$src = wp_get_attachment_image_src($att_id, $size, true);
		    	$image_link_attach = $src[0];
		        break; //only one photo
		    }
	    
	    }
	//end attachement	
	    
    //get from specified custom filed like image
	$image_link_custom = get_post_meta($id, $key, true);	
	
	//ghet from thumbnail wp2.9.2
	if(function_exists('the_post_thumbnail')) {
		ob_start();
		the_post_thumbnail();
		$image_link_thumbnail = ob_get_contents();
		preg_match('/src=(["\'])(.*?)\1/', $image_link_thumbnail, $match);
		
		if ( !isset($match[2]) ) $match[2] = ''; 
		$image_link_thumbnail = $match[2];
		ob_end_clean();
	}
	

	//get image src
	if ( !isset($image_link_attach) ) $image_link_attach = '';
	if( ($key == '' or $key == "thumbnail") and isset($image_link_thumbnail) ) {	
		
		$image_link = $image_link_thumbnail;
	
	} elseif ( ($key == '' or $key == "attach") and $image_link_attach <> '') {
	
		$image_link = $image_link_attach;
		if(!isset($width) and !isset($height)) {
    		$width = $src[1];
    		$height = $src[2]; 
		}
		
	} elseif ($key <> '' and $image_link_custom <> '') {
	
		$image_link = $image_link_custom;
		
	} else {
		$image_link = $key;
	}

	
	$info = wp_check_filetype($image_link);
	if( !preg_match('/image/',$info['type']) ) return;	
	
	//set dimension if not aleardy 
	if(!isset($width) and !isset($height)) {
			$custom_size = @getimagesize($image_link);
    		$get_width = $custom_size[0];
    		$get_height = $custom_size[1]; 
    		
    		if($get_width=='') {
	    		$get_width = intval(get_option('large_size_w'));
				//$get_height = intval(get_option('large_size_h'));
    		}
    		
		}
	

	
	//image dimension
	if(!isset($width)) { $width = @$get_width; }
	if(!isset($height) && isset($get_height)) $height = $get_height;
	
	
    $set_width = ' width="' . $width .'" ';
    $set_height = ' height="' . $height .'" '; 
    
    if($height == null OR $height == ''){
        $set_height = '';
    }
    
	if($width == null OR $width == ''){
        $set_width = '';
    }
	
	
	//resize image
	if(!isset($resize)) {
		$resize = get_option(PREFIX.'_resize');
	}

	if ($resize == 'true') {
		/*
		$upload_path = get_option('upload_path');
		$upload_path = base64_encode($upload_path); 
		$img_src = get_bloginfo('template_url'). '/thumb.php?src='. $image_link .'&amp;h='. $height .'&amp;w='. $width .'&amp;zc=1&amp;q='. $quality. '&amp;updir='. $upload_path;
		 */
		$theImageSrc = $image_link;
		global $blog_id;
		if (isset($blog_id) && $blog_id > 0) {
			$imageParts = explode('/files/', $theImageSrc);
			if (isset($imageParts[1])) {
				$theImageSrc = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
			}
		}
		$image_link = $theImageSrc;
		$img_src = get_bloginfo('template_url'). '/thumb.php?src='. $image_link .'&amp;h='. $height .'&amp;w='. $width .'&amp;zc=1&amp;q='. $quality;
		
	} else { 
		$img_src = $image_link;
	}
	
	if ( $sizes == 'none' ) $sizes_str = $set_height . $set_width; else $sizes_str = '';

	//get src or img tag
	if($class <> '') { $set_class = ' class="'. $class .'" '; } else { $set_class = ''; }
	if($rel <> '') { $set_rel = ' rel="'. $rel .'" '; } else { $set_rel = ''; }
	if($alt <> '') { $set_alt = ' alt="'. $alt .'" '; } else { $set_alt = ' alt="'. get_the_title($id) .'" '; }
	
	if($link == 'img')  $img_link = '<img src="'. $img_src .'" '. $sizes_str . $set_class . $set_rel . $set_alt . ' />';
    if($link == 'src')  $img_link = $img_src;
	else                $img_link = '<img src="'. $img_src .'" '. $sizes_str . $set_class . $set_rel . $set_alt . ' />';

	
	$output .= $before; 
    $output .= $img_link;
    $output .= $after;
  
	if($return)
	{
		return $output;
	} else {
		echo $output;  
	}

 	//end tfuse_get_image()
}

?>