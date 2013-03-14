<?php
//************************************* Testimonials
function tfuse_testimonials($atts, $content = null)
{

    ob_start();
	$buffer = '';

    dynamic_sidebar('Testimonials');
	$buffer = ob_get_contents();
	ob_end_clean();

    return apply_filters('tfuse_testimonials', $buffer);
}
add_shortcode('testimonials', 'tfuse_testimonials');
?>