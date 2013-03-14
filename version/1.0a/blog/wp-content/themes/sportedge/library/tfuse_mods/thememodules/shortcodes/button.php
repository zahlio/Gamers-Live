<?php
//************************************* Buttons

function tfuse_button($atts, $content = null)
{
	extract(shortcode_atts(array('style' => '', 'link' => '#', 'class' => '','target' => '_self'), $atts));

	$tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['style'] = ( !empty($style) ) ? 'style="'. $style .'' : '';
    $tfuse_shortcode_arr['link'] = ( !empty($link) ) ? '" href="' .$link. '"' : '';
    $tfuse_shortcode_arr['class'] = '';
    $tfuse_shortcode_arr['target'] = ( !empty($target) ) ? '" target="' .$target . '"' : '';
    $tfuse_shortcode_arr['content'] = do_shortcode($content);

    if ( $tfuse_shortcode_arr['style'] != '' )  $tfuse_shortcode_arr['class'] = 'class="button_styled"';

    else $tfuse_shortcode_arr['class'] = 'class="button_link ' . $class .'"';

    return tfuse_button_html($tfuse_shortcode_arr);
}
add_shortcode('button', 'tfuse_button');

function tfuse_button_html($tfuse_shortcode_arr)
{
	$out = '<a ' . $tfuse_shortcode_arr['class'] .' '. $tfuse_shortcode_arr['style'] .' '.  $tfuse_shortcode_arr['target'] .' '. $tfuse_shortcode_arr['link'] . '"><span>' . $tfuse_shortcode_arr['content'] . '</span></a>';

    return apply_filters('tfuse_button', $out, $tfuse_shortcode_arr);
}
?>