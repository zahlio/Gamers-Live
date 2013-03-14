<?php
//************************************* List Styles

function tfuse_arrow_list($atts, $content = null)
{
	$return_html =  '<div class="list_arrows">' . do_shortcode($content) . '</div>';

    return apply_filters('tfuse_arrow_list', $return_html);
}
add_shortcode('arrow_list', 'tfuse_arrow_list');

function tfuse_check_list($atts, $content = null)
{
	$return_html = '<div class="list_check">' . do_shortcode($content) . '</div>';
	return apply_filters('tfuse_check_list', $return_html);
}
add_shortcode('check_list', 'tfuse_check_list');

function tfuse_delete_list($atts, $content = null)
{
	$return_html =  '<div class="list_delete">' . do_shortcode($content). '</div>';
	return apply_filters('tfuse_delete_list', $return_html);
}
add_shortcode('delete_list', 'tfuse_delete_list');


?>