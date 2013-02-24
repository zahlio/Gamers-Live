<?php
/**********************************
Common functions
**********************************/

# Update database with default options upon manual plugin activation
function fbComments_init() {
	global $fbComments_defaults, $fbc_options;
	
	add_option('fbComments', $fbComments_defaults); // on first install
	
	# If the plugin has been activated before and we already have the integral settings, cache all Facebook comment counts
	# iff comment caching is enabled. we don't want people with thousands of posts being unable to activate
	if (!empty($fbc_options['appId']) &&
		!empty($fbc_options['appSecret'])) {
			update_option('fbComments_displayAppIdWarning', false);
			if ($fbc_options['enableCache'] == true) { fbComments_cacheAllCommentCounts(); }
	} else { update_option('fbComments_displayAppIdWarning', true); }
}

 /**
 * Load settings from database on update.
 *
 * WordPress 3.1 changed activation hook firing on update. see: http://bit.ly/wp3_1noupdate
 *
 * @since 3.0.2
 */
function fbComments_doUpdate() {
	global $fbComments_defaults, $fbc_options;
	
	if (($_options = get_option('fbComments')) != false) $fbc_options = $_options;
	add_option('fbComments', $fbComments_defaults); # copy defaults to db if fbComments doesn't exist
	
	######		3.1 new settings	######
	$fbc_options['fbCommentCount'] = 'true';
	if (!isset($fbc_options['v2ccstyle'])) $fbc_options['v2ccstyle'] = 'border:none; overflow:hidden; width:130px; padding-left:-15px; height:12px;';
	if (!isset($fbc_options['indexLikebtn'])) {
		$fbc_options['indexLikebtn'] = array('display' => 'none',
				'layout' => 'button_count',
				'showFaces' => true,
				'width' 	=> 450,
				'verb' 		=> 'like',
				'font' 		=> 'arial',
				'color' 	=> 'light',
				'style'		=> 'height: 25px; width: 150px; border: medium none; overflow: hidden;'
		);
	}
	if (!isset($fbc_options['like'])) {
		$fbc_options['like'] = array('layout' => 'standard',
				'showFaces' => true,
				'width' 	=> 450,
				'verb' 		=> 'like',
				'font' 		=> 'arial',
				'color' 	=> 'light',
				'style'		=> 'height: 62px; width: 100%;'
		);
	}
	
	# save id, secret, xid in case upgrading from 3.0.X[.X]
	$save_appId = $fbc_options['appId'];			
	$save_appSecret = $fbc_options['appSecret'];
	$save_xid = $fbc_options['xid'];

	######		3.0.2.2 new settings	######
	if (!isset($fbc_options['dashNumComments'])) $fbc_options['dashNumComments'] = 10;
	if (strlen($fbc_options['commentVersion']) < 1) $fbc_options['commentVersion'] = 'v2migrated';
	
	# handle upgrading from <=2.1.2
	$oldver = get_option('fbComments_ver');
	if (empty($oldver)) {
		$fbc_options['appId'] = get_option('fbComments_appId');
		if (strlen($$fbc_options['appId']) < 1) $fbc_options['appId'] = $save_appId;
		
		$fbc_options['appSecret'] = get_option('fbComments_appSecret');
		if (strlen($fbc_options['appSecret']) < 1) $fbc_options['appSecret'] = $save_appSecret;
		
		$fbc_options['xid'] = get_option('fbComments_xid');	
		if (strlen($fbc_options['xid']) < 1) { $fbc_options['xid'] = $save_xid; }
		
		if (get_option('fbComments_includeFbJs') == true) { $fbc_options['includeFbJs'] = true; }
		if (get_option('fbComments_includeFbJsOldWay') == true) { $fbc_options['includeFbJsOldWay'] = true; }
		if (get_option('fbComments_includeFbmlLangAttr') == true) { $fbc_options['includeFbmlLangAttr'] = true; }
		if (get_option('fbComments_includeOpenGraphLangAttr') == true) { $fbc_options['includeOpenGraphLangAttr'] = true; }
		if (get_option('fbComments_includeOpenGraphMeta') == true) { $fbc_options['includeOpenGraphMeta'] = true; }
		if (get_option('fbComments_includeFbComments') == true) { $fbc_options['includeFbComments'] = true; }
		if (get_option('fbComments_hideWpComments') == true) { $fbc_options['hideWpComments'] = true; } 
		if (get_option('fbComments_combineCommentCounts') == true) { $fbc_options['combineCommentCounts'] = true; }
		if (get_option('fbComments_notify') == true) { $fbc_options['notify'] = true; }
		if (get_option('fbComments_displayTitle') == true) { $fbc_options['displayTitle'] = true; }
		if (get_option('fbComments_publishToWall') == true) { $fbc_options['publishToWall'] = true; }
		if (get_option('fbComments_reverseOrder') == true) { $fbc_options['reverseOrder'] = true; }
		if (get_option('fbComments_darkSite') == true) { $fbc_options['darkSite'] = true; }
		if (get_option('fbComments_noBox') == true) { $fbc_options['noBox'] = true; }
		if (strlen($fbc_options['language']) < 1) { $fbc_options['language'] = get_option('fbComments_language'); }
		if (strlen($_title = get_option('fbComments_title')) > 1) $fbc_options['title'] = $_title;
		if (strlen($_numPosts = get_option('fbComments_numPosts')) > 1) $fbc_options['numPosts'] = $_numPosts;
		if (strlen($_width = get_option('fbComments_width')) > 1) $fbc_options['width'] = $_width;
		if (strlen($_displayPagesOrPosts = get_option('fbComments_displayPagesOrPosts')) > 1) $fbc_options['displayPagesOrPosts'] = $_displayPagesOrPosts;
		if (strlen($_containerCss = get_option('fbComments_containerCss')) > 1) $fbc_options['containerCss'] = $_containerCss;
		if (strlen($_titleCss = get_option('fbComments_titleCss')) > 1) $fbc_options['titleCss'] = $_titleCss;
	}
	
	update_option('fbComments_ver', FBCOMMENTS_VER);
	update_option('fbComments', $fbc_options);
}

