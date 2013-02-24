<?php
//************************************* H Titles
function tfuse_shortcode_title($atts, $content = null)
{
	extract(shortcode_atts(array('h1' => '','h2' => '','h3' => '', 'h4' => '', 'h5' => '', 'h6' => '',), $atts));

    $h = 'h2';
	if(!is_array($atts)) $atts = array();
	$tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['h'] = $h;
    $tfuse_shortcode_arr['class'] ='';
    $tfuse_shortcode_arr['content'] =  do_shortcode($content);

    foreach($atts as $key => $value)
        if($key != '')
        {
            $tfuse_shortcode_arr['h'] = $key;
            $tfuse_shortcode_arr['class'] = 'class="'.$value.'"';
            break;
        }

    $patterns[0] = '/border/';
	$replacements[0] = 'title_border';

    return tfuse_shortcode_title_html($tfuse_shortcode_arr);
}
add_shortcode('title', 'tfuse_shortcode_title');

function tfuse_shortcode_title_html($tfuse_shortcode_arr)
{
	$return_html = '<'.	$tfuse_shortcode_arr['h'].' '.$tfuse_shortcode_arr['class'].'>'. $tfuse_shortcode_arr['content'].'</'.$tfuse_shortcode_arr['h'].'>';

    return apply_filters('tfuse_shortcode_title', $return_html, $tfuse_shortcode_arr);
}
?>