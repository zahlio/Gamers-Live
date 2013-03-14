<?php

// Generate custom fields
	
function tfuse_options_page_content($get_option = null, $only_form = false) {
	global $admin_options, $tfuse, $innerdocs;
	$prefix = $tfuse->prefix;

    $counter 		= 0;
    $draw_tabs_li 	= '';
    $heading_open 	= false;
    $tab_open 		= false;

    if(empty($get_option)) {
    	$options     = $admin_options;
    } else {
    	$options     = $get_option;
    }

    $output = '';
    foreach ($options as $value) {

    	if ($only_form === false && $value['type'] != "heading" && $value['type'] != "boxes"  && $value['type'] != "slider" && $value['type'] != "tab" && $value['type'] != "metabox" )
         {
            // 30 noiembrie 2011
            if ( $innerdocs != 'true' )
                $title = $value['name'];
            else
                $title = ( empty($value['help']) ) ? $value['name'] : '<a rel="prettyPhoto[iframes]" title="Click for help" href="http://themefuse.com/pages/innerdocs/'.PREFIX.'/help.php?page='.$value['help'].'&iframe=true&width=700&height=100%">'.$value['name'].'</a>';
             
            $output .= '<div class="option option-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
            $output .= '<label class="titledesc">'. $title .'</label>'."\n";
            $output .= '<div class="formcontainer">'."\n".'<div class="forminp">'."\n";
         }
    
        if ( is_array($value['type']) ) $output .= tfuse_array_type($value);
         
		switch ( $value['type'] ) {	        
	        case "heading":  
	            if($heading_open){
	               $output .= '</div>'."\n";
	               $heading_open = false;
	            }
	     
	            $output .= '<div class="title postbox metabox-holder">';
	            $output .= '<p class="submit"><input name="save" type="submit" value="Save All Changes" /></p>';
			    $output .= '<h3 class="hndle"><span>'. $value['name'] .'</span></h3>'."\n";    
	            $output .= '</div>'."\n";
	            $output .= '<div class="option_content inside">'."\n";
	            $heading_open = true;
	            
	        break;
	        
	        case "tab":
	        
	         if($tab_open) { $output .= "</div></div>\n"; $tab_open = false; }
	        
				$draw_tabs_li .= '<li><a href="#tab_'.$value['id'].'">'.$value['name'].'</a></li>'."\n";
				$output    .= '<div id="tab_'.$value['id'].'">'."\n";
				$tab_open = true;
				$heading_open = false;
				
			break;
			
			
			case 'text':
	             $output .= 		tfuse_text($value);
	        break;
	        
	        case 'textarea':
				 $output .= 		tfuse_textarea($value);
        	break;
	        
			case 'select':
				 $output .= 		tfuse_select($value);
        	break;
        	
        	case 'radio':
				 $output .= 		tfuse_radio($value);
        	break;
        	
        	case 'checkbox':
				 $output .= 		tfuse_checkbox($value);
        	break;
        	
        	case 'multicheck':
				 $output .= 		tfuse_multicheck($value);
        	break;        	
        	
        	case 'dropdown_categories':
				 $output .= 		tfuse_dropdown_categories($value);
        	break;
        	
        	case 'dropdown_pages':
				 $output .= 		tfuse_dropdown_pages($value);
        	break;
        	
        	case 'upload':
				 $output .= 		tfuse_upload($value);
        	break;
        	
        	case 'multi':
				 $output .= 		tfuse_multi($value);
        	break;
        	
        	case 'slider':
				 $output .= 		tfuse_slider($value);
        	break;
        	
        	case 'boxes':
				 $output .= 		tfuse_boxes($value);
        	break;

            case 'colorpicker':
				 $output .= 		tfuse_colorpicker($value);
        	break;

        	
  
		} //END switch ( $value['type'] )
	
 		
        //-------------------------------------------//
        
        if ($only_form === false && $value['type'] != "heading" && $value['type'] != "boxes"  && $value['type'] != "slider" && $value['type'] != "tab" && $value['type'] != "metabox") { 
            if ( $value['type'] != "checkbox" ) 
                { 
                $output .= '<br/>';
                }
                
            $output .= '</div><div class="desc">'. $value['desc'] .'</div></div>'."\n";
            $output .= '</div></div><div class="clear"></div>'."\n";
        
        } // END if
		

    } //END foreach ($options as $value)
    
	if(empty($get_option)) {
    	$output .= '</div></div>';
    }    
    
	//generate header for tabs
	$draw_tabs  =  "<ul>\n";
	$draw_tabs .=  $draw_tabs_li;
	$draw_tabs .=  "</ul>\n";
	
	$output_content  = '<div id="tabs">'."\n";
	$output_content .= $draw_tabs . $output;
	$output_content .= '</div>'."\n";
    
	if(empty($get_option)) {
    	return $output_content;
    } else {
    	return $output;
    }

}  //END tfuse_options_page_content()

?>