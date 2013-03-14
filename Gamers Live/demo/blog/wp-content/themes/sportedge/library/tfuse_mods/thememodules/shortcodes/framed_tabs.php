<?php
// **************************Framed Tabs
function tfuse_framed_tabs($atts, $content = null)
{
	global $framedtabsheading;
	$framedtabsheading = '';
	extract(shortcode_atts(array('title' => '', 'class' => ''), $atts));

	$get_tabs = do_shortcode($content);
    $tfuse_class = (!empty($class)) ? 'class="' . $class . '"' : '';
	$k = 0; 
	

	$out = '
<!-- tab box -->
<div ' . $tfuse_class . '>	<ul class="tabs">';

    while(isset($framedtabsheading[$k]))
	{
		$out .= $framedtabsheading[$k];
		$k++;
	}
	$out .= '</ul>' . $get_tabs . '</div><!--/ tab box -->';

    return apply_filters('tfuse_framed_tabs', $out);
}
add_shortcode('framed_tabs', 'tfuse_framed_tabs');

function tfuse_tab($atts, $content = null)
{
	global $tabsheading, $framedtabsheading;
	extract(shortcode_atts(array('title' => '', 'icon' => 'icon.png', 'width' => '51', 'height' => '42'), $atts));
	$k = 0;
	while(isset($framedtabsheading[$k])) { $k++;}

	( $title != '' ) ? $alt = 'alt="' . $title . '" title="' . $title . '"' : $alt = '';

	$tabsheading[] = '<li><a href="#tabs_1_'.($k+1).'"><img src="' . $icon . '" width="' . $width . '" height="' . $height . '" ' . $alt . ' /></a></li>';

	$framedtabsheading[] = '<li><a href="#tabs_1_'.($k+1).'"><span>' . $title . '</span></a></li>';

	$out = '<div id="tabs_1_'.($k+1).'" class="tabcontent">
	    <div class="inner">
	' . do_shortcode($content) . '<div class="clear"></div>
	    </div>
	</div>';
	return apply_filters('tfuse_tab', $out);
}
add_shortcode('tab', 'tfuse_tab');

?>