// Email the site owner the current XID upon plugin deactivation
function fbComments_deactivate() {
	global $fbc_options;
	
	$to = get_bloginfo('admin_email');
	$subject = "[Facebook Comments for WordPress] Your current XID";

	$message = "Thanks for trying out Facebook Comments for WordPress!\n\n" .
			   "We just thought you'd like to know that your current XID is: {$fbc_options['xid']}.\n\n" .
			   "This should be saved in your website's database, but in case it gets lost, you'll need this unique key to retrieve your comments should you ever choose to activate this plugin again.\n\n" .
			   "Have a great day!";

	// Wordwrap the message and strip slashes that may have wrapped quotes
	$message = stripslashes(wordwrap($message, 70));

	$headers = "From: Facebook Comments for WordPress <$to>\r\n" .
			   "Reply-To: $to\r\n" .
			   "X-Mailer: PHP" . phpversion();

	// Send the email notification
	fbComments_log("Sending XID via email to $to");
	if (wp_mail($to, $subject, $message, $headers)) {
		fbComments_log(sprintf('    Sent XID via email to %s', $to));
	} else {
		fbComments_log(sprintf('    FAILED to send XID via email to %s', $to));
	}
}

// Remove database entries upon the plugin being uninstalled
function fbComments_uninit() {
	delete_option('fbComments');
}


// Generate a random alphanumeric string for the comments XID
function fbComments_getRandXid($length=15) {
	$chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
	$rand = '';

	for ($i = 0; $i < $length; $i++) {
		$rand .= $chars[mt_rand(0, count($chars)-1)];
	}

	return $rand;
}

// The application ID and application secret must be set before calling this function
function fbComments_getFbApi() {
	global $fbc_options;
	
	$fbApiCredentials = array(
		'appId'	 => $fbc_options['appId'],
		'secret' => $fbc_options['appSecret']
	);

	return new Facebook($fbApiCredentials);
}

// The application ID and application secret must be set before calling this function
function fbComments_storeAccessToken() {
	fbComments_log('In ' . __FUNCTION__ . '()');
	global $fbc_options;

	if (!$fbc_options['accessToken']) {
		$accessToken = fbComments_getUrl("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id={$fbc_options['appId']}&client_secret={$fbc_options['appSecret']}");
		fbComments_log("    got an access token of [$accessToken]");
		if (strpos($accessToken,'<div class="error">') == 0) { $accessToken = substr($accessToken, 13); }
		else { echo '<hr />didnt find accesstoken line 161 comments-core<hr />'; $accessToken = ''; }
		if ($accessToken != '') {
			fbComments_log("    Storing an access token of $accessToken");
			$fbc_options['accessToken'] = $accessToken;
			update_option('fbComments', $fbc_options);
		} else {
			fbComments_log('    FAILED to obtain an access token');
		}
	}
}

