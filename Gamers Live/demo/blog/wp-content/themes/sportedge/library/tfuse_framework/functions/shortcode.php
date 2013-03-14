<?php
/**
 * Theme Short-code Functions
 */

//************************************* RAW prevent wordpress format

function tfuse_raw( $atts, $content = null ) {

	$out = do_shortcode($content);
    
    return $out;
}
add_shortcode('raw', 'tfuse_raw');


//************************************* Buttons

function tfuse_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));

	$out = "<a class=\"button_link\" href=\"" .$link. "\"><span>" .do_shortcode($content). "</span></a>";
    
    return $out;
}
add_shortcode('button', 'tfuse_button');


//************************************* Header

function tfuse_fancy_header( $atts, $content = null ) {
   return '<p class="fancy_header"><span>' . do_shortcode($content) . '</span></p>';
}
add_shortcode('fancy_header', 'tfuse_fancy_header');

//************************************* Dropcaps

function tfuse_drop_cap_1( $atts, $content = null ) {
   return '<span class="dropcap1">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap1', 'tfuse_drop_cap_1');


function tfuse_drop_cap_2( $atts, $content = null ) {
   return '<span class="dropcap2">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap2', 'tfuse_drop_cap_2');

//************************************* Pullquotes

function tfuse_pullquote_right( $atts, $content = null ) {
   return '<span class="pullquote_right">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_right', 'tfuse_pullquote_right');


function tfuse_pullquote_left( $atts, $content = null ) {
   return '<span class="pullquote_left">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_left', 'tfuse_pullquote_left');

//************************************* Image Frames

function tfuse_frame_left( $atts, $content = null ) {
   return '<span class="frame alignleft"><img src="' . do_shortcode($content) . '" /></span>';
}
add_shortcode('frame_left', 'tfuse_frame_left');


function tfuse_frame_right( $atts, $content = null ) {
   return '<span class="frame alignright"><img src="' . do_shortcode($content) . '" /></span>';
}
add_shortcode('frame_right', 'tfuse_frame_right');


function tfuse_frame_center( $atts, $content = null ) {
   return '<span class="frame aligncenter"><img src="' . do_shortcode($content) . '" /></span>';
}
add_shortcode('frame_center', 'tfuse_frame_center');

//************************************* Box Styles

function tfuse_download_box( $atts, $content = null ) {
   return '<div class="download_box">' . do_shortcode($content) . '</div>';
}
add_shortcode('download_box', 'tfuse_download_box');


function tfuse_warning_box( $atts, $content = null ) {
   return '<div class="warning_box">' . do_shortcode($content) . '</div>';
}
add_shortcode('warning_box', 'tfuse_warning_box');


function tfuse_info_box( $atts, $content = null ) {
   return '<div class="info_box">' . do_shortcode($content) . '</div>';
}
add_shortcode('info_box', 'tfuse_info_box');


function tfuse_note_box( $atts, $content = null ) {
   return '<div class="note_box">' . do_shortcode($content) . '</div>';
}
add_shortcode('note_box', 'tfuse_note_box');


function tfuse_fancy_box( $atts, $content = null ) {
   return '<div class="fancy_box">' . do_shortcode($content) . '</div>';
}
add_shortcode('fancy_box', 'tfuse_fancy_box');



//************************************* List Styles

function tfuse_check_list( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="check_list">', do_shortcode($content));
	return $content;
	
}
add_shortcode('check_list', 'tfuse_check_list');


function tfuse_arrow_list( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="arrow_list">', do_shortcode($content));
	return $content;
	
}
add_shortcode('arrow_list', 'tfuse_arrow_list');

//************************************* Toggle Content

function tfuse_toggle_content( $atts, $content = null ) {
	extract(shortcode_atts(array(
        'title'      => '',
    ), $atts));
	
	$out .= '<h3 class="toggle"><a href="#">' .$title. '</a></h3>';
	$out .= '<div class="toggle_content" style="display: none;">';
	$out .= '<div class="block">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	$out .= '</div>';
	
   return $out;
}
add_shortcode('toggle', 'tfuse_toggle_content');


//************************************* Highlight Styles

function tfuse_highlight1( $atts, $content = null ) {
	extract(shortcode_atts(array(
        'style'      => '',
    ), $atts));
    
   return '<span class="highlight1" style="'.$style.'" >' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight1', 'tfuse_highlight1');

function tfuse_highlight2( $atts, $content = null ) {
	extract(shortcode_atts(array(
        'style'      => '',
    ), $atts));
    
   return '<span class="highlight2" style="'.$style.'" >' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight2', 'tfuse_highlight2');

//************************************* Divider Styles

function tfuse_divider( $atts, $content = null ) {
   return '<div class="divider"></div>';
}
add_shortcode('divider', 'tfuse_divider');

function tfuse_divider_top( $atts, $content = null ) {
   return '<div class="divider top"><a href="#">Top</a></div>';
}
add_shortcode('divider_top', 'tfuse_divider_top');

function tfuse_clearboth( $atts, $content = null ) {
   return '<div class="clearboth"></div>';
}
add_shortcode('clearboth', 'tfuse_clearboth');


//************************************* Columns


function tfuse_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'tfuse_one_third');


function tfuse_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'tfuse_one_third_last');


function tfuse_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'tfuse_two_third');


function tfuse_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'tfuse_two_third_last');


function tfuse_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'tfuse_one_half');


function tfuse_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'tfuse_one_half_last');


function tfuse_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'tfuse_one_fourth');


function tfuse_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'tfuse_one_fourth_last');


function tfuse_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'tfuse_three_fourth');


function tfuse_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'tfuse_three_fourth_last');

?>