<?php
//********************* tables shortcodes
function tfuse_table($atts, $content)
{

//extract short code attr
	extract(shortcode_atts(array('style' => '','shadow' => ''), $atts));
	if ( $shadow !='' ) $shadow = 'shadow'; else $shadow = '';

    $tfuse_shortcode_arr = array();

    $tfuse_shortcode_arr['style'] = strtolower($style);
    $tfuse_shortcode_arr['shadow'] ='';
   if ( $shadow !='' )  $tfuse_shortcode_arr['shadow'] = $shadow;
    $tfuse_shortcode_arr['content'] = html_entity_decode(do_shortcode($content));
    
	return tfuse_table_html($tfuse_shortcode_arr);
}
add_shortcode('table', 'tfuse_table');

function tfuse_table_html($tfuse_shortcode_arr)
{



	$return_html= '<div class="styled_table '.$tfuse_shortcode_arr['style'].' '. $tfuse_shortcode_arr['shadow'].'">';
	$return_html.= $tfuse_shortcode_arr['content'];
	$return_html.= '</div>';
    return apply_filters('tfuse_table', $return_html, $tfuse_shortcode_arr);
}

?>