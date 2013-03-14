<?php
//************************************* Box Styles
function tfuse_box($atts, $content = null)
{
	extract(shortcode_atts(array('class' => '','title'=>'',), $atts));

    $tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['class'] = $class;
    $tfuse_shortcode_arr['title'] = (!empty($title)) ? '<div class="box_title">'.$title.'</div>' : '';
    $tfuse_shortcode_arr['content'] = do_shortcode($content);

    return tfuse_box_html($tfuse_shortcode_arr);
}
add_shortcode('box', 'tfuse_box');


function tfuse_box_html($tfuse_shortcode_arr)
{
	$out =  '<div class="sb ' . $tfuse_shortcode_arr['class'] . '">
        '.$tfuse_shortcode_arr['title'].'
        <div class="box_content">
            ' .  $tfuse_shortcode_arr['content'] .
        '<div class="clear"></div>
        </div>
    </div>';

    return apply_filters('tfuse_box', $out, $tfuse_shortcode_arr);
}


?>
