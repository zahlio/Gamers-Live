<?php

if (FBCOMMENTS_ERRORS) {
	error_reporting(E_ALL); # Ensure all errors and warnings are verbose
}

try {
	$homeurl = home_url('/');
} catch (Exception $e) {
	$homeurl = get_bloginfo( 'home' );
	echo '<div class="error"><p><strong>' . __('This plugin requires WordPress 3.0.4 or above. You are using ') . get_bloginfo( 'version' ) . __('. This plugin may still work, however it is not supported. Please update to the latest version of WordPress for the best experience.') . '</strong></p></div>';
}
$id_help = <<< END
<p>Need help? Okay, do you have a facebook app?</p>
<p><strong>Yes, I do</strong></p>
<ol>
<li>Get a list of your applications from here: <a target="_blank" href="http://www.facebook.com/developers/apps.php">Facebook Application List</a></li>
<li>Select the application you want, then copy and paste the Application ID and Application Secret from there to the boxes below.</li>
</ol>

<p><strong>No, I haven't created an application yet</strong></p>
<ol>
<li>Go here to create it: <a target="_blank" href="//www.facebook.com/developers/createapp.php">Create a facebook app</a></li>
<li>Good, your app is created. Now, make sure it knows where it's used: On the app's page, click "Edit Settings", then from the left navigation, click "Web Site".
	You should now see "Core Settings". Copy <strong>{$homeurl}</strong> and paste it in the "Site URL" box. Now click "Save Changes". Done!</li>
<li>Get your app id and app secret from here:
<a target="_blank" href="http://www.facebook.com/developers/apps.php">Facebook Application List</a></li>
<li>Select the application you created, then copy and paste the Application ID and Application Secret from there to the boxes below.</li>
</ol>
END;


