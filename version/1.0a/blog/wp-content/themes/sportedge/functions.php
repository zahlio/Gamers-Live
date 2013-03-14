<?php
/* Load the tfuse class. */
require_once( TEMPLATEPATH . '/library/tfuse.php' );

/* Initialize the tfuse framework. */
$tfuse = new tfuse();
$tfuse->init();

define( 'PREFIX', $tfuse->prefix );

@$style = $_GET['color'];

$styles_directory = get_template_directory()."/styles/";
$styles_directory_uri = get_template_directory_uri()."/styles/";
  

if( is_file( $styles_directory . $style .'.css' ) ) { 

	//update_option(PREFIX.'_alt_stylesheet',$style.".css");
	setcookie(PREFIX . '_style_demo', $style.".css", time()+3600, '/');
}

if( !empty($_GET['bg']) && is_file( get_template_directory().'/images/'.esc_attr($_GET['bg']) ) )
{
    @setcookie(PREFIX . '_style_demo', esc_attr($_GET['bg']), time()+3600*60, '/');
}
# This sets the HTML Editor as default #
add_filter( 'wp_default_editor', create_function('', 'return "html";') );

add_filter('themefuse_shortcodes', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

//add_theme_support( 'post-thumbnails' );

// Disable Admin Bar for all users
add_filter('show_admin_bar', '__return_false');

function improved_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text, '<a>');
		$excerpt_length = apply_filters('excerpt_length', 40);
		$excerpt_more = apply_filters('excerpt_more', ' ...' . '');
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');


$_settings = get_option('newsletter_settings') ? get_option('newsletter_settings') : array();

function add_email( $email ){
	
	global $_settings;
	
	$emails = explode(",", $email);
	$valid_emails = array();
	$unique_emails = array();

	foreach($emails as $mail){
		if ( is_email(trim($mail)) ) $valid_emails[] = trim($mail);
	}

	if ( empty($valid_emails) ) return false;

	$valid_emails_string = implode(",", $valid_emails);
	if ( !empty($_settings['newsletter_emails']) ) $valid_emails_string = ',' . $valid_emails_string;

	$_settings['newsletter_emails'] .= $valid_emails_string;
	$unique_emails = explode(",", $_settings['newsletter_emails']);
	$unique_emails = array_unique($unique_emails);

	$_settings['newsletter_emails'] = implode(",", $unique_emails);
	_save_settings_todb();

	return true;
}

function _save_settings_todb($form_settings = '')
{
	global $_settings;

	if ( $form_settings <> '' ) {
		unset($form_settings['newsletter_settings_saved']);

		$emails = $_settings['newsletter_emails'];

		$_settings = $form_settings;
		$_settings['newsletter_emails'] = $emails;
	}
	update_option('newsletter_settings', $_settings);
}
  
if ( isset($_POST['newsletter']) ) add_email( $_POST['newsletter'] );

if (!function_exists('tfuse_comment_reply')) {
	function tfuse_comment_reply() {
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
}
add_action('get_header', 'tfuse_comment_reply');

?>