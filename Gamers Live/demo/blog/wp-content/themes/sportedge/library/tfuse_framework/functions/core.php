<?php

function tfuse_get_prefix($prefix) {
	global $tfuse;

	/* If the global prefix isn't set, define it. Plugin/theme authors may also define a custom prefix. */
	if ( empty( $tfuse->prefix ) )
		$tfuse->prefix = $prefix;
	
	return $tfuse->prefix;
}

tfuse_get_prefix($prefix);

// Check if $meta option exist in DB
function tfuse_meta_exist($meta = '', $get_id = null) {
	global $wpdb, $post;

	if(isset($get_id)) $post_id = $get_id; else $post_id = $post->ID;

	return $wpdb->get_var($wpdb->prepare("SELECT COUNT(meta_key) FROM $wpdb->postmeta WHERE meta_key = '$meta' AND post_id = $post_id;"));
}


// Check if $option exist in DB
function tfuse_option_exist($option = '') {
	global $wpdb;
	
	return $wpdb->get_var($wpdb->prepare("SELECT COUNT(option_name) FROM $wpdb->options WHERE option_name = '$option';"));
}

function tfuse_change_link(&$item, $key, $base_url) {
	if (is_array($base_url)) {
		$upload_link_old = $base_url['old'];
		$upload_link_new = $base_url['new'];
	} else {
		$upload_link_old = $base_url;
		$upload_link_new = get_bloginfo('url');
	}
	
	if ( preg_match('/^\/[\w\W]+$/', $item) )
		$item = rtrim($upload_link_old,'/').$item;
		
	$item = str_replace($upload_link_old,$upload_link_new,$item);
}

function pk($data) {
	return urlencode(serialize($data));
}

function unpk($data) {
	return unserialize(urldecode($data));
}


function tfuse_get_post_type() {
	//get post type (page,post, custom post type ...)
	if (!isset($_REQUEST['post_ID'])) $_REQUEST['post_ID']=0;
	if (!isset($_REQUEST['post'])) $_REQUEST['post']=0;

	(empty($_REQUEST['post'])) ? $post_id = $_REQUEST['post_ID'] : $post_id = $_REQUEST['post'];
	$post_type = get_post_type($post_id);
	if( empty($post_type) && basename($_SERVER['PHP_SELF']) == "post-new.php" && isset($_REQUEST['post_type'])) $post_type = $_REQUEST['post_type'];
	if( empty($post_type) && basename($_SERVER['PHP_SELF']) == "post-new.php" ) $post_type = 'post';
	return $post_type;
}

function tfuse_custom_options($post_type) {
	global $tfuse;
	//get specific options
	$options = get_option("{$tfuse->prefix}_".$post_type."_options");
	if(!is_array($options)) $options = array();
	return $options;
}



// Load Theme stylesheet
function tfuse_wp_head() {
	global $tfuse; 
	$prefix = $tfuse->prefix;

    //Styles
     //if(!isset($_REQUEST['color'])) $_REQUEST['color'] = '';
     @$style = $_REQUEST['color'];
     if( !isset($style) && @$_COOKIE["{$prefix}_style_demo"] != '' ) $style = $_COOKIE["{$prefix}_style_demo"];
     
     $style_ext = end(explode('.', $style));
     if($style != '' and $style_ext != 'css') $style = $style . '.css';
     
     if ($style != '') {
          echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $style . '" rel="stylesheet" type="text/css" />'."\n"; 
     } else { 
          $stylesheet = get_option("{$prefix}_alt_stylesheet");
          if($stylesheet != '')
               echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $stylesheet .'" rel="stylesheet" type="text/css" />'."\n";         
          else
               echo '<link href="'. get_bloginfo('template_directory') .'/styles/default.css" rel="stylesheet" type="text/css" />'."\n";         		  
     } 
     
      // Custom.css insert
      echo '<link href="'. get_bloginfo('template_directory') .'/custom.css" rel="stylesheet" type="text/css" />'."\n";   
      
     // Favicon
    if(get_option("{$prefix}_custom_favicon") != '') echo '<link rel="shortcut icon" href="'.  get_option("{$prefix}_custom_favicon")  .'"/>'."\n";

     // Custom CSS block in Backend
    $custom_css = get_option("{$prefix}_custom_css");
    if($custom_css != '') {
		$output = '<style type="text/css">'."\n";
		$output .= $custom_css . "\n";
		$output .= '</style>'."\n";
		echo $output;
	}
	
}
add_action('wp_head', 'tfuse_wp_head');

