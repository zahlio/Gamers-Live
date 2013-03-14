<?php

if (!isset($_REQUEST['page'])) $_REQUEST['page']='';
if (!isset($_REQUEST['tfuse_save'])) $_REQUEST['tfuse_save']='';

// Save ...
function tfuse_save_admin_options() {
	
	if ( $_REQUEST['page'] == 'tfuse' ) {
		
	 	if ( 'save' == $_REQUEST['tfuse_save'] ) {
	 	
	 		global $admin_options;
	 		return tfuse_save_options($admin_options); 
	 	
	 	} elseif ( 'reset' == $_REQUEST['tfuse_save'] ) {
	 	
			global $wpdb, $tfuse;
			$prefix = $tfuse->prefix;
			
			$query = "DELETE FROM $wpdb->options WHERE option_name LIKE 'tfuse_%'";
			$wpdb->query($query);
			
			$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '{$prefix}_%'";
			$wpdb->query($query);
			
			//header("Location: admin.php?page=tfuse&reset=true");
			//die();
			return 'reset';
		}
	}
}   // END tfuse_save_admin_options()


//---------------------------------------------//


function tfuse_save_options($options = null) {
	
	global $tfuse;
	$prefix = $tfuse->prefix;

	foreach ($options as $option) { 
	
		if(is_array($option['type'])) {  
			foreach($option['type'] as $array){
				if($array['type'] == 'text'){
					tfuse_save_text($array); 
				}
			}
		}

		switch ( $option['type'] ) {		
			case 'text':
							tfuse_save_text($option);
	        break;
	        
	        case 'checkbox':
							tfuse_save_checkbox($option);
	        break;
	        
	        case 'multicheck':
							tfuse_save_multicheck($option);
	        break;
	        
	        case 'multi':
							tfuse_save_multi($option);
	        break;
	        
	        case 'slider':
							tfuse_save_slider($option);
	        break;
	        
	        case 'boxes':
							tfuse_save_boxes($option);
	        break;
	        
 
	        default:
	        				tfuse_save_default($option);
	        
		}
	}
	
	if ( $_REQUEST['page'] == 'tfuse' && $_REQUEST['tfuse_save'] == 'save' ) {
		//header("Location: admin.php?page=tfuse&saved=true");                                
		//die;
		return 'saved';
	}	
    
}  //END tfuse_save_options()


?>