<?php

//ADD XFBML
add_filter('language_attributes', 'fbcomments_schema');
function fbcomments_schema($attr) {
	$options = get_option('fbcomments');
if (!isset($options['fbns'])) {$options['fbns'] = "";}
if (!isset($options['opengraph'])) {$options['opengraph'] = "";}
	if ($options['opengraph'] == 'on') {$attr .= "\n xmlns:og=\"http://ogp.me/ns#\"";}
	if ($options['fbns'] == 'on') {$attr .= "\n xmlns:fb=\"http://ogp.me/ns/fb#\"";}
	return $attr;
}

//ADD OPEN GRAPH META
function fbgraphinfo() {
	$options = get_option('fbcomments'); ?>
<meta property="fb:app_id" content="<?php echo $options['appID']; ?>"/>
<meta property="fb:admins" content="<?php echo $options['mods']; ?>"/>
<?php
}
add_action('wp_head', 'fbgraphinfo');


function fbmlsetup() {
$options = get_option('fbcomments');
if (!isset($options['fbml'])) {$options['fbml'] = "";}
if ($options['fbml'] == 'on') {
?>
<!-- Facebook Comments for WordPress: http://3doordigital.com/wordpress/plugins/facebook-comments/ -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $options['language']; ?>/all.js#xfbml=1&appId=<?php echo $options['appID']; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php }}
add_action('wp_footer', 'fbmlsetup', 100);



//COMMENT BOX
function fbcommentbox($content) {
	$options = get_option('fbcomments');
if (!isset($options['html5'])) {$options['html5'] = "off";}
if (!isset($options['linklove'])) {$options['linklove'] = "off";}
if (!isset($options['posts'])) {$options['posts'] = "off";}
if (!isset($options['pages'])) {$options['pages'] = "off";}
if (!isset($options['homepage'])) {$options['homepage'] = "off";}
if (!isset($options['count'])) {$options['count'] = "off";}
	if (
	   (is_single() && $options['posts'] == 'on') ||
       (is_page() && $options['pages'] == 'on') ||
       ((is_home() || is_front_page()) && $options['homepage'] == 'on')) {

		if ($options['count'] == 'on') {
			if ($options['countstyle'] == '') {
				$commentcount = "<p>";
			} else {
				$commentcount = "<p class=\"".$options['countstyle']."\">";
			}
			$commentcount .= "<fb:comments-count href=".get_permalink()."></fb:comments-count> ".$options['countmsg']."</p>";
		}
		if ($options['title'] != '') {
			if ($options['titleclass'] == '') {
				$commenttitle = "<h3>";
			} else {
				$commenttitle = "<h3 class=\"".$options['titleclass']."\">";
			}
			$commenttitle .= $options['title']."</h3>";
		}
		$content .= "<!-- Facebook Comments for WordPress: http://3doordigital.com/wordpress/plugins/facebook-comments/ -->".$commenttitle.$commentcount;

      	if ($options['html5'] == 'on') {
			$content .=	"<div class=\"fb-comments\" data-href=\"".get_permalink()."\" data-num-posts=\"".$options['num']."\" data-width=\"".$options['width']."\" data-colorscheme=\"".$options['scheme']."\"></div>";

    } else {
    $content .= "<fb:comments href=\"".get_permalink()."\" num_posts=\"".$options['num']."\" width=\"".$options['width']."\" colorscheme=\"".$options['scheme']."\"></fb:comments>";
     }

    if ($options['linklove'] != 'no') {
        if ($options['linklove'] != 'off') {
            if (empty($fbcomments[linklove])) {
      $content .= '<p>Powered by <a href="http://3doordigital.com/wordpress/plugins/facebook-comments/">Facebook Comments</a></p>';
    }}}
  }
return $content;
}
add_filter ('the_content', 'fbcommentbox', 100);


function fbcommentshortcode($fbatts) {
    extract(shortcode_atts(array(
		"fbcomments" => get_option('fbcomments'),
		"url" => get_permalink(),
    ), $fbatts));
    if (!empty($fbatts)) {
        foreach ($fbatts as $key => $option)
            $fbcomments[$key] = $option;
	}
		if ($fbcomments[count] == 'on') {
			if ($fbcomments[countstyle] == '') {
				$commentcount = "<p>";
			} else {
				$commentcount = "<p class=\"".$fbcomments[countstyle]."\">";
			}
			$commentcount .= "<fb:comments-count href=".$url."></fb:comments-count> ".$fbcomments[countmsg]."</p>";
		}
		if ($fbcomments[title] != '') {
			if ($fbcomments[titleclass] == '') {
				$commenttitle = "<h3>";
			} else {
				$commenttitle = "<h3 class=\"".$fbcomments[titleclass]."\">";
			}
			$commenttitle .= $fbcomments[title]."</h3>";
		}
		$fbcommentbox = "<!-- Facebook Comments for WordPress: http://3doordigital.com/wordpress/plugins/facebook-comments/ -->".$commenttitle.$commentcount;

      	if ($fbcomments[html5] == 'on') {
			$fbcommentbox .=	"<div class=\"fb-comments\" data-href=\"".$url."\" data-num-posts=\"".$fbcomments[num]."\" data-width=\"".$fbcomments[width]."\" data-colorscheme=\"".$fbcomments[scheme]."\"></div>";

    } else {
    $fbcommentbox .= "<fb:comments href=\"".$url."\" num_posts=\"".$fbcomments[num]."\" width=\"".$fbcomments[width]."\" colorscheme=\"".$fbcomments[scheme]."\"></fb:comments>";
     }

    if ($options['linklove'] != 'no') {
        if ($options['linklove'] != 'off') {
            if (empty($fbcomments[linklove])) {
      $fbcommentbox .= '<p>Powered by <a href="http://3doordigital.com/wordpress/plugins/facebook-comments/">Facebook Comments</a></p>';
    }}}
  return $fbcommentbox;
}
add_filter('widget_text', 'do_shortcode');
add_shortcode('fbcomments', 'fbcommentshortcode');


?>