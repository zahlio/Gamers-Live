<?php

//----------------------------------------------------------------------------//	

// Save text fields
function tfuse_save_text($option) {

	$data 	 = htmlentities($_POST[$option['id']], ENT_QUOTES, 'UTF-8');
	$dataopt = stripslashes($data);
	 
	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && $_REQUEST['taxonomy'] == "category" ) {
		update_option( $option['ids'] , $dataopt);
	} elseif ($_REQUEST['taxonomy'] == "category" || $_REQUEST['page'] == 'tfuse') {
		update_option( $option['id'] , $dataopt); 
	} else {
		$post_id 	= $_POST['post_ID'];	
		update_post_meta($post_id , $option['id'], $data);
	}	
}   //END tfuse_save_text()


//----------------------------------------------------------------------------//	

// Save default fields
function tfuse_save_default($option) {

	if(!isset($option['id'])) return;
	if(!isset($_POST[$option['id']])) $_POST[$option['id']]='';
	
	$data 	 = htmlentities($_POST[$option['id']], ENT_QUOTES, 'UTF-8');
	$dataopt = stripslashes($data);
	
	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && $_REQUEST['taxonomy'] == "category") {
		//when add new category
		update_option( $option['ids'] , $dataopt);
	} elseif ($_REQUEST['taxonomy'] == "category" || $_REQUEST['page'] == 'tfuse') {
		//edit categoru and admin panel
		update_option( $option['id'] , $dataopt);
	} else {
		// add/edit page/post
		$post_id 	= $_POST['post_ID'];
		//if(get_post_meta($post_id , $option['id']) == "")
		//add_post_meta($post_id , $option['id'], $data, true);
		//elseif($data != get_post_meta($post_id , $option['id'], true))
		update_post_meta($post_id , $option['id'], $data);
		//elseif($data == "")
		//delete_post_meta($post_id , $option['id'], get_post_meta($post_id , $option['id'], true));
	}
	
}   //END tfuse_save_default()
    
    
//----------------------------------------------------------------------------//


// Save checkbox
function tfuse_save_checkbox($option) {

	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && $_REQUEST['taxonomy'] == "category") {
		if(isset( $_POST[$option['id']] )) { update_option( $option['ids'], $_POST[$option['id']] ); } else { update_option($option['ids'], 'false' ); }
	} elseif (basename($_SERVER['PHP_SELF']) == "categories.php" || $_REQUEST['taxonomy'] == "category" || $_REQUEST['page'] == 'tfuse') {
		if(isset( $_POST[$option['id']] )) { update_option( $option['id'], $_POST[$option['id']] ); } else { update_option($option['id'], 'false' ); }	     
	} else {
		if(isset($_POST[$option['id']])) { $data = $_POST[$option['id']]; } else { $data = 'false'; }
		update_post_meta($_POST['post_ID'] , $option['id'], $data);
	}
		
}   //END tfuse_save_checkbox()
    

//----------------------------------------------------------------------------//

// Save checkbox
function tfuse_save_boxes($option) {

	$id_count = $option['id'].'_count';  
	update_option( $id_count, $option['count']);
	
	for( $k=1; $k<=$option['count']; $k++){
		 
		$id_page = $option['id'].$k.'_page';
		$id_post = $option['id'].$k.'_post';
		$id_box  = $option['id'].$k; 
		
 		if(isset( $_REQUEST[$id_box])){update_option( $id_box, htmlentities($_REQUEST[ $id_box] ));} else { delete_option( htmlentities( $id_box )); } 
		if(isset( $_REQUEST[$id_page]) && $_REQUEST[$id_page] !='' ){update_option( $id_page, htmlentities($_REQUEST[ $id_page] ));} else { delete_option( htmlentities( $id_page )); } 
		if(isset( $_REQUEST[$id_post]) && $_REQUEST[$id_post] !='' ){update_option( $id_post, htmlentities($_REQUEST[ $id_post] ));} else { delete_option( htmlentities( $id_post )); } 
	}
		
}   //END tfuse_save_boxes()


    
//----------------------------------------------------------------------------//   

