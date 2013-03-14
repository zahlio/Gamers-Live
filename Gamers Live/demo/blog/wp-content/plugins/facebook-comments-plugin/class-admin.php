<?php
define("PLUGIN_NAME","Facebook Comments");
define("PLUGIN_TAGLINE","Adds Facebook Comments to your posts and pages!");
define("PLUGIN_URL","http://3doordigital.com/wordpress/plugins/facebook-comments/");
define("EXTEND_URL","http://wordpress.org/extend/plugins/facebook-comments-plugin/");
define("AUTHOR_TWITTER","alexmoss");
define("DONATE_LINK","https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WFVJMCGGZTDY4");

add_action('admin_init', 'fbcomments_init' );
function fbcomments_init(){
	register_setting( 'fbcomments_options', 'fbcomments' );
	$new_options = array(
		'fbml' => 'on',
		'opengraph' => 'off',
		'fbns' => 'off',
		'html5' => 'on',
		'posts' => 'on',
		'pages' => 'off',
		'homepage' => 'off',
		'appID' => '',
		'mods' => '',
		'num' => '5',
		'count' => 'on',
		'countmsg' => 'comments',
		'title' => 'Comments',
		'titleclass' => '',
		'width' => '450',
		'countstyle' => '',
		'linklove' => 'off',
		'scheme' => 'light',
		'language' => 'en_US'
	);

	// if old options exist, update to array
	foreach( $new_options as $key => $value ) {
		if( $existing = get_option( 'fbcomments_' . $key ) ) {
			$new_options[$key] = $existing;
			delete_option( 'fbcomments_' . $key );
		}

	}


	add_option( 'fbcomments', $new_options );
}


add_action('admin_menu', 'show_fbcomments_options');
function show_fbcomments_options() {
	add_options_page('Facebook Comments Options', 'Facebook Comments', 'manage_options', 'fbcomments', 'fbcomments_options');
}


function fbcomments_fetch_rss_feed() {
    include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed("http://3doordigital.com/feed");	
	if ( is_wp_error($rss) ) { return false; }	
	$rss_items = $rss->get_items(0, 3);
    return $rss_items;
}   

function fbcomments_admin_notice(){
$options = get_option('fbcomments');
if ($options['appID']=="") {
	$fbadminurl = get_admin_url()."options-general.php?page=fbcomments";
    echo '<div class="error">
       <p>Please enter your Facebook App ID for Facebook Comments to work properly. <a href="'.$fbadminurl.'"><input type="submit" value="Enter App ID" class="button-secondary" /></a></p>
    </div>';
}
}
add_action('admin_notices', 'fbcomments_admin_notice');

