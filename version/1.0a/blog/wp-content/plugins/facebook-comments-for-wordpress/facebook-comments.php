<?php
	/*
	Plugin Name: Facebook Comments for WordPress
	Plugin URI: http://we8u.com/facebook-comments
	Description: Allows your visitors to comment on posts using their Facebook profile. Supports custom styles, notifications, combined comment counts, etc.
	Author: we8u
	Version: 3.1.3
	Author URI: http://we8u.com/
	*/

	define('FBCOMMENTS_ERRORS', false); # Set to true while developing, false for a release
	define('FBCOMMENTS_VER', '3.1.3');
	define('FBCOMMENTS_REQUIRED_PHP_VER', '5.0.0');
	define('FBCOMMENTS_AUTHOR', 'we8u');
	define('FBCOMMENTS_WEBPAGE', 'http://we8u.com/facebook-comments/');
	define('FBCOMMENTS_PATH', plugins_url('facebook-comments-for-wordpress/'));
	define('FBCOMMENTS_CSS_ADMIN', FBCOMMENTS_PATH . 'css/facebook-comments.css');
	define('FBCOMMENTS_CSS_HIDEWPCOMMENTS', FBCOMMENTS_PATH . 'css/facebook-comments-hidewpcomments.css');
	define('FBCOMMENTS_CSS_HIDEFBLINK', FBCOMMENTS_PATH . 'css/facebook-comments-hidefblink.css');
	define('FBCOMMENTS_CSS_HIDELIKE', FBCOMMENTS_PATH . 'css/facebook-comments-hidelike.css');
	define('FBCOMMENTS_CSS_DARKSITE', FBCOMMENTS_PATH . 'css/facebook-comments-darksite.css');
	define('FBCOMMENTS_CSS_HIDELIKEANDDARKSITE', FBCOMMENTS_PATH . 'css/facebook-comments-custom.css');
	define('FBCOMMENTS_CSS_WIDGETS', FBCOMMENTS_PATH . 'css/facebook-comments-widgets.css');

	if (FBCOMMENTS_ERRORS) {
		error_reporting(E_ALL); # Ensure all errors and warnings are verbose
	}

	# Include common functions
	require_once 'facebook-comments-core.php';
	require_once 'facebook-comments-recentcomments.php';
	require_once 'facebook-comments-combinecomments.php';
	require_once 'facebook-comments-display.php';
	require_once 'scripts/facebook.php'; # Facebook API wrapper
	wp_enqueue_script('jquery');

	/**********************************
	 Globals
	 **********************************/

	global $fbComments_defaults;

	$fbComments_defaults = array(
		'appId'						=> '',
		'appSecret'					=> '',
		'accessToken'				=> null,
		'xid'						=> fbComments_getRandXid(),
		'includeFbJs'				=> true,
		'includeFbJsOldWay'			=> false,
		'includeFbmlLangAttr'		=> true,
		'includeOpenGraphLangAttr'	=> true,
		'includeOpenGraphMeta'		=> true,
		'includeFbComments'			=> true,
		'hideWpComments'			=> false,
		'combineCommentCounts'		=> true,
		'notify'					=> true,
		'language'					=> 'en_US',
		'displayTitle'				=> true,
		'title'						=> 'facebook comments:',
		'numPosts'					=> 10,
		'width'						=> 500,
		'displayLocation'			=> 'before',
		'displayPagesOrPosts'		=> 'posts',
		'publishToWall'				=> true,
		'reverseOrder'				=> false,
		'hideFbLikeButton'			=> false,
		'containerCss'				=> 'margin: 20px 0;',
		'titleCss'					=> 'margin-bottom: 15px; font-size: 140%; font-weight: bold; border-bottom: 2px solid #000; padding-bottom: 5px;',
		'darkSite'					=> '',
		'noBox'						=> false,
		'dashNumComments'			=> 10,
		'v1plusv2'					=> false,
		// 'newUser'					=> false,
		'notifyUserList'			=> '',
		'showDBWidget'				=> false,
		'enableCache'				=> false,
		'commentVersion'			=> 'new',
		'fbCommentCount'			=> true,
		'v2ccstyle'					=> 'border:none; overflow:hidden; width:130px; padding-left:-15px; height:12px;',
		'indexLikebtn'				=> array(	'display'  => 'none',
												'layout' 	=> 'button_count',
												'showFaces' => true,
												'width' 	=> 450,
												'verb' 		=> 'like',
												'font' 		=> 'arial',
												'color' 	=> 'light',
												'style'		=> 'height: 25px; width: 150px; border: medium none; overflow: hidden;'
										),
		'like'						=>  array(  'layout' 	=> 'standard',
												'showFaces' => true,
												'width' 	=> 450,
												'verb' 		=> 'like',
												'font' 		=> 'arial',
												'color' 	=> 'light',
												'style'		=> 'height: 62px; width: 100%;'
										)
	);



	/**********************************
	 Activation hooks/actions
	 **********************************/

	# make sure default settings get loaded on plugin updates
	$oldver = get_option('fbComments_ver');
	if (is_admin() && $oldver != FBCOMMENTS_VER) {
		fbComments_doUpdate();
	} 
	 
	register_activation_hook(__FILE__, 'fbComments_init_hack');
	register_deactivation_hook(__FILE__, 'fbComments_deactivate_hack'); # hack may not be needed here
	register_uninstall_hook(__FILE__, 'fbComments_uninit_hack');		# or here
	
	# stupid wordpress, can't call function in an included file in activation hook?
	function fbComments_init_hack() { fbComments_init(); }
	function fbComments_deactivate_hack() { fbComments_deactivate(); }
	function fbComments_uninit_hack() { fbComments_uninit(); }

	global $fbc_options;  # main options array in wp database options table
	$fbc_options = get_option('fbComments');

	# Display a message prompting the user to enter a Facebook application ID and secret upon plugin activation (if they aren't already set)
	if (get_option('fbComments_displayAppIdWarning')) {
		add_action('admin_notices', create_function( '', "echo '<div class=\"error\"><p><strong>".sprintf(__('The Facebook comments box will not be included in your posts until you set a valid application ID and application secret. Please <a href="%s">set your application ID and secret now</a> using the options page.', 'facebook-comments'), admin_url('options-general.php?page=facebook-comments'))."</strong></p></div>';" ) );

		# display the message only upon activation
		update_option('fbComments_displayAppIdWarning', false);
	}

	# Enqueue correct stylesheet if user wants to hide the WordPress commenting form
	if ($fbc_options['hideWpComments']) {
		function fbComments_enqueueHideWpCommentsCss() {
			wp_register_style('fbComments_hideWpComments', FBCOMMENTS_CSS_HIDEWPCOMMENTS, array(), FBCOMMENTS_VER);
            wp_enqueue_style('fbComments_hideWpComments');
		}

		add_action('init', 'fbComments_enqueueHideWpCommentsCss');
	}

	# Add appropriate language attributes (must use get_option() because $fbc_options[] isn't available at this point)
	if (($fbc_options['includeFbmlLangAttr']) || ($fbc_options['includeOpenGraphLangAttr'])) {
		function fbComments_includeLangAttrs($attributes='') {
			$opts = get_option('fbComments');
			if ($opts['includeFbmlLangAttr']) {
				$attributes .= ' xmlns:fb="http://www.facebook.com/2008/fbml"';
			}

			if ($opts['includeOpenGraphLangAttr']) {
				$attributes .= ' xmlns:og="http://opengraphprotocol.org/schema/"';
			}

			return $attributes;
		}

		add_filter('language_attributes', 'fbComments_includeLangAttrs');
	}

	# Add OpenGraph meta information
	if ($fbc_options['includeOpenGraphMeta']) {
		function fbComments_addOpenGraphMeta() {
			global $wp_query;
			global $fbc_options;

			$postId = $wp_query->post->ID;
		    $postTitle = single_post_title('', false);
		    $postUrl = get_permalink($postId);
		    $siteName = get_bloginfo('name');
		    $appId = $fbc_options['appId'];
			if (strlen($fbc_options['notifyUserList']) > 0) { echo "<meta property='fb:admins' content='{$fbc_options['notifyUserList']}'>"; }
			echo "<meta property='og:title' content='$postTitle' />",
				"<meta property='og:site_name' content='$siteName' />",
				"<meta property='og:url' content='$postUrl' />",
				"<meta property='og:type' content='article' />",
				"<meta property='fb:app_id' content='$appId'>\n";
		}
		add_action('wp_head', 'fbComments_addOpenGraphMeta');
	}


	/**********************************
	 Settings page
	 **********************************/

	add_action('admin_init', 'fbComments_adminPage_init' );
	add_action('admin_menu', 'fbComments_adminPage');

	# Init plugin options to white list our options
	function fbComments_adminPage_init() {
		register_setting('fbComments_options', 'fbComments', 'fbComments_sanatize');
	}

	# Add settings page
	function fbComments_adminPage() {
		add_options_page(__('Facebook Comments for WordPress Options'), __('Facebook Comments'), 'manage_options', 'facebook-comments', 'fbComments_includeAdminPage');
	}

	# Draw the settings page
	function fbComments_includeAdminPage() {
		include('facebook-comments-admin.php');
	}

	# Sanitize and validate input. Accepts an array, returns a sanitized array.
	function fbComments_sanatize($input) {
		$input['title'] = esc_attr($input['title']);
		$input['containerCss'] = esc_attr($input['containerCss']);
		$input['titleCss'] = esc_attr($input['titleCss']);
		$input['dashNumComments'] = absint($input['dashNumComments']);
		$input['numPosts'] = absint($input['numPosts']);
		$input['width'] = absint($input['width']);

		return $input;
	}


	# add "Settings" link to plugin on plugins page
	add_filter('plugin_action_links', 'fbComments_settingsLink', 0, 2);
	function fbComments_settingsLink($actionLinks, $file) {
 		if (($file == 'facebook-comments-for-wordpress/facebook-comments.php') && function_exists('admin_url')) {
			$settingsLink = '<a href="' . admin_url('options-general.php?page=facebook-comments') . '">' . __('Settings') . '</a>';

			# Add 'Settings' link to plugin's action links
			array_unshift($actionLinks, $settingsLink);
		}

		return $actionLinks;
	}

	# display changelog on "Plugins" page
	add_action('after_plugin_row', 'display_changelog', 50, 2);

	# make sure both are set to avoid fatal error upon getting fbapi
	if (empty($fbc_options['appId']) || empty($fbc_options['appSecret'])) {
		fbComments_log("App ID or secret not set, not loading widgets");
	} else {
		# hook for admin dashboard widget
		add_action('init', 'fbcomments_dashboard_widget_init'); # load jquery
		add_action('wp_dashboard_setup', 'fbcomments_add_dashboard_widgets');

		# register FBCRC_Widget widget
		add_filter('the_posts', 'conditionally_add_scripts_and_styles'); # the_posts gets triggered before wp_head
		add_action('widgets_init', create_function('', 'return register_widget("FBCRC_Widget");'));
	}


	/**********************************
	 Program entry point
	 **********************************/
	
	# Ensure we're able to display the comment box
	if ($fbc_options['includeFbComments']) {
		add_filter('comments_array', 'facebook_comments');
	}

	# Display like button on index
	if ('top' == $fbc_options['indexLikebtn']['display'] || 'bottom' == $fbc_options['indexLikebtn']['display']) {
		add_filter('the_content', 'fbc_show_like_index');
	}
	
	# Display facebook comment count instead of WordPress one
	if ($fbc_options['fbCommentCount'] && $fbc_options['commentVersion'] == 'v2') {
		add_filter('comments_number', 'fbc_facebook_comment_count');

	# Else combine the Facebook and WordPress comment counts, if desired
	} else if ($fbc_options['combineCommentCounts'] &&
		!empty($fbc_options['appId']) &&
		!empty($fbc_options['appSecret']) &&
		$fbc_options['commentVersion'] != 'v2') { # we don't want comment caching to load if it's useless--as it is with v2
			add_filter('get_comments_number', 'fbComments_combineCommentCounts');
	}

?>