// Save multicheckbox
function tfuse_save_multicheck($option) {

	$id = $option['id'];
	
	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && $_REQUEST['taxonomy'] == "category") {
		
		//when add new category
		foreach($option['options'] as $key => $value) {
			if ($key === 0) continue;
			$up_opt  = $option['id']  . '_' . $key;
			$up_opts = $option['ids'] . '_' . $key;
			if(isset( $_POST[$up_opt] )) { update_option( $up_opts, $_POST[$up_opt] ); } else { update_option( $up_opts, 'false' ); }
		}

	} elseif ($_REQUEST['taxonomy'] == "category" || $_REQUEST['page'] == 'tfuse') {
	
		//edit category and admin panel
		foreach($option['options'] as $key => $value) {
			if ($key === 0) continue;
			$up_opt = $id . '_' . $key;
			if(isset( $_POST[$up_opt] )) { update_option( $up_opt, $_POST[$up_opt] ); } else { update_option( $up_opt, 'false' ); }
		}
  
	} else {
	
		$post_id 	= $_POST['post_ID'];
		
		foreach($option['options'] as $key => $value) {
			if ($key === 0) continue;
			$up_opt = $id . '_' . $key;
			if(isset($_POST[$up_opt])) { $data = $_POST[$up_opt]; } else { $data = 'false'; }
			update_post_meta($post_id , $up_opt, $data);
		}

	}
		
}   //END tfuse_save_multicheck()
    
    
//----------------------------------------------------------------------------// 

function tfuse_save_multi($option) {

	$id = $option['id'];
	$mhidden =$_REQUEST[$id . '_hidden']; 

	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && $_REQUEST['taxonomy'] == "category") {

		$ids = $option['ids'];
	
		for($i = 0; $i < $mhidden; $i++)
		{
			update_option( $ids."_".$i, $_REQUEST[$id."_".$i] );	
		}
		
		//delete old data that not ben send this time
		while(tfuse_option_exist($ids."_".$i) ) { 
			if( !isset( $_REQUEST[$id."_".$i]) ) delete_option( $ids."_".$i );
			$i++; 
		}
		
		update_option( $ids . '_hidden', $_REQUEST[$id . '_hidden'] );

	} elseif ($_REQUEST['taxonomy'] == "category" || $_REQUEST['page'] == 'tfuse') {
	
		for($i = 0; $i < $mhidden; $i++)
		{
			update_option( $id."_".$i, $_REQUEST[$id."_".$i] );	
		}
		
		//delete old data that not ben send this time
		while(tfuse_option_exist($id."_".$i) ) { 
			if( !isset( $_REQUEST[$id."_".$i]) ) delete_option( $id."_".$i );
			$i++; 
		}
		
		update_option( $id . '_hidden', $_REQUEST[$id . '_hidden'] );
  
	} else {
	
		$post_id 	= $_POST['post_ID'];
		
		for($i = 0; $i < $mhidden; $i++)
		{
			update_post_meta($post_id , $id."_".$i, $_REQUEST[$id."_".$i]);	
		}
		$i=1;

		//delete old data that not ben send this time
		while(tfuse_meta_exist($id."_".$i, $post_id) ) { //update_post_meta($post_id , $id . '_aaaaaa'.$i, $id."_".$i );
			if( !isset( $_REQUEST[$id."_".$i]) ) delete_post_meta($post_id , $id."_".$i, get_post_meta($post_id , $id."_".$i, true));
			$i++; 
		} 

		update_post_meta($post_id , $id.'_hidden', $_REQUEST[$id.'_hidden']);

	}
		
}   //END tfuse_save_multi()
    
    
//----------------------------------------------------------------------------// 

