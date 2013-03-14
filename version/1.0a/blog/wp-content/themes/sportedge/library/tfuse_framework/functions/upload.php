<?php

function tfuse_upload($option){
	global $post;

	//$val = $option ['std'];
	$upload = $option ['std'];
	$id = $option ['id'];
	$type = $option ['type'];
	$post_type = tfuse_get_post_type();
	
	$uploader = '';
	if($post_type == "page" || $post_type == "post") 
	{
		if($type == 'slider')
			$uploader .= '<input type="hidden" id="'. $id .'_type" name="'. $id .'_type" value="upload" /> ';
		else 
			$upload = get_post_meta($post->ID , $id, true);
		
	} elseif (tfuse_option_exist ( $id )) {

		$upload = get_option ( $id );
		
	}	

	//$uploader = '<br />';
	$val = '';
	if(! empty($upload) and $type == 'upload' ) { $val = $upload; }
	
	$uploader .= '<input class="upload-input-text" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />';
	
	$uploader .= '<div class="upload_button_div"><a href="#" class="button upload_button" id="'.$id.'">Upload Image</a> ';
	
	if(!empty($upload) and $type=='upload' ) {$hide = '';} else { $hide = 'hide';}
	
	$uploader .= '<a href="#" class="button reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</a> ';
	$uploader .= '<a href="#" class="uploadtext" id="uploadtext_'. $id .'" ></a>';
	$uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
    
    $uploader .= '<a id="uploaded_image_'.$id.'" href="'. $upload . '">';
	if(!empty($upload) and $type=='upload' ){ 
		$uploader .= tfuse_get_image(150,'','img',$upload,'',true);
		}
	$uploader .= '</a>';
	$uploader .= '<div class="clear"></div>' . "\n"; 
	
	return $uploader;
	
} // END tfuse_upload



add_action('wp_ajax_tfuse_ajax_post_action', 'tfuse_ajax_upload_callback');

function tfuse_ajax_upload_callback() {
		global $wpdb, $tfuse;
		
		$clickedID = $_POST['data']; // Acts as the name
		
		//get options depending of page
		if ( !isset($_POST['page']) ) $_POST['page'] = '';
		
		if ( $_POST['page'] == 'post' ) {
			$options = get_option("{$tfuse->prefix}_post_options");
		} elseif ( $_POST['page'] == 'page' ) {
			$options = get_option("{$tfuse->prefix}_page_options");
		} elseif ( $_POST['page'] == 'admin.php' ) {
			$options = get_option("{$tfuse->prefix}_admin_options");
		} else $options = array();

		foreach ($options as $option) { 
			if(isset($option['id']) && $option['id'] == $clickedID) { $slider_options = $option; break;}
		} 
		
		
		
		//Upload
		if($_POST['type'] == 'upload'){
		
			$override['test_form'] = false;
		    $override['action'] = 'wp_handle_upload';

			$filename = $_FILES[$clickedID];
			    
		    $uploaded_file = wp_handle_upload($filename,$override);
			 
		            $upload_tracking[] = $clickedID;
		            
			 if(!empty($uploaded_file['error'])) { echo json_encode(array("error" => "Upload Error: ".$uploaded_file['error'])); }	
			 else { 
			  		if(!isset($slider_options)) $slider_options = '';
			 		echo json_encode(array(
			 					"url" 		=> $uploaded_file['url'],
			 					"fields"	=> $slider_options
			 	)); 
			 	
			 } // Is the Response
 
		}

		elseif($_POST['type'] == 'image_reset'){
			
			if(!isset($_POST['referer']))
            	delete_option($clickedID);
            else 
            	delete_post_meta($_POST['referer'] , $clickedID, get_post_meta($_POST['referer'] , $clickedID, true));
		}
		
		
  die();		
										
} //END tfuse_ajax_upload_callback()

?>