// ADMIN PAGE
function fbcomments_options() {
$domain = get_option('siteurl');
$domain = str_replace('http://', '', $domain);
$domain = str_replace('www.', '', $domain);
?>
    <link href="<?php echo plugins_url( 'admin.css' , __FILE__ ); ?>" rel="stylesheet" type="text/css">
    <div class="pea_admin_wrap">
        <div class="pea_admin_top">
            <h1><?php echo PLUGIN_NAME?> <small> - <?php echo PLUGIN_TAGLINE?></small></h1>
        </div>

        <div class="pea_admin_main_wrap">
            <div class="pea_admin_main_left">
                <div class="pea_admin_signup">
                    Want to know about updates to this plugin without having to log into your site every time? Want to know about other cool plugins we've made? Add your email and we'll add you to our very rare mail outs.

                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup">
                    <form action="http://peadig.us5.list-manage2.com/subscribe/post?u=e16b7a214b2d8a69e134e5b70&amp;id=eb50326bdf" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div class="mc-field-group">
                        <label for="mce-EMAIL">Email Address
                    </label>
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL"><button type="submit" name="subscribe" id="mc-embedded-subscribe" class="pea_admin_green">Sign Up!</button>
                    </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>	<div class="clear"></div>
                    </form>
                    </div>

                    <!--End mc_embed_signup-->
                </div>

		<form method="post" action="options.php" id="options">
			<?php settings_fields('fbcomments_options'); ?>
			<?php $options = get_option('fbcomments'); 
if (!isset($options['fbml'])) {$options['fbml'] = "";}
if (!isset($options['fbns'])) {$options['fbns'] = "";}
if (!isset($options['opengraph'])) {$options['opengraph'] = "";}
if (!isset($options['html5'])) {$options['html5'] = "";}
if (!isset($options['linklove'])) {$options['linklove'] = "";}
if (!isset($options['posts'])) {$options['posts'] = "";}
if (!isset($options['pages'])) {$options['pages'] = "";}
if (!isset($options['homepage'])) {$options['homepage'] = "";}
if (!isset($options['count'])) {$options['count'] = "";}
if (!isset($options['jquery'])) {$options['jquery'] = "";}
?>

<?php if ($options['appID']=="") { ?>
<div class="error">
			<h3 class="title">You Need to Set Up your Facebook App ID!</h3>
			<table class="form-table">
				<tr valign="top"><th scope="row"><a href="https://developers.facebook.com/apps" style="text-decoration:none" target="_blank">Create an App to handle your comments</a></th>
					<td><small>click <strong>+ Create New App</strong> to the top right of the page. Name the App something memorable e.g. "Comments" and give it an app namespace. Once you have it enter it here:</small><br><strong>APP ID: </strong><input id="appID" type="text" name="fbcomments[appID]" value="<?php echo $options['appID']; ?>" /><br><br>
</td>
				</tr>
			</table>
</div>
<?php } else { ?>
			<h3 class="title">Facebook Setup</h3>
			<table class="form-table">
				<tr valign="top"><th scope="row"><a href="https://developers.facebook.com/apps<?php if ($options['appID'] != "") { echo "/".$options['appID']."/summary"; } ?>" style="text-decoration:none" target="_blank">App Setup</a></th>
					<td><small>to set up, choose your App and click <strong>Edit Settings</strong>. Ensure you enter <strong><?php echo $domain; ?></strong> in both "App Domains" and as the "Website with Facebook Login" URL</small></td>
				</tr>
				<tr valign="top"><th scope="row"><a href="https://developers.facebook.com/apps" style="text-decoration:none" target="_blank">Create a New App</a></th>
					<td><small>you have already entered your App ID, but if you want to set up a new one click <strong>+ Create New App</strong> to the top right of the page. Name the App something memorable e.g. "Comments" and give it an app namespace.</small></td>
				</tr>
			</table>
<?php } ?>

			<h3 class="title">Moderation</h3>
			<table class="form-table">
				<tr valign="top"><th scope="row"><a href="https://developers.facebook.com/tools/comments<?php if ($options['appID'] != "") { echo "?id=".$options['appID']."&view=queue"; } ?>" style="text-decoration:none" target="_blank">Comment Moderation Area</a></th>
					<td><small>when you're a moderator you will see notifications within facebook.com. If you don't want to have moderator status or want to see all comments in one area, use the link to the left.</small></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="appID">Moderators</label></th>
					<td><input id="mods" type="text" name="fbcomments[mods]" value="<?php echo $options['mods']; ?>" size="50" /><br><small>By default, all admins to the App ID can moderate comments. To add moderators, enter each Facebook Profile ID by a comma <strong>without spaces</strong>. To find your Facebook User ID, click <a href="https://developers.facebook.com/tools/explorer/?method=GET&path=me" target="blank">here</a> where you will see your own. To view someone else's, replace "me" with their username in the input provided</small></td>
				</tr>
			</table>


			<h3 class="title">Main Settings</h3>
			<table class="form-table">
<?php if ($options['appID']!="") { ?>
				<tr valign="top"><th scope="row"><label for="appID">Facebook App ID</label></th>
					<td><input id="appID" type="text" name="fbcomments[appID]" value="<?php echo $options['appID']; ?>" /></td>
				</tr>
<?php } ?>
				<tr valign="top"><th scope="row"><label for="fbml">Enable FBML</label></th>
					<td><input id="fbml" name="fbcomments[fbml]" type="checkbox" value="on" <?php checked('on', $options['fbml']); ?> /> <small>only disable this if you already have XFBML enabled elsewhere</small></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="fbns">Use Facebook NameServer</label></th>
					<td><input id="fbns" name="fbcomments[fbns]" type="checkbox" value="on" <?php checked('on', $options['fbml']); ?> /> <small>only enable this if Facebook Comments do not appear</small></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="opengraph">Use Open Graph NameServer</label></th>
					<td><input id="opengraph" name="fbcomments[opengraph]" type="checkbox" value="on" <?php checked('on', $options['opengraph']); ?> /> <small>only enable this if Facebook comments are not appearing, not all information is being passed to Facebook or if you have not enabled Open Graph elsewhere within WordPress</small></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="html5">Use HTML5</label></th>
					<td><input id="html5" name="fbcomments[html5]" type="checkbox" value="on" <?php checked('on', $options['html5']); ?> /></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="linklove">Credit</label></th>
					<td><input id="credit" name="fbcomments[linklove]" type="checkbox" value="on" <?php checked('on', $options['linklove']); ?> /></td>
				</tr>
			</table>

			<h3 class="title">Display Settings</h3>
			<table class="form-table">
				<tr valign="top"><th scope="row"><label for="posts">Posts</label></th>
					<td><input id="posts" name="fbcomments[posts]" type="checkbox" value="on" <?php checked('on', $options['posts']); ?> /></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="pages">Pages</label></th>
					<td><input id="pages" name="fbcomments[pages]" type="checkbox" value="on" <?php checked('on', $options['pages']); ?> /></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="homepage">Homepage</label></th>
					<td><input id="home" name="fbcomments[homepage]" type="checkbox" value="on" <?php checked('on', $options['homepage']); ?> /></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="language">Language</label></th>
					<td><?php
 $dom_object = new DOMDocument();
 $dom_object->load("http://www.facebook.com/translations/FacebookLocales.xml");
$langfeed = $dom_object->getElementsByTagName("locale");

                echo '<select name="fbcomments[language]">';
                foreach ( $langfeed as $value) {
$names = $value->getElementsByTagName("englishName");
$name  = $names->item(0)->nodeValue;
$representations = $value->getElementsByTagName("representation");
$representation  = $representations->item(0)->nodeValue;
					echo '<option value="'.$representation.'"';
					if ($options['language'] == $representation) {echo " selected";}
					echo '>'.$name.'</option>';
			    }
                echo '</select>'; 
                    ?></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="scheme">Colour Scheme</label></th>
					<td>
						<select name="fbcomments[scheme]">
							  <option value="light"<?php if ($options['scheme'] == 'light') { echo ' selected="selected"'; } ?>>Light</option>
							  <option value="dark"<?php if ($options['scheme'] == 'dark') { echo ' selected="selected"'; } ?>>Dark</option>
						</select>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><label for="num">Number of Comments</label></th>
					<td><input id="num" type="text" name="fbcomments[num]" value="<?php echo $options['num']; ?>" /> <small>default is <strong>5</strong></small></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="width">Width</label></th>
					<td><input id="width" type="text" name="fbcomments[width]" value="<?php echo $options['width']; ?>" /> <small>default is <strong>580</strong></small></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="title">Title</label></th>
					<td><input id="title" type="text" name="fbcomments[title]" value="<?php echo $options['title']; ?>" /> with a CSS class of <input type="text" name="fbcomments[titleclass]" value="<?php echo $options['titleclass']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="count">Show Comment Count</label></th>
					<td><input id="count" name="fbcomments[count]" type="checkbox" value="on" <?php checked('on', $options['count']); ?> /></td>
				</tr>
				<tr valign="top"><th scope="row"><label for="countmsg">Comment text</label></th>
					<td><input id="countmsg" type="text" name="fbcomments[countmsg]" value="<?php echo $options['countmsg']; ?>" /> with a CSS class of <input type="text" name="fbcomments[countstyle]" value="<?php echo $options['countstyle']; ?>" /></td>
				</tr>
			</table>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>

               <div class="pea_admin_box">
			<h3 class="title">Using the Shortcode</h3>
			<table class="form-table">
				<tr valign="top"><td>
<p>The settings above are for automatic insertion of the Facebook Comment box.</p>
<p>You can insert the comment box manually in any page or post or template by simply using the shortcode <strong>[fbcomments]</strong>. To enter the shortcode directly into templates using PHP, enter <strong>echo do_shortcode('[fbcomments]');</strong></p>
<p>You can also use the options below to override the the settings above.</p>
<ul>
<li><strong>url</strong> - leave blank for current URL</li>
<li><strong>width</strong> -  minimum must be <strong>350</strong></li>
<li><strong>title</strong> with a CSS class of <strong>titleclass</strong></li>
<li><strong>num</strong> - number of comments</li>
<li><strong>count</strong> - comment count on/off</li>
<li><strong>countmsg</strong> with a CSS class of <strong>countstyle</strong></li>
<li><strong>scheme</strong> - colour scheme: light/dark</li>
<li><strong>linklove</strong> - enter "1" to link to the plugin</li>
</ul>
<p>Here's an example of using the shortcode:<br><code>[fbcomments url="http://3doordigital.com/wordpress/plugins/facebook-comments/" width="375" count="off" num="3" countmsg="wonderful comments!"]</code></p>
<p>You can also insert the shortcode directly into your theme with PHP:<br><code>&lt;?php echo do_shortcode('[fbcomments][fbcomments url="http://3doordigital.com/wordpress/plugins/facebook-comments/" width="375" count="off" num="3" countmsg="wonderful comments!"]'); ?&gt;</code>

					</td>
				</tr>
			</table>
</div>

</div>
            <div class="pea_admin_main_right">
                <div class="pea_admin_logo">

            <a href="http://3doordigital.com/?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=Facebook%2BComments%2BAdmin" target="_blank"><img src="<?php echo plugins_url( '3dd-logo.png' , __FILE__ ); ?>" width="250" height="92" title="3 Door Digital"></a>

                </div>


                <div class="pea_admin_box">
                    <h2>Like this Plugin?</h2>
<a href="<?php echo EXTEND_URL; ?>" target="_blank"><button type="submit" class="pea_admin_green">Rate this plugin	&#9733;	&#9733;	&#9733;	&#9733;	&#9733;</button></a><br><br>
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=181590835206577";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-like" data-href="<?php echo PLUGIN_URL; ?>" data-send="true" data-layout="button_count" data-width="250" data-show-faces="true"></div>
                    <br>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo PLUGIN_URL; ?>" data-text="Just been using <?php echo PLUGIN_NAME; ?> #WordPress plugin" data-via="<?php echo AUTHOR_TWITTER; ?>" data-related="WPBrewers">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    <br>
<a href="http://bufferapp.com/add" class="buffer-add-button" data-text="Just been using <?php echo PLUGIN_NAME; ?> #WordPress plugin" data-url="<?php echo PLUGIN_URL; ?>" data-count="horizontal" data-via="<?php echo AUTHOR_TWITTER; ?>">Buffer</a><script type="text/javascript" src="http://static.bufferapp.com/js/button.js"></script>
<br>
                    <div class="g-plusone" data-size="medium" data-href="<?php echo PLUGIN_URL; ?>"></div>
                    <script type="text/javascript">
                      window.___gcfg = {lang: 'en-GB'};

                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                    <br>
                    <su:badge layout="3" location="<?php echo PLUGIN_URL?>"></su:badge>
                    <script type="text/javascript">
                      (function() {
                        var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
                        li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
                      })();
                    </script>
                </div>

<center><a href="<?php echo DONATE_LINK; ?>" target="_blank"><img class="paypal" src="<?php echo plugins_url( 'paypal.gif' , __FILE__ ); ?>" width="147" height="47" title="Please Donate - it helps support this plugin!"></a></center>

                <div class="pea_admin_box">
                    <h2>About the Author</h2>

                    <?php
                    $default = "http://reviews.evanscycles.com/static/0924-en_gb/noAvatar.gif";
                    $size = 70;
                    $alex_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( "alex@peadig.com" ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
                    ?>

                    <p class="pea_admin_clear"><img class="pea_admin_fl" src="<?php echo $alex_url; ?>" alt="Alex Moss" /> <h3>Alex Moss</h3><br><a href="https://twitter.com/alexmoss" class="twitter-follow-button" data-show-count="false">Follow @alexmoss</a>
<div class="fb-subscribe" data-href="https://www.facebook.com/alexmoss1" data-layout="button_count" data-show-faces="false" data-width="220"></div>
</p>
                    <p class="pea_admin_clear">Alex Moss is the Co-Founder and Technical Director of 3 Door Digital. With offices based in Manchester, UK and Tel Aviv, Israel he manages WordPress development as well as technical aspects of digital consultancy. He has developed several WordPress plugins (which you can <a href="http://3doordigital.com/wordpress/plugins/?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=Facebook%2BComments%2BAdmin" target="_blank">view here</a>) totalling over 200,000 downloads.</p>
</div>

                <div class="pea_admin_box">
                    <h2>More from 3 Door Digital</h2>
    <p class="pea_admin_clear">
                    <?php
$fbcommentsfeed = fbcomments_fetch_rss_feed();
                echo '<ul>';
                foreach ( $fbcommentsfeed as $item ) {
			    	$url = preg_replace( '/#.*/', '', esc_url( $item->get_permalink(), $protocolls=null, 'display' ) );
					echo '<li>';
					echo '<a href="'.$url.'?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=Facebook%2BComments%2BRSS">'. esc_html( $item->get_title() ) .'</a> ';
					echo '</li>';
			    }
                echo '</ul>'; 
                    ?></p>
                </div>


            </div>
        </div>
    </div>



<?php
}

?>