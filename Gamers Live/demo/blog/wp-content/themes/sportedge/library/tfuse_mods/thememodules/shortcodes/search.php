<?php
//************************************* Search form
function tfuse_search($atts, $content = null)
{
	ob_start();
	$buffer = '';
	require_once( THEME_MODULES . '/searchform.php' );
	$buffer = ob_get_contents();
	ob_end_clean();
    return apply_filters('tfuse_search', $buffer);
}
add_shortcode('search', 'tfuse_search');
?>
