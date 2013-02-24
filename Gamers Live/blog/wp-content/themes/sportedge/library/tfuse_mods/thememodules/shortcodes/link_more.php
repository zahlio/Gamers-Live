<?php
//************************************* Link more
function tfuse_link_more($atts, $content = null)
{
	extract(shortcode_atts(array('url' => '#', 'text' => ''), $atts));

    $tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['url'] = $url;
    if($text == '') $tfuse_shortcode_arr['text'] = __('more details','tfuse'); else $tfuse_shortcode_arr['text'] = $text;


	return tfuse_link_more_html($tfuse_shortcode_arr);
}
add_shortcode('link_more', 'tfuse_link_more');

function tfuse_link_more_html($tfuse_shortcode_arr)
{
	$return_html =  '<a class="link-more" href="'. $tfuse_shortcode_arr['url'].'">'. $tfuse_shortcode_arr['text'].'</a>';

    return apply_filters('tfuse_link_more', $return_html, $tfuse_shortcode_arr);
}
?>