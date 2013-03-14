<?php
//************************************* Newsletter
function tfuse_newsletter($atts, $content = null)
{
	extract(shortcode_atts(array('action' => '#', 'title' => '', 'text' => '', 'rss_feed'=>''), $atts));
	if($title == '') $title = 'Newsletter signup';
	$textok = '';
	if($text == '') $textok = 'Thank you for your subscribtion.';

    $tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['action'] = $action;
    $tfuse_shortcode_arr['text'] = $textok;
    $tfuse_shortcode_arr['title'] = $title;
    $tfuse_shortcode_arr['rss_feed'] = $rss_feed;
	return tfuse_newsletter_html($tfuse_shortcode_arr);

}
add_shortcode('newsletter', 'tfuse_newsletter');


function tfuse_newsletter_html($tfuse_shortcode_arr)
{
    $news_title = (!empty($tfuse_shortcode_arr['title'])) ? '<h2>'. $tfuse_shortcode_arr['title'].'</h2>' : '';
$out = '
	 <div class="widget-container newsletterBox">
                            <div class="inner">
			                '.$news_title;

            if ( isset(  $_POST['newsletter'] ) ) $out .= '<div class="before-text">'.$tfuse_shortcode_arr['text'].'</div>';
			else
            {
				$out .= '<div class="before-text">'. __('Sign up for our weekly newsletter to receive updates, news, and promos:','tfuse').'</div>

				<form action="'. $tfuse_shortcode_arr['action'].'" method="post" id="subscribe">
				<input type="text" value="'.__('ENTER YOUR EMAIL ADDRESS','tfuse').'" onfocus="if (this.value == \''.__('ENTER YOUR EMAIL ADDRESS','tfuse').'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.__('ENTER YOUR EMAIL ADDRESS','tfuse').'\';}" name="email" class="inputField" />
				<input type="submit" value="'.__('Send','tfuse').'" name="" class="btn-arrow" />
				<div class="newsletter_text">';
				 if($tfuse_shortcode_arr['rss_feed']!='')
                 {
                     $out .='<a href=" ';
                     $out .= tfuse_options(PREFIX.'_feedburner_url', get_bloginfo_rss('rss2_url'));
                     $out .= ''.'" class="link-news-rss" >You can also folow us <span>on RSS feed</span></a>';
                 }
			$out .='</div></form>';
			}
		$out .= '</div>
		</div>';
	return apply_filters('tfuse_newsletter', $out, $tfuse_shortcode_arr);
}
?>