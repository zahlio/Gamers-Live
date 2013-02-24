<?php
//************************************* Divider Styles
function tfuse_divider_space($atts, $content = null)
{
	$return_html = '<div class="divider_space"></div>';

    return apply_filters('tfuse_divider_space', $return_html);
}
add_shortcode('divider_space', 'tfuse_divider_space');

function tfuse_divider_dots($atts, $content = null)
{
	$return_html = '<div class="divider_dots"></div>';

    return apply_filters('tfuse_divider_dots', $return_html);
}
add_shortcode('divider_dots', 'tfuse_divider_dots');

function tfuse_divider_dots_full($atts, $content = null)
{
	$return_html = '<div class="divider_dots_full"></div>';

    return apply_filters('tfuse_divider_dots_full', $return_html);
}
add_shortcode('divider_dots_full', 'tfuse_divider_dots_full');

function tfuse_divider_thin($atts, $content = null)
{
	$return_html =  '<div class="divider_thin"></div>';

    return apply_filters('tfuse_divider_thin', $return_html);
}
add_shortcode('divider_thin', 'tfuse_divider_thin');

function tfuse_divider($atts, $content = null)
{
	$return_html =  '<div class="divider"></div>';

    return apply_filters('tfuse_divider', $return_html);
}
add_shortcode('divider', 'tfuse_divider');

function tfuse_clear($atts, $content = null)
{
	$return_html =  '<div class="clear"></div>';

    return apply_filters('tfuse_clear', $return_html);
}
add_shortcode('clear', 'tfuse_clear');

function tfuse_clearboth($atts, $content = null)
{
	$return_html =  '<div class="clearboth"></div>';

    return apply_filters('tfuse_clearboth', $return_html);
}
add_shortcode('clearboth', 'tfuse_clearboth');

function tfuse_divider_space_thin($atts, $content = null)
{
	$return_html =  '<div class="divider_space_thin"></div>';

    return apply_filters('tfuse_divider_space_thin', $return_html);
}
add_shortcode('divider_space_thin', 'tfuse_divider_space_thin');

?>