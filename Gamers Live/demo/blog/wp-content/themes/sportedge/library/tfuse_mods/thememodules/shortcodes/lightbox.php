<?php
//********************************** LightBox
function tfuse_lightbox($atts, $content = null)
{
	extract(shortcode_atts(array('title' => '',	'link' => '',  'prettyphoto' => '', 'style' => '', 'class' => '', 'pretty_title'=>'' ), $atts));

    $tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['title'] = $title;
    $tfuse_shortcode_arr['prettyphoto'] = '';
    $tfuse_shortcode_arr['style'] = $style;
    $tfuse_shortcode_arr['class'] = $class;
    $tfuse_shortcode_arr['link'] = $link;
    $tfuse_shortcode_arr['pretty_title'] = (!empty($pretty_title))? html_entity_decode($pretty_title) : '';
    $tfuse_shortcode_arr['content'] = do_shortcode($content);

 	if ($prettyphoto != '')  $tfuse_shortcode_arr['prettyphoto'] = $prettyphoto;
    else $tfuse_shortcode_arr['prettyphoto'] = 'p_'.rand(1,1000);

	return tfuse_lightbox_html($tfuse_shortcode_arr);

}
add_shortcode('lightbox', 'tfuse_lightbox');


function tfuse_lightbox_html($tfuse_shortcode_arr)
{
    $return_html = ( !empty($tfuse_shortcode_arr['pretty_title']) ) ? '<div class="video-title">'.$tfuse_shortcode_arr['pretty_title'].'</div>': '';

     $return_html .= '<a href="'.$tfuse_shortcode_arr['link'].'" class="'. $tfuse_shortcode_arr['class'] .' prettyPhoto" style="'.$tfuse_shortcode_arr['style'].'" rel="prettyPhoto['.$tfuse_shortcode_arr['prettyphoto'].']" title="'.$tfuse_shortcode_arr['title'].'" >'. $tfuse_shortcode_arr['content'].'</a>';

    return apply_filters('tfuse_lightbox', $return_html, $tfuse_shortcode_arr);
}


//********************************** Button LightBox
function tfuse_lightbox_btn($atts, $content = null)
{
	extract(shortcode_atts(array('title' => '',	'link' => '', 'class' => '', 'prettyphoto' => '', 'style' => ''  ), $atts));

    $tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['title'] = $title;
    $tfuse_shortcode_arr['prettyphoto'] = '';
    $tfuse_shortcode_arr['style'] = $style;
    $tfuse_shortcode_arr['class'] = '';
    $tfuse_shortcode_arr['link'] = $link;
    $tfuse_shortcode_arr['content'] = do_shortcode($content);

 	if ($prettyphoto != '')  $tfuse_shortcode_arr['prettyphoto'] = $prettyphoto;
    else $tfuse_shortcode_arr['prettyphoto'] = 'p_'.rand(1,1000);

    if ($class != '')  $tfuse_shortcode_arr['class'] = $class.' prettyPhoto';
    else  $tfuse_shortcode_arr['class'] = 'prettyPhoto';

       
	return tfuse_lightbox_btn_html($tfuse_shortcode_arr);

}
add_shortcode('lightbox_btn', 'tfuse_lightbox_btn');


function tfuse_lightbox_btn_html($tfuse_shortcode_arr)
{

    $return_html =  '<a href="'.$tfuse_shortcode_arr['link'].'" class="'. $tfuse_shortcode_arr['class'] .'" style="'.$tfuse_shortcode_arr['style'].'" rel="prettyPhoto['.$tfuse_shortcode_arr['prettyphoto'].']" title="'.$tfuse_shortcode_arr['title'].'" ><span>'. $tfuse_shortcode_arr['content'].'</span></a>';

    return apply_filters('tfuse_lightbox_btn', $return_html, $tfuse_shortcode_arr);
}


?>