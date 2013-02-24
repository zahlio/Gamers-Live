<?php
//************************************* Image Frames
function tfuse_frame($atts, $content = null)
{
	extract(shortcode_atts(array('link' => '', 'target' => '_self', 'width' => '', 'height' => '', 'alt' => '', 'align'=>'left','src' => '','type' => ''), $atts));
	
	$tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['src'] = (!empty($src)) ? 'src="'.$src.'"' : '';
    $tfuse_shortcode_arr['width'] = (!empty($width)) ? 'width="'.$width.'"':'200';
    $tfuse_shortcode_arr['height'] = (!empty($height)) ? 'height="'.$height.'"':'200';
    $tfuse_shortcode_arr['alt'] = (!empty($alt)) ? 'alt="'.$alt.'"' : '';
    $tfuse_shortcode_arr['link'] = (!empty($link)) ? 'href="'.$link.'"': '';
    $tfuse_shortcode_arr['target'] = (!empty($target)) ? 'target="'.$target.'"' : '';
    $tfuse_shortcode_arr['align'] = (!empty($align)) ? 'frame_'.$align : '';
    $tfuse_shortcode_arr['type'] = $type;

	return tfuse_frame_html($tfuse_shortcode_arr);
}
add_shortcode('frame', 'tfuse_frame');


function tfuse_frame_html($tfuse_shortcode_arr)
{
	if ( $tfuse_shortcode_arr['type'] && !empty($tfuse_shortcode_arr['src']))
	{
		$return_html = '<p><a ' .  $tfuse_shortcode_arr['link'] . ' ' . $tfuse_shortcode_arr['target'] . '><span class="'.$tfuse_shortcode_arr['align'].' preload"><img ' . $tfuse_shortcode_arr['src'] . ' ' . $tfuse_shortcode_arr['width'] . ' ' . $tfuse_shortcode_arr['height'] . ' ' .  $tfuse_shortcode_arr['alt'] . '  /></span></a></p>';
	}
	elseif ( !empty($tfuse_shortcode_arr['src']) )
	{
		$return_html = '<p><a ' .  $tfuse_shortcode_arr['link'] . ' ' . $tfuse_shortcode_arr['target'] . '><img ' . $tfuse_shortcode_arr['src'] . ' ' . $tfuse_shortcode_arr['width'] . ' ' . $tfuse_shortcode_arr['height'] . ' ' .  $tfuse_shortcode_arr['alt'] . ' class="'.$tfuse_shortcode_arr['align'].'" /></a></p>';
	}
    else $return_html = '';
    return apply_filters('tfuse_frame', $return_html, $tfuse_shortcode_arr );

}


?>