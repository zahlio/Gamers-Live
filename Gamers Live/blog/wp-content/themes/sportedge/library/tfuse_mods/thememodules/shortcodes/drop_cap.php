<?php
//************************************* Dropcaps
function tfuse_drop_cap_1($atts, $content = null)
{
	$return_html = '<span class="dropcap1">' . do_shortcode($content) . '</span>';

    return apply_filters('tfuse_drop_cap_1', $return_html);
}
add_shortcode('dropcap1', 'tfuse_drop_cap_1');

function tfuse_drop_cap_2($atts, $content = null)
{
	$return_html = '<span class="dropcap2">' . do_shortcode($content) . '</span>';

    return apply_filters('tfuse_drop_cap_2', $return_html);
}
add_shortcode('dropcap2', 'tfuse_drop_cap_2');
?>