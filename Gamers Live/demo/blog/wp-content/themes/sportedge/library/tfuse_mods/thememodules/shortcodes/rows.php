<?php
//************************************* Rows
function tfuse_row_box($atts, $content = null)
{
	extract(shortcode_atts(array('style' => ''), $atts));
	$return_html = '<div class="'.$style.'">' . do_shortcode($content) . '<div class="clear"></div></div>';
    return apply_filters('tfuse_row_box', $return_html);
}
add_shortcode('row_box', 'tfuse_row_box');

function tfuse_row($atts, $content = null)
{
	$return_html = '<div class="row">' . do_shortcode($content) . '</div>';
    return apply_filters('tfuse_row', $return_html);
}
add_shortcode('row', 'tfuse_row');
?>