<?php
//************************************* Quotes
function tfuse_quote_right($atts, $content = null)
{
	$return_html =  '<div class="quote_right"><div class="inner1"><p>' . do_shortcode($content) . '</p></div></div>';

    return apply_filters('tfuse_quote_right', $return_html);
}
add_shortcode('quote_right', 'tfuse_quote_right');

function tfuse_quote_left($atts, $content = null)
{
	$return_html = '<div class="quote_left"><div class="inner"><p>' . do_shortcode($content) . '</p></div></div>';

    return apply_filters('tfuse_quote_left', $return_html);
}
add_shortcode('quote_left', 'tfuse_quote_left');

function tfuse_blockquote($atts, $content = null)
{
	$return_html = '<blockquote><div class="inner">' . do_shortcode($content) . '</div></blockquote>';

    return apply_filters('tfuse_blockquote', $return_html);
}
add_shortcode('blockquote', 'tfuse_blockquote');

function tfuse_quote_box($atts, $content = null)
{
	extract(shortcode_atts(array('author' => '', 'profession' => ''), $atts));
	$return_html ='<div class="quoteBox-big">
		<div class="inner"><div class="quote-text">' . do_shortcode($content) . '</div>';
	if (!empty($author) || !empty($profession)) { $return_html .='<div class="quote-author">';
	if (!empty($author)) {
	$return_html .= '<span class="black">'.$author.'</span>'; }
	$return_html .= $profession.'</div>';
	}
	$return_html .='</div></div>  ';

    return apply_filters('tfuse_quote_box', $return_html);
}
add_shortcode('quote_box', 'tfuse_quote_box');

function tfuse_quote_simple($atts, $content = null)
{

	$return_html ='<div class="quoteBox">
		<div class="quote-text">' . do_shortcode($content) . '</div>';
	$return_html .='</div>  ';

    return apply_filters('tfuse_quote_simple', $return_html);
}
add_shortcode('quote_simple', 'tfuse_quote_simple');




?>