function tfuse_save_slider($option) {
	global $wpdb;	

	$id = $option['id'];
	$slider_type = $_REQUEST[$id . '_type'];
	
	//if slider type is post, save tags
	if($slider_type == 'posts') {
		$nr_of_tags = $_REQUEST[$id . '_posts_tags_hidden'];
		
		$tagsArray = array();
		for($k=0; $k<=$nr_of_tags; $k++) {
			if(!isset($_REQUEST[$id."_posts_tags_".$k])) continue;
			$newTAG = $_REQUEST[$id."_posts_tags_".$k]; 
			if (!in_array($newTAG, $tagsArray) && $newTAG!='' && $newTAG!='0')  $tagsArray[] = $newTAG;
		}	

		update_option( $id.'_type', $slider_type );
		update_option( $id.'_posts_tags', implode(',', $tagsArray) );

	}
	
	
	//if slider type is categories, save categories
	if($slider_type == 'categories') { 
		$nr_of_categories = $_REQUEST[$id . '_cat_hidden'];
		
		$categoriesArray = array();
		for($k=0; $k<=$nr_of_categories; $k++) {
			if(!isset($_REQUEST[$id."_cat_".$k])) continue;
			$newCAT = $_REQUEST[$id."_cat_".$k]; 
			if (!in_array($newCAT, $categoriesArray) && $newCAT!='' && $newCAT!='0')  $categoriesArray[] = $newCAT;
		}							

		update_option( $id.'_type', $slider_type );
		update_option( $id.'_categories', implode(',', $categoriesArray) );
 
	}
	
	
	//UPLOAD
	if($slider_type == 'upload') { 
	
		$post_type = tfuse_get_post_type();
		if(!isset($_REQUEST[$id . '_sliderdata'])) $_REQUEST[$id . '_sliderdata'] = '';
		$uploaded_imgs = $_REQUEST[$id . '_sliderdata'];
		$k = 0;
		if($uploaded_imgs) {
			foreach($uploaded_imgs as $image) {
				$k++;
				$image_data_name = $id . '_sliderdata_' . $k;
				
				foreach($option['fields'] as $field ) {
					$field_id = $field['id'];
					$field_desc = $field['desc'];
					$image[$field_id] = htmlentities($image[$field_id], ENT_QUOTES, 'UTF-8');
					if($post_type != 'post' || $post_type != 'page') $image[$field_id] = stripslashes($image[$field_id]);
					$field_val = $image[$field_id];
					if($field_val == $field_desc) $image[$field_id] = '';
				}

				//save images to db
				if($post_type == 'post' || $post_type == 'page') {
					update_post_meta($_POST['post_ID'], $image_data_name, $image);
				} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
					update_option( $image_data_name, $image );
				}
			}			

		} 
		
		//stergem imaginile vechi
		if($post_type == 'post' || $post_type == 'page') {
			//aflam cel mai mare numar de imagini ce au fost incarcate anterior
			$last_image = $wpdb->get_results( "SELECT meta_key FROM $wpdb->postmeta WHERE post_id = ".$_POST['post_ID']." AND meta_key LIKE '". $id.'_sliderdata_%' ."' " );
			$images_uploaded = array();
			foreach ($last_image as $image_name) {
				$image_number = end(explode('_',$image_name->meta_key));
				$images_uploaded[] = $image_number;
			}
			sort($images_uploaded);
			$last_image = end($images_uploaded);

			//stergem imanile de la numarul cel mai mare care au fost anterior pina la numarul imaginilor care au fost salvate acum
			for($i=$last_image;$i>$k;$i--) {
				delete_post_meta($_POST['post_ID'] , $id . '_sliderdata_' . $i, get_post_meta($_POST['post_ID'] , $id . '_sliderdata_' . $i, true));
			}
		} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
			$last_image = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE '". $id.'_sliderdata_%' ."' ORDER BY option_name DESC LIMIT 1" );
			
			if(count($last_image)>0) {
				$last_image = $last_image[0]->option_name;
				$last_image = end(explode('_',$last_image));
			
				for($i=$last_image;$i>$k;$i--) {
					delete_option($id . '_sliderdata_' . $i);
				}
			}
		}
		
		
		if ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
			update_option( $id.'_img_count', $k );
			update_option( $id.'_type', $slider_type );
		}
		
	}

	
		
}   //END tfuse_save_slider()
    
    
//----------------------------------------------------------------------------//

?>