if(!is_admin()) {
	function add_sendmail_script() {   
		wp_register_script('sendmail', ADMIN_JS.'/sendmail.js', array('jquery'),'1.1' );
		wp_enqueue_script('sendmail');          
	}    
	add_action('init', 'add_sendmail_script');
}



function smartCopy($source, $dest, $folderPermission=0755,$filePermission=0644){ 
# source=file & dest=dir => copy file from source-dir to dest-dir 
# source=file & dest=file / not there yet => copy file from source-dir to dest and overwrite a file there, if present 

# source=dir & dest=dir => copy all content from source to dir 
# source=dir & dest not there yet => copy all content from source to a, yet to be created, dest-dir 
    $result=false; 
    
    if (is_file($source)) { # $source is file 
        if(is_dir($dest)) { # $dest is folder 
            if ($dest[strlen($dest)-1]!='/') # add '/' if necessary 
                $__dest=$dest."/"; 
            $__dest .= basename($source); 
            } 
        else { # $dest is (new) filename 
            $__dest=$dest; 
            } 
        $result=copy($source, $__dest); 
        chmod($__dest,$filePermission); 
        } 
    elseif(is_dir($source)) { # $source is dir 
        if(!is_dir($dest)) { # dest-dir not there yet, create it 
            @mkdir($dest,$folderPermission); 
            chmod($dest,$folderPermission); 
            } 
        if ($source[strlen($source)-1]!='/') # add '/' if necessary 
            $source=$source."/"; 
        if ($dest[strlen($dest)-1]!='/') # add '/' if necessary 
            $dest=$dest."/"; 

        # find all elements in $source 
        $result = true; # in case this dir is empty it would otherwise return false 
        $dirHandle=opendir($source); 
        while($file=readdir($dirHandle)) { # note that $file can also be a folder 
            if($file!="." && $file!="..") { # filter starting elements and pass the rest to this function again 
#                echo "$source$file ||| $dest$file<br />\n"; 
                $result=smartCopy($source.$file, $dest.$file, $folderPermission, $filePermission); 
                } 
            } 
        closedir($dirHandle); 
        } 
    else { 
        $result=false; 
        } 
    return $result; 
}


