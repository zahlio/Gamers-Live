<?php
// **************************Flickr
function tfuse_flickr($atts, $content)
{

	//extract short code attr
	extract(shortcode_atts(array('items' => 9, 'flickr_id' => '', 'title'=>''), $atts));
	
	$tfuse_shortcode_arr = array();
	
	if(!empty($flickr_id))
	{
       $tfuse_shortcode_arr['items']     = $items;
       $tfuse_shortcode_arr['flickr_id'] = $flickr_id;
	}
	if(!empty($title))
    {
        $tfuse_shortcode_arr['title']     = '<h2>'.$title.'</h2>';
    }
	 return tfuse_flickr_html($tfuse_shortcode_arr);
}
add_shortcode('flickr', 'tfuse_flickr');

function tfuse_flickr_html($tfuse_shortcode_arr)
{
    if  (!empty($tfuse_shortcode_arr['flickr_id']))
    $return_html = '<div class="flickr">' .$tfuse_shortcode_arr['title'] . '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' .$tfuse_shortcode_arr['items'] . '&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=' . $tfuse_shortcode_arr['flickr_id'] . '"></script></div><br class="clear"/>';
    else $return_html = '';
    return apply_filters('tfuse_flickr', $return_html);
}
?>