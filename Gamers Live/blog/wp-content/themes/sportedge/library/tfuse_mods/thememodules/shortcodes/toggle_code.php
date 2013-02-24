<?php
//************************************* Toggle Content
function tfuse_toggle_content($atts, $content = null)
{
	extract(shortcode_atts(array('title' => '', 'class' => ''), $atts));
	$out = '<h3 class="'.$class.'">' . $title . '<span class="ico"></span></h3>';
	$out .= '<div class="toggle_content  boxed">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	return apply_filters('tfuse_toggle_content', $out);
}
add_shortcode('toggle_content', 'tfuse_toggle_content');

function tfuse_toggle_code($atts, $content = null)
{
	extract(shortcode_atts(array('title' => '', 'brush' => 'plain'), $atts));
	$out = '<h3 class="toggle box">' . $title . '<span class="ico"></span></h3>';
	$out .= '<div class="toggle_content">';
	$out .= '<pre class="brush: '.$brush.'">';
	$out .= $content;
	$out .= '</pre>';
	$out .= '</div>';
	return apply_filters('tfuse_toggle_code', $out);
}
add_shortcode('toggle_code', 'tfuse_toggle_code');

function tfuse_code($atts, $content = null)
{
	extract(shortcode_atts(array('brush' => 'plain'), $atts));
	$out = '<pre class="brush: '.$brush.'">';
	$out .= $content;
	$out .= '</pre>';
	return apply_filters('tfuse_code', $out);
}
add_shortcode('code', 'tfuse_code');
?>