//SEO title
function tfuse_seo() {
	global $post;

	$theme_name 		= get_bloginfo('name');
	$theme_description 	= get_bloginfo('description');
	$title				= $theme_name.' | '.$theme_description;
	$description 		= $theme_description;
	$keywords			= '';
	
	$homepage_title 	= get_option(PREFIX.'_homepage_title');
	$homepage_keywords 	= get_option(PREFIX.'_homepage_keywords');
	$homepage_desc	 	= get_option(PREFIX.'_homepage_description');

	$general_keywords 	= get_option(PREFIX.'_general_keywords');
	$general_desc	 	= get_option(PREFIX.'_general_description');

	//General
	if ($general_keywords != '') { $keywords = $general_keywords; }
	if ($general_desc != '') { $description = $general_desc; }

	if ( is_home() || is_front_page() ) 
	{
	 	 if($homepage_title !='') { $title = $homepage_title; }
	 	 if($homepage_keywords != '') { $keywords = $homepage_keywords; } elseif ($general_keywords != '') { $keywords = $general_keywords; }
	 	 if($homepage_desc != '') { $description = $homepage_desc; } elseif ($general_desc != '') { $description = $general_desc; }
	}
	
	if ( is_single() )  
	{
		$post_title 		= get_post_meta($post->ID, PREFIX.'_post_seo_title',true);	
		$post_keywords		= get_post_meta($post->ID, PREFIX.'_post_seo_keywords',true);
		$post_description	= get_post_meta($post->ID, PREFIX.'_post_seo_description',true);
	
		if($post_title != '') { $title = $post_title; } else { remove_filter('wp_title', 'tfuse_add_title'); $title = wp_title('',false).' | '.$theme_name; }
		if($post_keywords != '') { $keywords = $post_keywords; } elseif ($general_keywords != '') { $keywords = $general_keywords; }
		if($post_description != '') { $description = $post_description; } elseif ($general_desc != '') { $description = $general_desc; }
	}
	
	if ( is_page() && !is_front_page() )  
	{
		$page_title 		= get_post_meta($post->ID, PREFIX.'_page_seo_title',true);	
		$page_keywords		= get_post_meta($post->ID, PREFIX.'_page_seo_keywords',true);
		$page_description	= get_post_meta($post->ID, PREFIX.'_page_seo_description',true);

		if($page_title != '') { $title = $page_title; } else { remove_filter('wp_title', 'tfuse_add_title'); $title = wp_title('',false).' | '.$theme_name; }
		if($page_keywords != '') { $keywords = $page_keywords; } elseif ($general_keywords != '') { $keywords = $general_keywords; }
		if($page_description != '') { $description = $page_description; } elseif ($general_desc != '') { $description = $general_desc; }
	}
	
	if ( is_category() ) 
	{ 
		$cat_ID 			= get_query_var('cat');
		$cat_title 			= get_option(PREFIX.'_cat_seo_title_'.$cat_ID);
		$cat_keywords		= get_option(PREFIX.'_cat_seo_keywords_'.$cat_ID);
		$cat_description	= get_option(PREFIX.'_cat_seo_description_'.$cat_ID);
	
		if($cat_title != '') { $title = $cat_title; } else { $title = single_cat_title('', false).' | '.$theme_name; }
		if($cat_keywords != '') { $keywords = $cat_keywords; } elseif ($general_keywords != '') { $keywords = $general_keywords; }
		if($cat_description != '') { $description = $cat_description; } elseif ($general_desc != '') { $description = $general_desc; }
	}
		 
	if ( is_search() )   { $title = $theme_name.' | '.__('Search Results for ', 'tfuse').sprintf(__('\'%s\''), $_GET['s']); } 
	if ( is_author() )   { $title = $theme_name.' | '.__('Author Archives', 'tfuse'); }
	if ( is_404() )      { $title = __('Page Not Found - 404 error', 'tfuse').' | '.$theme_name; }
	if ( is_month() )    { $title = $theme_name.' | '.__('Archive', 'tfuse').' | '.get_the_time('F'); }
	
	if ( function_exists('is_tag') ) { if ( is_tag() ) { $title = __('Tag Archive', 'tfuse').' | '.single_tag_title('', false).' | '.$theme_name;  } }

    $title       = strip_tags( tfuse_qtranslate($title) );
    $keywords    = strip_tags( tfuse_qtranslate($keywords) );
    $description = strip_tags( tfuse_qtranslate($description) );

	return array('title' => $title, 'keywords' => $keywords, 'description' => $description );
}

function tfuse_add_meta() {
	$tfuse_seo_meta = tfuse_seo();
	echo '
	<meta name="description" content="'.$tfuse_seo_meta['description'].'" />
	<meta name="keywords" content="'.$tfuse_seo_meta['keywords'].'" />
	<meta name="author" content="ThemeFuse" />';
}
function tfuse_add_title() {
	$tfuse_seo_meta = tfuse_seo();
	return trim($tfuse_seo_meta['title']);
}
add_filter('wp_title', 'tfuse_add_title');
if(get_option("{$prefix}_deactivate_tfuse_seo")!='true') add_action('wp_head', 'tfuse_add_meta');

//Disable Automatic formatting in WordPress posts
function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'my_formatter', 99);
add_filter('themefuse_shortcodes', 'my_formatter', 99);
add_filter('widget_text', 'my_formatter', 99);


// Localization
load_theme_textdomain('tfuse');
load_theme_textdomain( 'tfuse', THEME_DIR . '/languages' );
if (function_exists('load_child_theme_textdomain')) load_child_theme_textdomain('tfuse');

//qTranslate for custom fields
function tfuse_qtranslate($text) {
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    if(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) {
        $text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
    } 
    return $text;
}


function fb_change_mce_options($initArray) {
	// Comma separated string od extendes tags
	// Command separated string of extended elements
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
 
	if ( isset( $initArray['extended_valid_elements'] ) ) {
		//$initArray['extended_valid_elements'] .= ',' . $ext;
	} else {
		//$initArray['extended_valid_elements'] = $ext;
	}
	// maybe; set tiny paramter verify_html
	$initArray['verify_html'] = false;
	$initArray['cleanup'] = false;
	$initArray['remove_linebreaks'] = false;
	$initArray['remove_redundant_brs'] = false;
	$initArray['apply_source_formatting '] = true;
 
	return $initArray;
}
//add_filter('tiny_mce_before_init', 'fb_change_mce_options');

?>