// sugar for calling wp_remote_get
function fbComments_getUrl($url) {

	$file_contents = wp_remote_get($url,
				  $args = array('method' 		=> 'GET',
								'timeout' 		=> '5',
								'redirection' 	=> '5',
								'user-agent' 	=> 'WordPress facebook comments plugin',
								'blocking'		=> true,
								'compress'		=> false,
								'decompress'	=> true,
								'sslverify'		=> false
						));
	if (is_array($file_contents)) $file_contents = $file_contents['body'];
	else $file_contents = '<div class="error"><p><strong>' . __("Request to facebook timed-out. Please try again in a few moments.") . '</strong></p></div>';
	
	

	fbComments_log('In ' . __FUNCTION__ . "(url=$url)");

	if (!$file_contents) {
		fbComments_log('    FAILED to retrieve content via wp_remote_get');
	}

	return $file_contents;
}

/**
* Display changelog on plugin settings page
*
* @since 3.1
*/
function display_changelog( $file, $plugin_data ) {
if ($file == 'facebook-comments-for-wordpress/facebook-comments.php') {
	global $wp_version;
	
	if( is_plugin_active( 'wp-manage-plugins/wp-manage-plugins.php' ) ) {
		$plugins_ignored = get_option('plugin_update_ignore');
		if ( in_array( $file, array_keys($plugins_ignored) ) )
			return false;
	}
	
	$cur_wp_version = preg_replace('/-.*$/', '', $wp_version);
	$current = get_site_transient( 'update_plugins' );
	if (!isset($current->response[$file])) return false;
	
	$output = '';
	
	$r = $current->response[ $file ];
	include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
	$columns = 3;
	
	$cache_key = 'plugin_changelog_' . $r->slug;
	$output = wp_cache_get($cache_key, 'fbc_clog');
	if (false === $output) {
		$api = plugins_api('plugin_information', array('slug' => $r->slug, 'fields' => array('tested' => true, 'requires' => false, 'rating' => false, 'downloaded' => false, 'downloadlink' => false, 'last_updated' => false, 'homepage' => false, 'tags' => false, 'sections' => true) ));
		if ( !is_wp_error( $api ) && current_user_can('update_plugins') ) {
			$is_active = is_plugin_active( $file );
			$class = $is_active ? 'active' : 'inactive';
			$class_tr = ' class="plugin-update-tr second ' . $class . '"';
			
			$output .= '<tr' . $class_tr . '><td class="plugin-update clos-plugin-update" colspan="' . $columns . '"><div class="update-message clos-message" id="clos-message-' . $r->slug . '">';
			
			$changes = file_get_contents("../wp-content/plugins/facebook-comments-for-wordpress/readme.txt");
			$changes = strstr($changes, '= '.FBCOMMENTS_VER.' =');
			$changes = str_replace("\n",'<br />',$changes);
			$changes = substr($changes, 0, strpos($changes, '=', 14));
			$version = substr($changes, 0, $pos=strpos($changes, '<br />'));
			$version = str_replace(' ','', str_replace('=','', $version));
			$changes = substr($changes, $pos+6,strlen($changes));
			$changes = $version.'<div style="font-weight:normal">'.$changes.'</div>';
			$output .= sprintf(__('What\'s changed in version %1$s'), $changes);
			if ( isset($api->tested) && version_compare($api->tested, $cur_wp_version, '>=') ) {
				$output .= ' ' . sprintf(__('Compatibility with WordPress %1$s: 100%% (according to we8u)'), $cur_wp_version);
			} elseif ( isset($api->compatibility[$cur_wp_version][$r->new_version]) ) {
				$compat = $api->compatibility[$cur_wp_version][$r->new_version];
				$output .= ' ' . sprintf(__('Compatibility with WordPress %1$s: %2$d%% (%3$d of %4$d say it works)'), $cur_wp_version, $compat[0], $compat[2], $compat[1]);
			} else {
				$output .= ' ' . sprintf(__('Compatibility with WordPress %1$s: Unknown'), $cur_wp_version);
			}
			$output .= ' </div></td></tr>';
					
		} else {
			$output .= '<tr class="plugin-update-tr"><td colspan="' . $columns . '"><div class="update-message clos-message">';
			$output .= sprintf(__('<strong>ERROR</strong>: %s'), $api->get_error_message());
			$output .= '</div></td></tr>';
		}
		wp_cache_set($cache_key, $output, 'fbc_clog', 60*60*3);
	}
	echo $output;

} # end if
} # end display_changelog


// Log to the Apache error log (usually located in /var/log/apache2/error_log)
function fbComments_log($msg) {
	if (FBCOMMENTS_ERRORS) {
		error_log('fbComments: ' . $msg);
	}
}
?>