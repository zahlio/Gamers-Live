<?php 

//************************************* FAQ
function tfuse_faq($atts, $content = null)
{
	global $faq_question, $faq_answer;

extract(shortcode_atts(array('title' => ''), $atts));

	$faq_question = $faq_answer = '';
	$get_faqs = do_shortcode($content);
	$k = 0;
    if (! isset($title) && $title == '') $title = '<h2>Frequently asked questions:</h2>';
    elseif($title != '') $title ='<h2>' . $title . '</h2>';
    else $title = '';
	$out = '<div class="faq_list">'. $title ;
	while(isset($faq_question[$k]))
	{
		$out .= $faq_question[$k];
		$out .= $faq_answer[$k];
		$k++;
	}
	$out .= '
	</div>';
	return apply_filters('tfuse_faq', $out);
}
add_shortcode('faq', 'tfuse_faq');

function tfuse_faq_question($atts, $content = null)
{
	global $faq_question;
	$faq_question[] = '<div class="faq_question toggle"><span class="faq_q">Q:</span><span class="faq_title">'.do_shortcode($content).'</span><span class="ico"></span></div>';
	//return $out;
}
add_shortcode('faq_question', 'tfuse_faq_question');

function tfuse_faq_answer($atts, $content = null)
{
	global $faq_answer;
	$faq_answer[] = '<div class="faq_answer toggle_content"><p>'.do_shortcode($content).'</p></div>';
	//return $out;
}
add_shortcode('faq_answer', 'tfuse_faq_answer');

?>