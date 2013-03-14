<?php

function tfuse_youtube($atts, $content = null) 
{

extract(shortcode_atts(array('link' => '','width' => '660', 'height' => '400', 'title' => ''	), $atts));
	

	$tfuse_shortcode_arr = array();

    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $video_id);
    $tfuse_shortcode_arr['video_id'] = $video_id[0];
    $tfuse_shortcode_arr['width'] = $width;
    $tfuse_shortcode_arr['height'] = $height;
    $tfuse_shortcode_arr['title'] = $title;

    return tfuse_youtube_html($tfuse_shortcode_arr);
}
add_shortcode('youtube', 'tfuse_youtube');

function tfuse_youtube_html($tfuse_shortcode_arr)
{



    $return_html='   <iframe title="'.$tfuse_shortcode_arr['title'].'" width="'.$tfuse_shortcode_arr['width'].'" height="'. $tfuse_shortcode_arr['height'].'" src="http://www.youtube.com/embed/'. $tfuse_shortcode_arr['video_id'].'?wmode=transparent" frameborder="0"></iframe>';

	$return_html.= PHP_EOL;
	return apply_filters('tfuse_youtube', $return_html, $tfuse_shortcode_arr);
}

function tfuse_vimeo($atts, $content)
{

	//extract short code attr
	extract(shortcode_atts(array(
		'width' => 640,	'height' => 385, 'link' => '', 'title' => ''), $atts));
	


    $tfuse_shortcode_arr['video_id'] = substr($link,17,8);
    $tfuse_shortcode_arr['width'] = $width;
    $tfuse_shortcode_arr['height'] = $height;
    $tfuse_shortcode_arr['title'] = $title;



	return tfuse_vimeo_html($tfuse_shortcode_arr);
}
add_shortcode('vimeo', 'tfuse_vimeo');
function tfuse_vimeo_html($tfuse_shortcode_arr)
{

    $return_html ='   <iframe title="'.$tfuse_shortcode_arr['title'].'" src="http://player.vimeo.com/video/'. $tfuse_shortcode_arr['video_id'].'?title=0&amp;byline=0&amp;portrait=0" width="'.$tfuse_shortcode_arr['width'].'" height="'. $tfuse_shortcode_arr['height'].'" frameborder="0"></iframe>';
    $return_html.= PHP_EOL;
   return apply_filters('tfuse_vimeo', $return_html, $tfuse_shortcode_arr);
}
?>