if (version_compare(phpversion(), FBCOMMENTS_REQUIRED_PHP_VER) == -1) {
			echo '<div class="error"><p><strong>' . __('This plugin requires PHP v') . FBCOMMENTS_REQUIRED_PHP_VER . __(' or higher to run (you have PHP v')
			. phpversion() . __('). Please ask your webhost to install the latest version of PHP on your server.') . '</strong></p></div>';
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo FBCOMMENTS_CSS_ADMIN; ?>" />

<div class="wrap">
  <?php screen_icon(); ?>
  <h2><?php _e('Facebook Comments for WordPress Options'); ?></h2>

  <form method="post" action="options.php">
	 <table border="1" style="width:100%">
	<tbody><tr>
	<td style="width:33%"> <input type="submit" class="button-primary" value="<?php _e('Update Options'); ?>" /></div> </td>
	<td style="width:33%"> <div id="icon-help"></div>
		<h6><?php _e('If you need help, please refer to the <a href="http://bit.ly/i3lThG">official FAQ</a>'); ?>
		</h6>

	</td>
	<td style="width:auto">
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=fbc%40we8u%2ecom&lc=US&item_name=Facebook%20Comments%20for%20WordPress&item_number=shaunds&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">
		<img class="ppimg donateButton" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" style="float:right" /></a>
	</td>
	</tr></tbody>
  </table>

<?php
	settings_fields('fbComments_options');
	$fbc_options = get_option('fbComments');

	$errors = false;
	$response = wp_remote_get("https://www.facebook.com/apps/application.php?".http_build_query(array('id'=>$fbc_options['appId'])),
				$args = array('method' => 'GET',
							'timeout' => '5',
							'redirection' => '5',
							'user-agent' => 'WordPress facebook comments plugin',
							'blocking' => true,
							'compress' => false,
							'decompress' => true,
							'sslverify' => false
					));
		
	if (is_array($response)) {
		$response = $response['body'];
		$needle = 'wall';
		if ( strpos($response, $needle) == false ) {
			// $fbc_options['appId'] = 'INVALID APP ID';
			$errors = 'ERROR! Invalid application ID. Please double check to make sure it is correct. Note that this is not the same thing as your Facebook user ID';
		}
	} else echo '<div class="error fade"><p><strong>' . __("Unable to verify application ID. This may be due to a network error. Ignore this warning if you know you have input the correct ID.") . '</strong></p></div>';
	
	if (empty($fbc_options['appId']) || empty($fbc_options['appSecret']))
		echo '<div class="error"><p><strong>' . __('The Facebook comments box will not be included in your posts until you set a valid application ID and application secret.').'</strong></p>'.$id_help.'</div>';
	elseif ($errors != false)
		echo '<div class="error"><p><strong>' . __($errors) . '</strong></p>'.$id_help.'</div>';

	$_loadversion = get_option('fbComments_xid');
	# 2.1.2 loaded?
	$_loadversion = (strlen($_loadversion) < 1) ? 'loaded' : $_loadversion;
?>

	<div class="updated">XID from version 2.1.2: <?php if($_loadversion) echo $_loadversion; ?></div>
	<div id="poststuff" class="postbox">
		<h3><?php _e('Enable/Disable Facebook\'s New Comment System'); ?></h3>

		<div class="inside">
			<p><?php _e('Enable the just-released version of facebook\'s '.
						'comment plugin. This is quite new, and some people are having problems. '.
						'See discussion <a href="http://bit.ly/fuoDaM">here</a><br />
						* Selecting "new" will show comments from both the old system and the new one in the same comment box (migrated="1", as described in the above link).<br />
						* "v1 only" will use only the old system <em>(only way to have custom css, like button, etc.)</em>.<br />
						* "v2 only" will use only the new system. This is the only way to get all the features of the new system (unless you select the option below).<br />'); ?>
				<select name="fbComments[commentVersion]">
					<option value="v2migrated"<?php if ($fbc_options['commentVersion'] == 'v2migrated') echo ' selected="selected"'; ?>>new</option>
					<option value="v1"<?php if ($fbc_options['commentVersion'] == 'v1') echo ' selected="selected"'; ?>>v1 only</option>
					<option value="v2"<?php if ($fbc_options['commentVersion'] == 'v2') echo ' selected="selected"'; ?>>v2 only</option>
				</select>
			</p>
			<p><input type="checkbox" id="fbComments_v1plusv2" name="fbComments[v1plusv2]" value="1" <?php checked($fbc_options['v1plusv2'], 1 ); ?>>
				<label for="fbComments_v1plusv2"> <?php _e('Display both v1 and v2 comments; ignores above setting (<b>only way to have both new and old comments show up</b>)'); ?>
				</label>
			</p>
			<?php /*
			<p><input type="checkbox" id="fbComments_newUser" name="fbComments[newUser]" value="1" <?php checked($fbc_options['newUser'], 1 ); ?> size="20">
				<label for="fbComments_newUser"> <?php _e('If you are a <b>new user</b> of this plugin or currently <b>have no comments</b> on your site, '.
					'then check this box (you can ignore the above setting if you check this) <b>DON\'T CHECK IF YOUR SITE HAS COMMENTS</b>'); ?>
				</label>
			</p> */ ?>
		</div>
	</div>

	<div id="poststuff" class="postbox">
		<h3><?php _e('Basic Settings'); ?></h3>

		<div class="inside">
			<p><?php _e('Application ID (<a target="_blank" href="//we8u.com/facebook-comments/#install">Help</a>): '); ?>
				<input type="text" name="fbComments[appId]" value="<?php echo $fbc_options['appId']; ?>" size="20">
				<em><?php _e(' (This can be retrieved from your <a target="_blank" href="//www.facebook.com/developers/apps.php">Facebook application page</a>)'); ?></em></p>

			<p><?php _e('Application Secret (<a target="_blank" href="//we8u.com/facebook-comments/#install">Help</a>): '); ?>
				<input type="text" name="fbComments[appSecret]" value="<?php echo $fbc_options['appSecret']; ?>" size="20">
				<em><?php _e(' (This can be retrieved from your <a target="_blank" href="//www.facebook.com/developers/apps.php">Facebook application page</a>)'); ?></em></p>

			<p><input type="checkbox" id="fbComments_includeFbComments" name="fbComments[includeFbComments]" value="1" <?php checked($fbc_options['includeFbComments'], 1 ); ?> size="20">
				<label for="fbComments_includeFbComments"><?php _e(' Include Facebook comments on blog'); ?></label>
				<em><?php _e(" (Uncheck this if you want to hide the Facebook comments without having to deactivate the plugin)"); ?></em></p>

			<p><input type="checkbox" id="fbComments_hideWpComments" name="fbComments[hideWpComments]" value="1" <?php checked($fbc_options['hideWpComments'], 1 ); ?> size="20">
				<label for="fbComments_hideWpComments"> <?php _e('Hide WordPress comments on posts/pages where Facebook commenting is enabled'); ?></label></p>

			<p><input type="checkbox" id="fbComments_combineCommentCounts" name="fbComments[combineCommentCounts]" value="1" <?php checked($fbc_options['combineCommentCounts'], 1 ); ?> size="20">
				<label for="fbComments_combineCommentCounts"> <?php _e('Combine WordPress and Facebook comment counts (<em>only counts "v1 only" and "new", use below option if using "v2 only"</em>)'); ?></label></p>

			<p><input type="checkbox" id="fbComments_fbCommentCount" name="fbComments[fbCommentCount]" value="1" <?php checked($fbc_options['fbCommentCount'], 1 ); ?>>
				<label for="fbComments_fbCommentCount"> <?php _e('Enable native facebook comment count (<em>does nothing unless "v2 only" is selected</em>).'); ?>
				</label>
			</p>
				
			<p><input type="checkbox" id="fbComments_showDBWidget" name="fbComments[showDBWidget]" value="1" <?php checked($fbc_options['showDBWidget'], 1 ); ?>>
				<label for="fbComments_newUser"> <?php _e('Show the Dashboard Recent Comments admin widget'); ?>
				</label>
			</p>

			<p><input type="checkbox" id="fbComments_enableCache" name="fbComments[enableCache]" value="1" <?php checked($fbc_options['enableCache'], 1 ); ?>>
				<label for="fbComments_enableCache"> <?php _e('Enable comment caching (<em>enable if site is loading slowly</em>).'); ?>
				</label>
			</p>
			
			<p><input type="checkbox" id="fbComments_darkSite" name="fbComments[darkSite]" value="1" <?php checked($fbc_options['darkSite'], 1 ); ?> size="20">
				<label for="fbComments_darkSite"><?php _e('<em>*just added*</em> Use colors more easily visible on a <strong>dark</strong> website'); ?>
				</label>
			</p>

			

			<p><a href="https://developers.facebook.com/tools/comments/?id=<?php echo $fbc_options['appId']; ?>">
			<img class="img" src="https://s-static.ak.facebook.com/rsrc.php/v1/yh/r/sFEt4HFKXwP.gif" style="top: -1px;" width="15" height="16" />
			Moderation Settings</a> <!--<em><strong>(inline editing of these settings is in development)</strong></em> --></p>
		</div>
	</div>
	
	<div id="poststuff" class="postbox">
		<h3><?php _e('v2 Comment Count Style'); ?></h3>	
		<div class="inside">
			<p><?php _e("Anything you type here will be passed as is (so make sure it's correct) to the 'style=' of the comment count container "); ?>
				<input type="text" name="fbComments[v2ccstyle]" value="<?php echo $fbc_options['v2ccstyle']; ?>" size="90" /></p>
		</div>
	</div>
	
	<div id="poststuff" class="postbox">
		<h3><?php _e('Like Button Settings'); ?></h3>
		
		<?php
		$likebtn = "<iframe src='http://www.facebook.com/plugins/like.php?"
			.'href=we8u.com/facebook-comments&amp;'
			."layout={$fbc_options['like']['layout']}".'&amp;';
		$likebtn .= ($fbc_options['like']['faces']) ? "show_faces=true" : "show_faces=false";
		$likebtn .= '&amp;'
			."width={$fbc_options['like']['width']}".'&amp;'
			."action={$fbc_options['like']['verb']}".'&amp;'
			."font={$fbc_options['like']['font']}".'&amp;'
			."colorscheme={$fbc_options['like']['color']}"
			."' scrolling='no' frameborder='0' style='{$fbc_options['like']['style']}' allowTransparency='true'></iframe>";
			
		$indexlikebtn = "<iframe src='http://www.facebook.com/plugins/like.php?"
			.'href=we8u.com/&amp;'
			."layout={$fbc_options['indexLikebtn']['layout']}".'&amp;';
		$indexlikebtn .= ($fbc_options['indexLikebtn']['faces']) ? "show_faces=true" : "show_faces=false";
		$indexlikebtn .= '&amp;'
			."width={$fbc_options['indexLikebtn']['width']}".'&amp;'
			."action={$fbc_options['indexLikebtn']['verb']}".'&amp;'
			."font={$fbc_options['indexLikebtn']['font']}".'&amp;'
			."colorscheme={$fbc_options['indexLikebtn']['color']}"
			."' scrolling='no' frameborder='0' style='{$fbc_options['indexLikebtn']['style']}' allowTransparency='true'></iframe>";
		?>
		
		<div class="inside">
		<p><?php _e("Note, the style of the like button depends on the tag <code>&lt;meta property='og:type' content='article' /&gt;</code><br />
			Here, the left button has <code>content='product'</code>, while the right has <code>content='article'</code><br />
			<strong>click 'Update Options' to see the effect of changeing each's settings</strong>") ?>
		</p>
		<hr style="width:auto" />
		<table><tr>
			<td style="border-right: 1px dotted" VALIGN="top">
			<div><p><?php 
					if (!$fbc_options['hideFbLikeButton']) echo $likebtn;
					else echo '<span style="font-size:1.2em; font-weight:bold">Hiding like button</span>';
					?>
				</p></div>
			
			<p><input type="checkbox" id="fbComments_hideFbLikeButton" name="fbComments[hideFbLikeButton]" value="1" <?php checked($fbc_options['hideFbLikeButton'], 1 ); ?> size="20">
				<label for="fbComments_hideFbLikeButton"><?php _e(' Hide the Like button and text '); ?></label></p>
		
			<p><?php _e('Layout Sytle '); ?>
				<select name="fbComments[like][layout]">
					<option value="standard"<?php if ($fbc_options['like']['layout'] == 'standard') echo ' selected="selected"'; ?>>standard</option>
					<option value="button_count"<?php if ($fbc_options['like']['layout'] == 'button_count') echo ' selected="selected"'; ?>>button_count</option>
					<option value="box_count"<?php if ($fbc_options['like']['layout'] == 'box_count') echo ' selected="selected"'; ?>>box_count</option>
				</select>
			</p>
			<p><input type="checkbox" id="fbComments_like_faces" name="fbComments[like][faces]" value="1" <?php checked($fbc_options['like']['faces'], 1 ); ?> size="20">
				<label for="fbComments_like_faces"> <?php _e('Show profile pictures below like button for friends who "like"'); ?></label></p>
			
			<p><?php _e('Width '); ?>
				<input type="text" name="fbComments[like][width]" value="<?php echo $fbc_options['like']['width']; ?>" size="10" /></p>
				
			<p><?php _e('Verb '); ?>
				<select name="fbComments[like][verb]">
					<option value="like"<?php if ($fbc_options['like']['verb'] == 'like') echo ' selected="selected"'; ?>>like</option>
					<option value="recommend"<?php if ($fbc_options['like']['verb'] == 'recommend') echo ' selected="selected"'; ?>>recommend</option>
				</select>
			</p>
			<p><?php _e('Font '); ?>
				<select name="fbComments[like][font]">
					<option <?php if ($fbc_options['like']['font'] == '') echo ' selected="selected"'; ?>></option>
					<option value="arial"<?php if ($fbc_options['like']['font'] == 'arial') echo ' selected="selected"'; ?>>arial</option>
					<option value="lucida+grande"<?php if ($fbc_options['like']['font'] == 'lucida+grande') echo ' selected="selected"'; ?>>lucida grande</option>
					<option value="segoe+ui"<?php if ($fbc_options['like']['font'] == 'segoe+ui') echo ' selected="selected"'; ?>>segoe ui</option>
					<option value="tahoma"<?php if ($fbc_options['like']['font'] == 'tahoma') echo ' selected="selected"'; ?>>tahoma</option>
					<option value="trebuchet+ms"<?php if ($fbc_options['like']['font'] == 'trebuchet+ms') echo ' selected="selected"'; ?>>trebuchet ms</option>
					<option value="verdana"<?php if ($fbc_options['like']['font'] == 'verdana') echo ' selected="selected"'; ?>>verdana</option>
				</select>
			</p>
			<p><?php _e('Color Scheme '); ?>
				<select name="fbComments[like][color]">
					<option value="light"<?php if ($fbc_options['like']['color'] == 'light') echo ' selected="selected"'; ?>>light</option>
					<option value="dark"<?php if ($fbc_options['like']['color'] == 'dark') echo ' selected="selected"'; ?>>dark</option>
				</select>
				<?php _e('<em>light for light backgrounds, dark for dark</em>'); ?>
			</p>
			
			<p><?php _e('CSS Style <br />'); ?>
				<input type="text" name="fbComments[like][style]" value="<?php echo $fbc_options['like']['style']; ?>" size="60" /></p>
			</td>
			
			<td VALIGN="top">
			
			<div><p><?php 
					if ($fbc_options['indexLikebtn']['display'] != 'none') echo $indexlikebtn;
					else echo '<span style="font-size:1.2em; font-weight:bold">Hiding like button</span>';
					?>
				</p></div>
			
			<p><?php _e('Where to display a like button on each post on front page of site (index.php for most people) <br />'); ?>
				<select name="fbComments[indexLikebtn][display]">
					<option value="none"<?php if ($fbc_options['indexLikebtn']['display'] == 'none') echo ' selected="selected"'; ?>>don't</option>
					<option value="top"<?php if ($fbc_options['indexLikebtn']['display'] == 'top') echo ' selected="selected"'; ?>>at the top of each post</option>
					<option value="bottom"<?php if ($fbc_options['indexLikebtn']['display'] == 'bottom') echo ' selected="selected"'; ?>>at the bottom of each post</option>
				</select>
			</p>
			
			<p><select name="fbComments[indexLikebtn][layout]">
					<option value="standard"<?php if ($fbc_options['indexLikebtn']['layout'] == 'standard') echo ' selected="selected"'; ?>>standard</option>
					<option value="button_count"<?php if ($fbc_options['indexLikebtn']['layout'] == 'button_count') echo ' selected="selected"'; ?>>button_count</option>
					<option value="box_count"<?php if ($fbc_options['indexLikebtn']['layout'] == 'box_count') echo ' selected="selected"'; ?>>box_count</option>
				</select></p>
				
			<p><input type="checkbox" id="fbComments_indexLikebtn_faces" name="fbComments[indexLikebtn][faces]" value="1" <?php checked($fbc_options['indexLikebtn']['faces'], 1 ); ?> size="20">
				<label for="fbComments_indexLikebtn_faces"> <?php _e('Show profile pictures'); ?></label></p>
			
			<p><?php _e('Width '); ?>
				<input type="text" name="fbComments[indexLikebtn][width]" value="<?php echo $fbc_options['indexLikebtn']['width']; ?>" size="10" /></p>
				
			<p><?php _e('Verb '); ?>
				<select name="fbComments[indexLikebtn][verb]">
					<option value="like"<?php if ($fbc_options['indexLikebtn']['verb'] == 'like') echo ' selected="selected"'; ?>>like</option>
					<option value="recommend"<?php if ($fbc_options['indexLikebtn']['verb'] == 'recommend') echo ' selected="selected"'; ?>>recommend</option>
				</select>
			</p>
			<p><?php _e('Font '); ?>
				<select name="fbComments[indexLikebtn][font]">
					<option <?php if ($fbc_options['indexLikebtn']['font'] == '') echo ' selected="selected"'; ?>></option>
					<option value="arial"<?php if ($fbc_options['indexLikebtn']['font'] == 'arial') echo ' selected="selected"'; ?>>arial</option>
					<option value="lucida+grande"<?php if ($fbc_options['indexLikebtn']['font'] == 'lucida+grande') echo ' selected="selected"'; ?>>lucida grande</option>
					<option value="segoe+ui"<?php if ($fbc_options['indexLikebtn']['font'] == 'segoe+ui') echo ' selected="selected"'; ?>>segoe ui</option>
					<option value="tahoma"<?php if ($fbc_options['indexLikebtn']['font'] == 'tahoma') echo ' selected="selected"'; ?>>tahoma</option>
					<option value="trebuchet+ms"<?php if ($fbc_options['indexLikebtn']['font'] == 'trebuchet+ms') echo ' selected="selected"'; ?>>trebuchet ms</option>
					<option value="verdana"<?php if ($fbc_options['indexLikebtn']['font'] == 'verdana') echo ' selected="selected"'; ?>>verdana</option>
				</select>
			</p>
			<p><?php _e('Color Scheme '); ?>
				<select name="fbComments[indexLikebtn][color]">
					<option value="light"<?php if ($fbc_options['indexLikebtn']['color'] == 'light') echo ' selected="selected"'; ?>>light</option>
					<option value="dark"<?php if ($fbc_options['indexLikebtn']['color'] == 'dark') echo ' selected="selected"'; ?>>dark</option>
				</select>
			</p>
			
			<p><?php _e('CSS Style <span style="font-size:.8em"><em>(min height is 62px if displaying profile pics or using "box_count", 25px otherwise)</em></span><br />'); ?>
				<input type="text" name="fbComments[indexLikebtn][style]" value="<?php echo $fbc_options['indexLikebtn']['style']; ?>" size="60" /></p>
			
			</td>
		</tr></table>
		</div>
	</div>
	
	<div id="poststuff" class="postbox">
		<h3><?php _e('"v1 only" Settings'); ?></h3>

		<div class="inside">
			<h3><?php _e('Comments Box Settings'); ?></h3>
			<p><input type="checkbox" id="fbComments_reverseOrder" name="fbComments[reverseOrder]" value="1" <?php checked($fbc_options['reverseOrder'], 1 ); ?> size="20">
				<label for="fbComments_reverseOrder"><?php _e(' Reverse the order of the Facebook comments section'); ?></label>
				<em><?php _e('  (Comments will appear in chronological order and the composer will be at the bottom)'); ?></em></p>
		
			<br />
			<h3><?php _e('Style Settings'); ?></h3>
			<p><?php _e('Container Styles: '); ?><input type="text" name="fbComments[containerCss]" value="<?php echo $fbc_options['containerCss']; ?>" size="70">
				<em><?php _e(' (These styles will be applied to a &lt;div&gt; element wrapping the comments box)'); ?></em></p>
		
			<p><input type="checkbox" id="fbComments_noBox" name="fbComments[noBox]" value="1" <?php checked($fbc_options['noBox'], 1 ); ?> size="20">
				<label for="fbComments_noBox"><?php _e(' Remove grey box surrounding Facebook comments'); ?></label></p>
			
		</div>
	</div>

	<div id="poststuff" class="postbox">
		<h3><?php _e('Notification Settings'); ?></h3>

		<div class="inside">
			<p><input type="checkbox" id="fbComments_notify" name="fbComments[notify]" value="1" <?php checked($fbc_options['notify'], 1 ); ?> size="20">
				<label for="fbComments_notify"><?php _e(' Email me whenever a comment is posted'); ?></label>
				<em><?php _e(" (Email notifications will be sent to the following address: " . get_bloginfo('admin_email') . ". You can change this on the <a href='" .  admin_url('options-general.php') . "'>General Settings</a> page)"); ?></em></p>

			<p><?php _e('Notify these facebook users of new comments (user ID, see <a href="//www.facebook.com/note.php?note_id=91532827198">here</a>): '); ?>
				<input type="text" name="fbComments[notifyUserList]" value="<?php echo $fbc_options['notifyUserList']; ?>" size="60">
				<em><?php _e(' <br />for multiple users, seperate with commas and no spaces (e.g., ID1,ID2,ID3)'); ?></em></p>
		</div>
	</div>


	<div id="poststuff" class="postbox">
		<h3><?php _e('Comments Box Settings'); ?></h3>

		<div class="inside">
			<p><?php _e('Facebook Comments Section Title: '); ?><input type="text" name="fbComments[title]" value="<?php echo $fbc_options['title']; ?>" size="30">
				<em><?php _e(' (This is the title text displayed above the Facebook commenting section)'); ?></em></p>

			<p><input type="checkbox" id="fbComments_displayTitle" name="fbComments[displayTitle]" value="1" <?php checked($fbc_options['displayTitle'], 1 ); ?> size="20">
				<label for="fbComments_displayTitle"><?php _e(' Display the Facebook comments title (set above)'); ?></label></p>

			<p><?php _e('Number of Posts to Display: '); ?><input type="text" name="fbComments[numPosts]" value="<?php echo $fbc_options['numPosts']; ?>" size="5" maxlength="3"></p>

			<p><?php _e('Width of Comments Box (px): '); ?><input type="text" name="fbComments[width]" value="<?php echo $fbc_options['width']; ?>" size="5" maxlength="4"></p>

			<p><?php _e('Display Facebook comments before or after WordPress comments? '); ?>
				<select name="fbComments[displayLocation" disabled="disabled">
					<option value="before"<?php if ($fbc_options['displayLocation'] == 'before') echo ' selected="selected"'; ?>>Before</option>
					<option value="after"<?php if ($fbc_options['displayLocation'] == 'after') echo ' selected="selected"'; ?>>After</option>
				</select>
				<em><?php _e(" (<strong>In development; <a target='_blank' href='" . FBCOMMENTS_WEBPAGE . "#comment_placement'>see here</a> for manual instructions</strong>)"); ?></em>
			</p>
			<p><?php _e('Display Facebook comments on pages only, posts only or both? '); ?>
				<select name="fbComments[displayPagesOrPosts]">
					<option value="both"<?php if ($fbc_options['displayPagesOrPosts'] == 'both') echo ' selected="selected"'; ?>>Both</option>
					<option value="pages"<?php if ($fbc_options['displayPagesOrPosts'] == 'pages') echo ' selected="selected"'; ?>>Pages only</option>
					<option value="posts"<?php if ($fbc_options['displayPagesOrPosts'] == 'posts') echo ' selected="selected"'; ?>>Posts only</option>
				</select>
			</p>
			<p><input type="checkbox" id="fbComments_publishToWall" name="fbComments[publishToWall]" value="1" <?php checked($fbc_options['publishToWall'], 1 ); ?> size="20">
				<label for="fbComments_publishToWall"><?php _e(' Check the <strong>Post comment to my Facebook profile</strong> box by default'); ?></label></p>

			

		</div>
	</div>

	<div id="poststuff" class="postbox">
		<h3><?php _e('Style Settings'); ?></h3>
		
		<div class="inside">
			<p><?php _e('Title Styles: '); ?><input type="text" name="fbComments[titleCss]" value="<?php echo $fbc_options['titleCss']; ?>" size="70">
				<em><?php _e(' (These styles will be applied to the title text above the comments box)'); ?></em></p>
		</div>
	</div>

	<div id="poststuff" class="postbox">
		<h3><?php _e('Dashboard Widget Settings'); ?></h3>

		<div class="inside">
			<p><?php _e('Number of Comments to Display: '); ?>
				<input type="text" name="fbComments[dashNumComments]" value="<?php echo $fbc_options['dashNumComments']; ?>" size="5" maxlength="3"></p>
		</div>
	</div>

	<div id="poststuff" class="postbox">
		<h3><?php _e('Language Settings'); ?></h3>

		<div class="inside">
			<p><?php _e('Language for comments: '); ?>
			<select name="fbComments[language]">
				<option value="af_ZA"<?php if ($fbc_options['language'] == 'af_ZA') echo ' selected="selected"'; ?>>Afrikaans</option>
				<option value="sq_AL"<?php if ($fbc_options['language'] == 'sq_AL') echo ' selected="selected"'; ?>>Albanian</option>
				<option value="ar_AR"<?php if ($fbc_options['language'] == 'ar_AR') echo ' selected="selected"'; ?>>Arabic</option>
				<option value="hy_AM"<?php if ($fbc_options['language'] == 'hy_AM') echo ' selected="selected"'; ?>>Armenian</option>
				<option value="ay_BO"<?php if ($fbc_options['language'] == 'ay_BO') echo ' selected="selected"'; ?>>Aymara</option>
				<option value="az_AZ"<?php if ($fbc_options['language'] == 'az_AZ') echo ' selected="selected"'; ?>>Azeri</option>
				<option value="eu_ES"<?php if ($fbc_options['language'] == 'eu_ES') echo ' selected="selected"'; ?>>Basque</option>
				<option value="be_BY"<?php if ($fbc_options['language'] == 'be_BY') echo ' selected="selected"'; ?>>Belarusian</option>
				<option value="bn_IN"<?php if ($fbc_options['language'] == 'bn_IN') echo ' selected="selected"'; ?>>Bengali</option>
				<option value="bs_BA"<?php if ($fbc_options['language'] == 'bs_BA') echo ' selected="selected"'; ?>>Bosnian</option>
				<option value="bg_BG"<?php if ($fbc_options['language'] == 'bg_BG') echo ' selected="selected"'; ?>>Bulgarian</option>
				<option value="ca_ES"<?php if ($fbc_options['language'] == 'ca_ES') echo ' selected="selected"'; ?>>Catalan</option>
				<option value="ck_US"<?php if ($fbc_options['language'] == 'ck_US') echo ' selected="selected"'; ?>>Cherokee</option>
				<option value="hr_HR"<?php if ($fbc_options['language'] == 'hr_HR') echo ' selected="selected"'; ?>>Croatian</option>
				<option value="cs_CZ"<?php if ($fbc_options['language'] == 'cs_CZ') echo ' selected="selected"'; ?>>Czech</option>
				<option value="da_DK"<?php if ($fbc_options['language'] == 'da_DK') echo ' selected="selected"'; ?>>Danish</option>
				<option value="nl_BE"<?php if ($fbc_options['language'] == 'nl_BE') echo ' selected="selected"'; ?>>Dutch (Belgi&euml;)</option>
				<option value="nl_NL"<?php if ($fbc_options['language'] == 'nl_NL') echo ' selected="selected"'; ?>>Dutch</option>
				<option value="en_PI"<?php if ($fbc_options['language'] == 'en_PI') echo ' selected="selected"'; ?>>English (Pirate)</option>
				<option value="en_GB"<?php if ($fbc_options['language'] == 'en_GB') echo ' selected="selected"'; ?>>English (UK)</option>
				<option value="en_US"<?php if ($fbc_options['language'] == 'en_US') echo ' selected="selected"'; ?>>English (US)</option>
				<option value="en_UD"<?php if ($fbc_options['language'] == 'en_UD') echo ' selected="selected"'; ?>>English (Upside Down)</option>
				<option value="eo_EO"<?php if ($fbc_options['language'] == 'eo_EO') echo ' selected="selected"'; ?>>Esperanto</option>
				<option value="et_EE"<?php if ($fbc_options['language'] == 'et_EE') echo ' selected="selected"'; ?>>Estonian</option>
				<option value="fo_FO"<?php if ($fbc_options['language'] == 'fo_FO') echo ' selected="selected"'; ?>>Faroese</option>
				<option value="tl_PH"<?php if ($fbc_options['language'] == 'tl_PH') echo ' selected="selected"'; ?>>Filipino</option>
				<option value="fb_FI"<?php if ($fbc_options['language'] == 'fb_FI') echo ' selected="selected"'; ?>>Finnish (test)</option>
				<option value="fi_FI"<?php if ($fbc_options['language'] == 'fi_FI') echo ' selected="selected"'; ?>>Finnish</option>
				<option value="fr_CA"<?php if ($fbc_options['language'] == 'fr_CA') echo ' selected="selected"'; ?>>French (Canada)</option>
				<option value="fr_FR"<?php if ($fbc_options['language'] == 'fr_FR') echo ' selected="selected"'; ?>>French (France)</option>
				<option value="gl_ES"<?php if ($fbc_options['language'] == 'gl_ES') echo ' selected="selected"'; ?>>Galician</option>
				<option value="ka_GE"<?php if ($fbc_options['language'] == 'ka_GE') echo ' selected="selected"'; ?>>Georgian</option>
				<option value="de_DE"<?php if ($fbc_options['language'] == 'de_DE') echo ' selected="selected"'; ?>>German</option>
				<option value="el_GR"<?php if ($fbc_options['language'] == 'el_GR') echo ' selected="selected"'; ?>>Greek</option>
				<option value="gn_PY"<?php if ($fbc_options['language'] == 'gn_PY') echo ' selected="selected"'; ?>>Guaran&iacute;</option>
				<option value="gu_IN"<?php if ($fbc_options['language'] == 'gu_IN') echo ' selected="selected"'; ?>>Gujarati</option>
				<option value="he_IL"<?php if ($fbc_options['language'] == 'he_IL') echo ' selected="selected"'; ?>>Hebrew</option>
				<option value="hi_IN"<?php if ($fbc_options['language'] == 'hi_IN') echo ' selected="selected"'; ?>>Hindi</option>
				<option value="hu_HU"<?php if ($fbc_options['language'] == 'hu_HU') echo ' selected="selected"'; ?>>Hungarian</option>
				<option value="is_IS"<?php if ($fbc_options['language'] == 'is_IS') echo ' selected="selected"'; ?>>Icelandic</option>
				<option value="id_ID"<?php if ($fbc_options['language'] == 'id_ID') echo ' selected="selected"'; ?>>Indonesian</option>
				<option value="ga_IE"<?php if ($fbc_options['language'] == 'ga_IE') echo ' selected="selected"'; ?>>Irish</option>
				<option value="it_IT"<?php if ($fbc_options['language'] == 'it_IT') echo ' selected="selected"'; ?>>Italian</option>
				<option value="ja_JP"<?php if ($fbc_options['language'] == 'ja_JP') echo ' selected="selected"'; ?>>Japanese</option>
				<option value="jv_ID"<?php if ($fbc_options['language'] == 'jv_ID') echo ' selected="selected"'; ?>>Javanese</option>
				<option value="kn_IN"<?php if ($fbc_options['language'] == 'kn_IN') echo ' selected="selected"'; ?>>Kannada</option>
				<option value="kk_KZ"<?php if ($fbc_options['language'] == 'kk_KZ') echo ' selected="selected"'; ?>>Kazakh</option>
				<option value="km_KH"<?php if ($fbc_options['language'] == 'km_KH') echo ' selected="selected"'; ?>>Khmer</option>
				<option value="tl_ST"<?php if ($fbc_options['language'] == 'tl_ST') echo ' selected="selected"'; ?>>Klingon</option>
				<option value="ko_KR"<?php if ($fbc_options['language'] == 'ko_KR') echo ' selected="selected"'; ?>>Korean</option>
				<option value="ku_TR"<?php if ($fbc_options['language'] == 'ku_TR') echo ' selected="selected"'; ?>>Kurdish</option>
				<option value="la_VA"<?php if ($fbc_options['language'] == 'la_VA') echo ' selected="selected"'; ?>>Latin</option>
				<option value="lv_LV"<?php if ($fbc_options['language'] == 'lv_LV') echo ' selected="selected"'; ?>>Latvian</option>
				<option value="fb_LT"<?php if ($fbc_options['language'] == 'fb_LT') echo ' selected="selected"'; ?>>Leet Speak</option>
				<option value="li_NL"<?php if ($fbc_options['language'] == 'li_NL') echo ' selected="selected"'; ?>>Limburgish</option>
				<option value="lt_LT"<?php if ($fbc_options['language'] == 'lt_LT') echo ' selected="selected"'; ?>>Lithuanian</option>
				<option value="mk_MK"<?php if ($fbc_options['language'] == 'mk_MK') echo ' selected="selected"'; ?>>Macedonian</option>
				<option value="mg_MG"<?php if ($fbc_options['language'] == 'mg_MG') echo ' selected="selected"'; ?>>Malagasy</option>
				<option value="ms_MY"<?php if ($fbc_options['language'] == 'ms_MY') echo ' selected="selected"'; ?>>Malay</option>
				<option value="ml_IN"<?php if ($fbc_options['language'] == 'ml_IN') echo ' selected="selected"'; ?>>Malayalam</option>
				<option value="mt_MT"<?php if ($fbc_options['language'] == 'mt_MT') echo ' selected="selected"'; ?>>Maltese</option>
				<option value="mr_IN"<?php if ($fbc_options['language'] == 'mr_IN') echo ' selected="selected"'; ?>>Marathi</option>
				<option value="mn_MN"<?php if ($fbc_options['language'] == 'mn_MN') echo ' selected="selected"'; ?>>Mongolian</option>
				<option value="ne_NP"<?php if ($fbc_options['language'] == 'ne_NP') echo ' selected="selected"'; ?>>Nepali</option>
				<option value="se_NO"<?php if ($fbc_options['language'] == 'se_NO') echo ' selected="selected"'; ?>>Northern S&aacute;mi</option>
				<option value="nb_NO"<?php if ($fbc_options['language'] == 'nb_NO') echo ' selected="selected"'; ?>>Norwegian (bokmal)</option>
				<option value="nn_NO"<?php if ($fbc_options['language'] == 'nn_NO') echo ' selected="selected"'; ?>>Norwegian (nynorsk)</option>
				<option value="ps_AF"<?php if ($fbc_options['language'] == 'ps_AF') echo ' selected="selected"'; ?>>Pashto</option>
				<option value="fa_IR"<?php if ($fbc_options['language'] == 'fa_IR') echo ' selected="selected"'; ?>>Persian</option>
				<option value="pl_PL"<?php if ($fbc_options['language'] == 'pl_PL') echo ' selected="selected"'; ?>>Polish</option>
				<option value="pt_BR"<?php if ($fbc_options['language'] == 'pt_BR') echo ' selected="selected"'; ?>>Portuguese (Brazil)</option>
				<option value="pt_PT"<?php if ($fbc_options['language'] == 'pt_PT') echo ' selected="selected"'; ?>>Portuguese (Portugal)</option>
				<option value="pa_IN"<?php if ($fbc_options['language'] == 'pa_IN') echo ' selected="selected"'; ?>>Punjabi</option>
				<option value="qu_PE"<?php if ($fbc_options['language'] == 'qu_PE') echo ' selected="selected"'; ?>>Quechua</option>
				<option value="ro_RO"<?php if ($fbc_options['language'] == 'ro_RO') echo ' selected="selected"'; ?>>Romanian</option>
				<option value="rm_CH"<?php if ($fbc_options['language'] == 'rm_CH') echo ' selected="selected"'; ?>>Romansh</option>
				<option value="ru_RU"<?php if ($fbc_options['language'] == 'ru_RU') echo ' selected="selected"'; ?>>Russian</option>
				<option value="sa_IN"<?php if ($fbc_options['language'] == 'sa_IN') echo ' selected="selected"'; ?>>Sanskrit</option>
				<option value="sr_RS"<?php if ($fbc_options['language'] == 'sr_RS') echo ' selected="selected"'; ?>>Serbian</option>
				<option value="zh_CN"<?php if ($fbc_options['language'] == 'zh_CN') echo ' selected="selected"'; ?>>Simplified Chinese (China)</option>
				<option value="sk_SK"<?php if ($fbc_options['language'] == 'sk_SK') echo ' selected="selected"'; ?>>Slovak</option>
				<option value="sl_SI"<?php if ($fbc_options['language'] == 'sl_SI') echo ' selected="selected"'; ?>>Slovenian</option>
				<option value="so_SO"<?php if ($fbc_options['language'] == 'so_SO') echo ' selected="selected"'; ?>>Somali</option>
				<option value="es_CL"<?php if ($fbc_options['language'] == 'es_CL') echo ' selected="selected"'; ?>>Spanish (Chile)</option>
				<option value="es_CO"<?php if ($fbc_options['language'] == 'es_CO') echo ' selected="selected"'; ?>>Spanish (Colombia)</option>
				<option value="es_MX"<?php if ($fbc_options['language'] == 'es_MX') echo ' selected="selected"'; ?>>Spanish (Mexico)</option>
				<option value="es_ES"<?php if ($fbc_options['language'] == 'es_ES') echo ' selected="selected"'; ?>>Spanish (Spain)</option>
				<option value="es_VE"<?php if ($fbc_options['language'] == 'es_VE') echo ' selected="selected"'; ?>>Spanish (Venezuela)</option>
				<option value="es_LA"<?php if ($fbc_options['language'] == 'es_LA') echo ' selected="selected"'; ?>>Spanish</option>
				<option value="sw_KE"<?php if ($fbc_options['language'] == 'sw_KE') echo ' selected="selected"'; ?>>Swahili</option>
				<option value="sv_SE"<?php if ($fbc_options['language'] == 'sv_SE') echo ' selected="selected"'; ?>>Swedish</option>
				<option value="sy_SY"<?php if ($fbc_options['language'] == 'sy_SY') echo ' selected="selected"'; ?>>Syriac</option>
				<option value="tg_TJ"<?php if ($fbc_options['language'] == 'tg_TJ') echo ' selected="selected"'; ?>>Tajik</option>
				<option value="ta_IN"<?php if ($fbc_options['language'] == 'ta_IN') echo ' selected="selected"'; ?>>Tamil</option>
				<option value="tt_RU"<?php if ($fbc_options['language'] == 'tt_RU') echo ' selected="selected"'; ?>>Tatar</option>
				<option value="te_IN"<?php if ($fbc_options['language'] == 'te_IN') echo ' selected="selected"'; ?>>Telugu</option>
				<option value="th_TH"<?php if ($fbc_options['language'] == 'th_TH') echo ' selected="selected"'; ?>>Thai</option>
				<option value="zh_HK"<?php if ($fbc_options['language'] == 'zh_HK') echo ' selected="selected"'; ?>>Traditional Chinese (Hong Kong)</option>
				<option value="zh_TW"<?php if ($fbc_options['language'] == 'zh_TW') echo ' selected="selected"'; ?>>Traditional Chinese (Taiwan)</option>
				<option value="tr_TR"<?php if ($fbc_options['language'] == 'tr_TR') echo ' selected="selected"'; ?>>Turkish</option>
				<option value="uk_UA"<?php if ($fbc_options['language'] == 'uk_UA') echo ' selected="selected"'; ?>>Ukrainian</option>
				<option value="ur_PK"<?php if ($fbc_options['language'] == 'ur_PK') echo ' selected="selected"'; ?>>Urdu</option>
				<option value="uz_UZ"<?php if ($fbc_options['language'] == 'uz_UZ') echo ' selected="selected"'; ?>>Uzbek</option>
				<option value="vi_VN"<?php if ($fbc_options['language'] == 'vi_VN') echo ' selected="selected"'; ?>>Vietnamese</option>
				<option value="cy_GB"<?php if ($fbc_options['language'] == 'cy_GB') echo ' selected="selected"'; ?>>Welsh</option>
				<option value="xh_ZA"<?php if ($fbc_options['language'] == 'xh_ZA') echo ' selected="selected"'; ?>>Xhosa</option>
				<option value="yi_DE"<?php if ($fbc_options['language'] == 'yi_DE') echo ' selected="selected"'; ?>>Yiddish</option>
				<option value="zu_ZA"<?php if ($fbc_options['language'] == 'zu_ZA') echo ' selected="selected"'; ?>>Zulu</option>
			</select>
			</p>
		</div>
	</div>

	<div id="poststuff" class="postbox">
		<h3><?php _e('Advanced Settings'); ?></h3>

		<div class="inside">
			<p><?php _e('Comments XID: '); ?>
				<input type="text" name="fbComments[xid]" value="<?php echo $fbc_options['xid']; ?>" size="20">
				<em><?php _e(" (Only change this if you know what you're doing. Must be a unique string. <a target='_blank' href='" . FBCOMMENTS_WEBPAGE . "#xid'>Learn more</a>)"); ?></em></p>

			<p><input type="checkbox" id="fbComments_includeFbJs" name="fbComments[includeFbJs]" value="1" <?php checked(1, $fbc_options['includeFbJs']); ?> size="20">
				<label for="fbComments_includeFbJs"><?php _e(' Include Facebook JavaScript SDK'); ?></label>
				<em><?php _e(" (This should be checked unless you've manually included the SDK elsewhere)"); ?></em></p>

			<p class="indent"><input type="checkbox" id="fbComments_includeFbJsOldWay" name="fbComments[includeFbJsOldWay]" value="1" <?php checked($fbc_options['includeFbJsOldWay'], 1 ); ?> size="20">
				<label for="fbComments_includeFbJsOldWay"><?php _e(' The old way'); ?></label>
				<em><?php _e(" (If the comments no longer load since updating the plugin, check this box to include the JavaScript SDK the old way. Combined comment counts and email notifications will not work with this option enabled)"); ?></em></p>

			<p><input type="checkbox" id="fbComments_includeFbmlLangAttr" name="fbComments[includeFbmlLangAttr]" value="1" <?php checked($fbc_options['includeFbmlLangAttr'], 1 ); ?> size="20">
				<label for="fbComments_includeFbmlLangAttr"><?php _e(' Include Facebook FBML reference'); ?></label>
				<em><?php _e(" (This should be checked unless you have another plugin enabled that includes the FBML reference)"); ?></em></p>

			<p><input type="checkbox" id="fbComments_includeOpenGraphLangAttr" name="fbComments[includeOpenGraphLangAttr]" value="1" <?php checked($fbc_options['includeOpenGraphLangAttr'], 1 ); ?> size="20">
				<label for="fbComments_includeOpenGraphLangAttr"><?php _e(' Include OpenGraph reference'); ?></label>
				<em><?php _e(" (This should be checked unless you have another plugin enabled that includes the OpenGraph reference)"); ?></em></p>

			<p><input type="checkbox" id="fbComments_includeOpenGraphMeta" name="fbComments[includeOpenGraphMeta]" value="1" <?php checked($fbc_options['includeOpenGraphMeta'], 1 ); ?> size="20">
				<label for="fbComments_includeOpenGraphMeta"><?php _e(' Include OpenGraph meta information'); ?></label>
				<em><?php _e(" (This will add the following meta information to the page &lt;head&gt; to assist with Like button clicks: post/page title, site name, current URL and content type)"); ?></em></p>
		</div>
	</div>

	<input type="hidden" name="fbComments[update]" value="1" />

	<input type="submit" class="button-primary" value="<?php _e('Update Options'); ?>" />

  </form> <!-- End Settings -->

	<div id="poststuff" class="postbox gutter">
		<h3><?php _e('Donate'); ?></h3>

		<div class="inside contain-floats">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal">
				<input type="hidden" name="cmd" value="_donations" />
				<input type="hidden" name="business" value="fbc@we8u.com" />
				<input type="hidden" name="item_name" value="Donation to Facebook Comments for WordPress plugin" />
				<input type="hidden" name="item_number" value="0" />
				<input type="hidden" name="notify_url" value="" />
				<input type="hidden" name="no_shipping" value="1" />
				<input type="hidden" name="return" value="<?php echo (!empty($_SERVER['HTTPS'])) ? 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] : 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" />
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="tax" value="0" />
				<input type="hidden" name="bn" value="PP-DonationsBF" />
				<input type="hidden" name="on0" value="Website" />

				<p>Currency:
				<select id="currency_code" name="currency_code">
					<option value="USD">U.S. Dollars</option>
					<option value="AUD">Australian Dollars</option>
					<option value="CAD">Canadian Dollars</option>
					<option value="EUR">Euros</option>
					<option value="GBP">Pounds Sterling</option>
					<option value="JPY">Yen</option>
				</select></p>

				<p>Amount:
				<input type="text" name="amount" size="16" title="The amount you wish to donate" value="" /></p>

				<p><input class="ppimg donateButton" type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" style="border:0;" alt="Make a donation" />
				<span class="donateText"></span></p>
			</form>
		</div>
	</div>

    <br />
</div> <!-- End wrap -->
