<?php
//************************************* Columns


function tfuse_col_1_2($atts, $content = null)
{
	extract(shortcode_atts(array('style' => ''), $atts));
	$return_html = '<div class="col col_1_2 '.$style.'"><div class="inner">' . do_shortcode($content) . '</div></div>';

    return apply_filters('tfuse_col_1_2', $return_html);
}
add_shortcode('col_1_2', 'tfuse_col_1_2');

function tfuse_col_1_3($atts, $content = null)
{
	extract(shortcode_atts(array('style' => ''), $atts));
	$return_html = '<div class="col col_1_3 '.$style.'"><div class="inner">' . do_shortcode($content) . '</div></div>';

    return apply_filters('tfuse_col_1_3', $return_html);
}
add_shortcode('col_1_3', 'tfuse_col_1_3');

function tfuse_col_1_4($atts, $content = null)
{
	extract(shortcode_atts(array('style' => ''), $atts));
	$return_html = '<div class="col col_1_4 '.$style.'"><div class="inner">' . do_shortcode($content) . '</div></div>';

    return apply_filters('tfuse_col_1_4', $return_html);
}
add_shortcode('col_1_4', 'tfuse_col_1_4');

function tfuse_col_1_5($atts, $content = null)
{
	extract(shortcode_atts(array('style' => ''), $atts));
	$return_html = '<div class="col col_1_5 '.$style.'"><div class="inner">' . do_shortcode($content) . '</div></div>';

    return apply_filters('tfuse_col_1_5', $return_html);
}
add_shortcode('col_1_5', 'tfuse_col_1_5');

function tfuse_col_2_3($atts, $content = null)
{
	extract(shortcode_atts(array('style' => ''), $atts));
	$return_html = '<div class="col col_2_3 '.$style.'"><div class="inner">' . do_shortcode($content) . '</div></div>';

    return apply_filters('tfuse_col_2_3', $return_html);
}
add_shortcode('col_2_3', 'tfuse_col_2_3');

?>