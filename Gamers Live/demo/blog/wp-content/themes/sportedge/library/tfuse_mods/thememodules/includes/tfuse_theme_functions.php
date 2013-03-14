<?php 
	/*Function Description */
if ( ! function_exists( 'tfuse_options' ) ) :

	function tfuse_options($param = '', $return = false, $hed = false, $cat=false)
	{


        if ( $cat )
		{
           $cat_ID = get_query_var('cat');  		
           $param = get_option( $param . $cat_ID);
		}
		else
        {
            $param = get_option($param);
        }

		if ( !$return )
		{
 			if ( $param == 'true') $return_value = true; else $return_value = false;
		}
		elseif ( $return && $hed  )
		{
			if ( $param <> '' )  $return_value =  html_entity_decode($param, ENT_QUOTES, 'UTF-8'); else $return_value = '';
		}
		else 
		{
		    if ( $param <> '' )  $return_value =  $param; else $return_value = false;
		}
		
		return $return_value;
	
	}	// End function tfuse_options()
	
endif;


/*Function Description */
if ( ! function_exists( 'tfuse_page_options' ) ) :

	function tfuse_page_options($param = '', $return = false, $hed = false)
	{
		global $post;


		$param  = get_post_meta($post->ID, $param, true);
		

		if ( ! $return )
		{
 			if ( $param == 'true')  $return_value = true;  else   $return_value = false;
		}
		elseif ( $return && $hed  )
		{
			if ( $param <> '' )   $return_value =  html_entity_decode($param, ENT_QUOTES, 'UTF-8');  else $return_value = $return;
		}
		else 
		{
		    if ( $param <> '' )   $return_value =  $param;  else $return_value = '';
		}
		
		return $return_value;
	
	}	// End function tfuse_page_options()
	
endif;

/* 
Display the Title from current page
*/	
if ( ! function_exists( 'tfuse_title' ) ) :

	function tfuse_action_title()
	{

        global $s;
            if ( is_search() ) 	{  _e('Search for ', 'tfuse');  printf(__('\'%s\''), $s); }
        elseif (is_day()) 		{  _e( 'Archive', 'tfuse' ); ?> | <?php the_time( get_option( 'date_format' ) ); }
        elseif (is_month()) 	{  _e( 'Archive', 'tfuse' ); ?> | <?php the_time( 'F, Y' ); }
        elseif (is_year()) 		{  _e( 'Archive', 'tfuse' ); ?> | <?php the_time( 'Y' ); }
        elseif (is_author()) 	{  _e( 'Archive by Author', 'tfuse' ); }
        elseif (is_tag()) 		{  _e( 'Tag Archives:', 'tfuse' ); echo single_tag_title( '', true); }
        else wp_title('', true);

		

	
	}	// End function tfuse_action_title()

	add_action( 'tfuse_title', 'tfuse_action_title' );

endif;

if ( ! function_exists( 'tfuse_action_logo' ) ) :

	function tfuse_action_logo()
	{

		$logo = tfuse_options(PREFIX.'_logo',true);
        if ( $logo =='') $logo = get_template_directory_uri() . '/images/logo.png';
        echo $logo;
	
	}	// End function tfuse_action_logo()

	add_action( 'tfuse_logo', 'tfuse_action_logo' );

endif;

if ( ! function_exists( 'tfuse_action_menu' ) ) :

	function tfuse_action_menu()
	{
        
        require_once( THEME_MODULES . '/page-nav.php' );

	}	// End function tfuse_action_menu()

	add_action( 'tfuse_menu', 'tfuse_action_menu' );

endif;

if ( ! function_exists( 'tfuse_action_comments' ) ) :

	function tfuse_action_comments()
	{
        global $post;
        $tfuse_param = tfuse_header_parametrs();
		$checkComments = get_post_meta($post->ID, PREFIX . '_' . $tfuse_param['type_page'] . '_single_comments', true);
		$checkGeneralComments = get_option( PREFIX . '_disable_single_'.$tfuse_param['type_page'].'_comments');
		
         if ( ( $checkComments == 'false' || $checkComments == '' ) && ( $checkGeneralComments == 'false' || $checkGeneralComments == '' ) )  comments_template();
	}	// End function tfuse_action_comments()

	add_action( 'tfuse_comments', 'tfuse_action_comments' );

endif;

if ( ! function_exists( 'tfuse_action_post_meta' ) ) :

	function tfuse_action_post_meta()
	{
        global $post;
		
		if ( !tfuse_page_options(PREFIX . '_post_published_date') && get_option( PREFIX . '_disable_published_date')=='false' ) 
			return true;
		else 
			return false;
		
	}	// End function tfuse_action_comments()
endif;


if ( ! function_exists( 'tfuse_action_post_social_share_buttons' ) ) :

	function tfuse_action_post_social_share_buttons()
	{
        global $post;
		
		if ( !tfuse_page_options(PREFIX . '_post_published_date') && get_option( PREFIX . '_disable_published_date')=='false' ) 
			return true;
		else 
			return false;
		
	}	// End function tfuse_action_comments()
endif;

/* This Function Determined Type of Slider*/
if (! function_exists( 'tfuse_type_slider' ) ) :	

	function tfuse_type_slider()
	{
		global $post;
		$slider_type  = '';
		$enable_slider = '';
				
		if ( is_page() )		
		{ 
			$slider_type     = get_post_meta($post->ID, PREFIX . "_page_type_slider", true);	
			$enable_slider   = get_post_meta($post->ID, PREFIX . '_page_enable_slider', true); 
		}
		
		if ( is_single() )		
		{ 
			$slider_type     = get_post_meta($post->ID, PREFIX . "_post_type_slider", true);
			$enable_slider   = get_post_meta($post->ID, PREFIX . "_post_enable_slider", true); 
		}
		
		if ( is_category() )	
		{ 
			$cat_ID          = get_query_var('cat'); 
			$slider_type     = get_option( PREFIX . '_category_type_slider_' . $cat_ID);
			$enable_slider   = get_option( PREFIX . '_category_enable_slider_' . $cat_ID);	 
		}

		return $slider_type;
		
	}	// End function tfuse_type_slider()

endif;


/* This Function Addd the classes of body_class()  Function */

 add_filter('body_class','tfuse_browser_body_class');

if ( ! function_exists( 'tfuse_browser_body_class' ) ):
	
	function tfuse_browser_body_class()
	{
		
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE) 
		{
			$browser = $_SERVER['HTTP_USER_AGENT']; 
			$browser = substr("$browser", 25, 8); 
			if ($browser == "MSIE 7.0"  )
				$classes[] = 'ie7';
			elseif ($browser == "MSIE 6.0" )
				$classes[] = 'ie6';
			elseif ($browser == "MSIE 8.0" )
				$classes[] = 'ie8'; 
			else	
				$classes[] = 'ie';
		}
		else $classes[] = 'unknown';
	
		if($is_iphone) $classes[] = 'iphone';


		return $classes;
	
	}	// End function tfuse_browser_body_class()
  


endif; 

/*Function Description */

if ( ! function_exists( 'tfuse_area_shortcodes' ) ) :

	function tfuse_area_shortcodes($param = '')
	{
		$param = get_option($param);
		$footer_shortcodes = tfuse_qtranslate($param); 
		$footer_shortcodes = apply_filters('themefuse_shortcodes',$footer_shortcodes);
        echo $footer_shortcodes;
	}	// End function tfuse_area_shortcodes()
	
endif;


/*Function Description */
if ( ! function_exists( 'tfuse_action_footer' ) ) :

    function tfuse_action_footer()
    {
        require_once(THEME_MODULES . '/includes/tfuse_footer.php');
    }
    add_action( 'tfuse_footer', 'tfuse_action_footer');
endif;


/*Function Description */
if ( ! function_exists( 'tfuse_analytics' ) ) :

    function tfuse_analytics()
    {
        $output = tfuse_options(PREFIX.'_google_analytics', false, true);
        if ( $output <> "" )
            echo  $output;
    }
    add_action( 'wp_footer','tfuse_analytics' );
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_action_category_image_post' ) ) :

    function tfuse_action_category_image_post()
    {
        global $post;

        $large_image = get_post_meta($post->ID, PREFIX . "_post_image", true);
        $medium_image = get_post_meta($post->ID, PREFIX . "_post_image_medium", true);
        $small_image = get_post_meta($post->ID, PREFIX . "_post_image_small", true);
        $src_image = '';
        $img_in    = '';

            if($large_image != '') $src_image = $large_image;
        elseif($medium_image != '') $src_image = $medium_image;

        if($src_image != '')
        {
            $img_width = 305;
            $img_height = 206;
            $img_in = '<img src="' . tfuse_get_image($img_width, $img_height, 'src', $src_image, '', true) . '" alt="' . get_the_title() . '" class="alignleft" width="'.$img_width.'" height="'.$img_height.'" />';
        }

        echo $img_in;

    }
    add_action( 'tfuse_category_image_post','tfuse_action_category_image_post' );
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_action_portfolio_post_icon' ) ) :

    function tfuse_action_portfolio_post_icon()
    {
        echo get_template_part( 'includes/tfuse_portfolio_icon' );
    }
    add_action( 'tfuse_portfolio_post_icon','tfuse_action_portfolio_post_icon' );
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_class' ) ) :

    function tfuse_class($param, $return = false)
    {
        $tfuse_class = '';
        $sidebar_position = tfuse_sidebar_position();

        if($param == 'middle')
        {
            if ( is_page_template('template-contact.php') )
            {
                    if ( $sidebar_position == 'left' )  $tfuse_class = 'class="middle sidebarLeft nobg"';
                elseif ( $sidebar_position == 'right' ) $tfuse_class = 'class="middle sidebarRight nobg"';
                elseif ( $sidebar_position == 'full' )  $tfuse_class = 'class="middle"';
            }
            else
            {
                    if ( $sidebar_position == 'left' )  $tfuse_class = 'class="middle sidebarLeft"';
                elseif ( $sidebar_position == 'right' ) $tfuse_class = 'class="middle sidebarRight"';
                elseif ( $sidebar_position == 'full' )  $tfuse_class = 'class="middle"';
            }
        }
        elseif( $param == 'content' )
        {
                if ( $sidebar_position == 'left' && !is_year() )  $tfuse_class = 'class="grid_8 content"';
            elseif ( $sidebar_position == 'right' && !is_year() ) $tfuse_class = 'class="grid_8 content"';
            elseif ( $sidebar_position == 'full' || is_year() )  $tfuse_class = 'class="content"';
        }

        if ( $return ) return $tfuse_class; else echo $tfuse_class;
    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_action_user_profile' ) ) :

    function tfuse_action_user_profile()
    {
               $tfuse_meta = array();

               $meta = get_user_meta(get_the_author_meta( 'ID' ),'theme_fuse_extends_user_options',TRUE);
               if (!empty($meta)):
               foreach( $meta as $key => $item )
               {
                   if ( $key == 'facebook' || $key == 'twitter' || $key == 'in') $tfuse_meta[$key] = $item;
               }
               endif;


      return $tfuse_meta;
    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_action_post_title' ) ) :

    function tfuse_action_post_title($tfuse_title_position = '')
    {
        global $post;
        $tfuse_post_title = '';

       if ( get_post_meta($post->ID, PREFIX . "_show_title_post", true) == 'before_image' && $tfuse_title_position == 'before_image'  )
        {
            $tfuse_post_title =  '<h1>' . get_the_title() . '</h1>';
        }
        elseif ( get_post_meta($post->ID, PREFIX . "_show_title_post", true) == 'after_image' && $tfuse_title_position == 'after_image' )
        {
             $tfuse_post_title =  '<h2>' . get_the_title() . '</h2>';
        }

        echo $tfuse_post_title;
    }
    add_action('tfuse_action_post_title', 'tfuse_post_title' );
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_action_pagination_template' ) ) :

    function tfuse_action_pagination_template()
    {
         require_once(THEME_MODULES . '/includes/tfuse_page_category_template.php' );
    }
    add_action('tfuse_pagination_template','tfuse_action_pagination_template');
endif;
/*Function Description */
if ( ! function_exists( 'tfuse_portfolio_media' ) ) :

    function tfuse_portfolio_media($return = false)
    {
        global $post;

                $large_image 	= get_post_meta($post->ID, PREFIX . "_post_image", true);
                $medium_image 	= get_post_meta($post->ID, PREFIX . "_post_image_medium", true);
               

                    if($large_image  != '')	$media = $large_image;
                elseif($medium_image != '')	$media = $medium_image;

       if ( $return == true ) return $media; else echo $media;
    }

endif;

/*Function Description */
if ( ! function_exists( 'tfuse_child_categ' ) ) :

    function tfuse_child_categ()
    {
        $tfuse_child_categ =  array();
        if ( is_category() )
        {
        $q_cat = get_query_var('cat');
        $cat = get_category( $q_cat );
        }

        if ( $cat->category_parent == 0 ) $parent  = get_query_var('cat'); else  $parent  = $cat->category_parent;

        $tfuse_child_categ['child_cats']    = get_categories( 'child_of='.$parent );
        $tfuse_child_categ['categories']    = get_categories('child_of='.$parent );
        $tfuse_child_categ['category_link'] = get_category_link( $parent );
        $tfuse_child_categ['parent'] = $parent;

       
        return $tfuse_child_categ;
    }
endif;
/*Function Description */
if ( ! function_exists( 'tfuse_child_category' ) ) :

    function tfuse_child_category()
    {

         require_once(THEME_MODULES . '/includes/tfuse_portfolio.php' );
    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_main_slide_title' ) ) :

    function tfuse_main_slide_title()
    {
        global $post, $cat_ID;

        if ( is_page() )
        $tfuse_slide_title = get_post_meta($post->ID, PREFIX.'_page_main_slide_title', true);
        elseif ( is_single() )
        $tfuse_slide_title = get_post_meta($post->ID, PREFIX.'_post_main_slide_title', true);
        elseif( is_category() )
        $tfuse_slide_title = get_option( PREFIX . '_category_title_header_' . $cat_ID);

        echo $tfuse_slide_title;
    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_color' ) ) :

    add_filter('tfuse_head','tfuse_color');

    function tfuse_color()
    {
        $output = '';
        $tfuse_header_color = get_option(PREFIX.'_header_colorpicker');
        $tfuse_body_color = get_option(PREFIX.'_body_colorpicker');
        $tfuse_footer_color = get_option(PREFIX.'_footer_colorpicker');

        $tfuse_header_pattern = get_option(PREFIX.'_header_pattern_background');
        $tfuse_custom_image_header = get_option(PREFIX.'_header_image');

        $tfuse_header_image = empty($tfuse_custom_image_header) ? $tfuse_custom_image_header : $tfuse_header_pattern;
        $tfuse_header_bg = empty($tfuse_header_image) ? $tfuse_header_image : $tfuse_header_color;
		


       if ($tfuse_header_image != '')   $output .='.header { background: url("' . $tfuse_header_image . '") repeat-x scroll 0 0 transparent;}';
       elseif ( $tfuse_header_color )  $output .= '.header {background:'.$tfuse_header_color.'}' . "\n";
       if ( $tfuse_body_color )     $output .= '.middle .container, .middle   {background:'.$tfuse_body_color.'}' . "\n";
       if ( $tfuse_footer_color )  $output .= '.footer, .footer_inner {background:'.$tfuse_footer_color.'}' . "\n";

        if (isset($output) && $output != '') {
			$output = strip_tags($output);
			$output = "<!-- Themefuse Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}




    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_include' ) ) :

    function tfuse_include($path )
    {
        if ( $path ) require_once($path.'.php');
    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_fb_share' ) ) :

    function tfuse_fb_share()
    { ?>

        <span class="st_facebook_hcount"></span>
        <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">
        stLight.options({
                publisher:'12345'
        });
        </script>
    <?php
    }
endif;
/*Function Description */
if ( ! function_exists( 'tfuse_tw_share' ) ) :

    function tfuse_tw_share()
    {
        global $post;
        ?>

        <div class="tw_share">
            <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
            <a href="https://twitter.com/share?url=<?php echo urlencode(get_permalink($post->ID)); ?>" class="twitter-share-button" data-count="none" data-via="sindicatase">Tweet</a>
        </div>
        <?php 
    }
endif;
/*Function Description */
if ( ! function_exists( 'tfuse_google_share' ) ) :

    function tfuse_google_share()
    {
        ?>

        <div class="google_share">
            <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
            <g:plusone size="tall" annotation="none"></g:plusone>
        </div>
        <?php
    }
endif;

/*Function Description */
if ( ! function_exists( 'tfuse_single_media' ) ) :
    function tfuse_single_media()
    {
        global $post;
        $tfuse_single_media = array();
            $post_video 	= get_post_meta($post->ID, PREFIX . "_post_video", true);
            $large_image 	= get_post_meta($post->ID, PREFIX . "_post_image", true);
            $medium_image 	= get_post_meta($post->ID, PREFIX . "_post_image_medium", true);
            $tfuse_single_media['disablevideo']   =  get_post_meta($post->ID, PREFIX . "_post_single_video", true);
            $tfuse_single_media['desableimage']   = get_post_meta($post->ID, PREFIX . "_post_single_image", true);
            $tfuse_single_media['disablepretty'] = get_option(PREFIX . "_disable_lightbox");
            $tfuse_single_media['post_video'] = $post_video;
            $tfuse_src_image      = '';
            $tfuse_media = '';

            if($medium_image != '')	$tfuse_src_image = $medium_image;
        elseif($large_image  != '')	$tfuse_src_image = $large_image;

        $tfuse_single_media['src_image'] = $tfuse_src_image;

                if($post_video 	 != '' &&  $tfuse_single_media['disablevideo']  == 'true')	$tfuse_media = $post_video;
            elseif($large_image  != '')	$tfuse_media = $large_image;
            elseif($medium_image != '')	$tfuse_media = $medium_image;

         $tfuse_single_media['media'] = $tfuse_media;

        return $tfuse_single_media;
    }
endif;

if ( !function_exists('tfuse_twitter_script') ) :
	function tfuse_twitter_script($unique_id, $username = '', $limit = 5, $tweet_image = false) {
	?>
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--

	    function twitterCallback2(twitters) {

	      var statusHTML = [];
	      for (var i=0; i<twitters.length; i++){
	        var username = twitters[i].user.screen_name;
            var username_avatar = twitters[i].user.profile_image_url;
	        var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
	          return '<a href="'+url+'">'+url+'</a>';
	        }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
	          return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
	        });
	        statusHTML.push('<div class="tweet_item"><?php if ($tweet_image) { ?><div class="tweet_image"><img src="'+username_avatar+'" width="30" height="30" alt="" /></div><?php } ?><div class="tweet_text"><div class="inner">'+status+'</div></div><div class="clear"></div></div>');
	      }
	      document.getElementById('twitter_update_list_<?php echo $unique_id; ?>').innerHTML = statusHTML.join('');
	    }

	    function relative_time(time_value) {
	      var values = time_value.split(" ");
	      time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	      var parsed_date = Date.parse(time_value);
	      var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	      var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	      delta = delta + (relative_to.getTimezoneOffset() * 60);

	      if (delta < 60) {
	        return 'less than a minute ago';
	      } else if(delta < 120) {
	        return 'about a minute ago';
	      } else if(delta < (60*60)) {
	        return (parseInt(delta / 60)).toString() + ' minutes ago';
	      } else if(delta < (120*60)) {
	        return 'about an hour ago';
	      } else if(delta < (24*60*60)) {
	        return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
	      } else if(delta < (48*60*60)) {
	        return '1 day ago';
	      } else {
	        return (parseInt(delta / 86400)).toString() + ' days ago';
	      }
	    }
	//-->!]]>
	</script>
	<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $username; ?>.json?callback=twitterCallback2&amp;count=<?php echo $limit; ?>&amp;include_rts=t"></script>
	<?php
	}
endif;

if ( ! function_exists('tfuse_post_type') ):
    function tfuse_post_type()
    {
        global $post;
        $tfuse_post_type = get_post_meta($post->ID, PREFIX."_post_type", true);
        if ( isset($tfuse_post_type) && !empty($tfuse_post_type))
        {
            $tfuse_post_icon = get_template_directory_uri() . '/images/icons/icon_cat_' . $tfuse_post_type.'.png';
            $tfuse_image = '<img src="'.$tfuse_post_icon.'" alt="'.$tfuse_post_type.'" width="30" height="30" />';

           // $tfuse_image = tfuse_get_image(30, 30, 'img',  $tfuse_post_icon, '', true, '');
        }
        else
        {
            $tfuse_post_icon = get_template_directory_uri() . '/images/icons/icon_cat_quotes.png';
            $tfuse_image = '<img src="'.$tfuse_post_icon.'" alt="'.$tfuse_post_type.'" width="30" height="30" />';
        }

        return $tfuse_image;
    }
endif;

if ( ! function_exists('tfuse_get_comments')):
    function tfuse_get_comments($return = TRUE, $post_ID)
    {
        $num_comments = get_comments_number($post_ID);

        if ( comments_open() )
        {
          if($num_comments == 0)
          {
              $comments = __('No Comments');
          }
          elseif($num_comments > 1)
          {
              $comments = $num_comments. __(' Comments');
          }
          else
          {
               $comments ="1 Comment";
          }
          $write_comments = '<a class="link-comments" href="' . get_comments_link() .'">'. $comments.'</a>';
        }
        else
        {
            $write_comments =  __('Comments are off');
        }
        if ( $return) return $write_comments;
        else echo $write_comments;
    }
endif;

if ( !function_exists('bodywrap_class') ):
    function bodywrap_class()
    {
        $tfuse_bodywrap_class = '';
        $tfuse_param = tfuse_header_parametrs();
            if( $tfuse_param['header_element'] == 'type1' ) $tfuse_bodywrap_class  = 'homepage';
        elseif ( $tfuse_param['header_element'] == 'type2' || $tfuse_param['header_element'] == '') $tfuse_bodywrap_class = 'thinpage';

        echo $tfuse_bodywrap_class;
    }
endif;

if ( !function_exists('tfuse_custom_title') ):
    function tfuse_custom_title()
    {

        $tfuse_title_type = tfuse_page_options(PREFIX . '_select_page_title', true);

        if ( $tfuse_title_type == 'default_title') $title = get_the_title();
        elseif ( $tfuse_title_type == 'custom_title') $title = html_entity_decode(tfuse_page_options(PREFIX . '_page_custom_title', true),ENT_QUOTES, 'UTF-8');
        elseif ( $tfuse_title_type == 'none' ) $title = '';
        else $title ='';

        echo ( $title != '') ? '<h1>' .$title. '</h1>' : '';
    }
endif;

if ( !function_exists('tfuse_time_ago') ):
    function tfuse_time_ago( $id = '', $return = FALSE )
    {
        global $post;
        $tfuse_id = ( empty($id) ) ? $post->ID  : $id;
        $tfuse_type_time = human_time_diff(get_post_time('U', false,$tfuse_id), current_time('timestamp')) . " " . __('ago');;
       if ($return) return $tfuse_type_time;
       else echo $tfuse_type_time;

    }
endif;

if ( !function_exists('tfuse_search_title') ):
    function tfuse_search_title()
    {
        global $s;
            if ( is_search() ) 	{  _e('Search results for ', 'tfuse');  printf(__('\'%s\''), $s); }
        elseif (is_day()) 		{  _e( 'Archive', 'tfuse' ); ?> | <?php the_time( get_option( 'date_format' ) ); }
        elseif (is_month()) 	{  _e( 'Archive', 'tfuse' ); ?> | <?php the_time( 'F, Y' ); }
        elseif (is_year()) 		{  _e( 'Archive', 'tfuse' ); ?> | <?php the_time( 'Y' ); }
        elseif (is_author()) 	{  _e( 'Archive by Author', 'tfuse' ); }
        elseif (is_tag()) 		{  _e( 'Tag Archives:', 'tfuse' ); echo single_tag_title( '', true); }
    }
endif;
if ( !function_exists('tfuse_back_to_category') ):
    function tfuse_back_to_category()
    {
        $tfuse_category = get_the_category();
        $tfuse_cat_detail = array();
        foreach( $tfuse_category as $category)
        {
             $tfuse_cat_detail['cat_name'] = $category->name;
             $tfuse_cat_detail['cat_ID']   = get_cat_ID($category->name);
             $tfuse_cat_detail['cat_link'] = get_category_link( $category->cat_ID );
        }
        return $tfuse_cat_detail;

    }
endif;
/*Function Description */
if ( ! function_exists( 'tfuse_action_middle_class' ) ) :

    function tfuse_action_middle_class()
    {
        $sidebar_position = tfuse_sidebar_position();

            if ( $sidebar_position == 'left' )  echo 'class="middle  sidebarLeft"';
        elseif ( $sidebar_position == 'right' ) echo 'class="middle sidebarRight"';
        elseif ( $sidebar_position == 'full' )  echo 'class="middle"';

    }
    add_action('tfuse_middle_class','tfuse_action_middle_class');
endif;
/*Function Description */
if ( ! function_exists( 'tfuse_slide_title' ) ) :

    function tfuse_slide_title()
    {
        global $post, $cat_ID;

        if ( is_page() )
        $tfuse_slide_title = get_post_meta($post->ID, PREFIX.'_page_slide_tab_title', true);
        elseif ( is_single() )
        $tfuse_slide_title = get_post_meta($post->ID, PREFIX.'_post_slide_tab_title', true);
        elseif( is_category() )
        $tfuse_slide_title = get_option( PREFIX . '_category_slide_tab_title_' . $cat_ID);

        echo $tfuse_slide_title;
    }
endif;

if ( ! function_exists( 'tfuse_post_cookie' ) ) :
    function tfuse_post_cookie()
    {
        global $post;
        $popularArr = array();

        if (isset($_COOKIE['popular']))
        {
           $popularArr = explode(",", $_COOKIE['popular']);

            if ( !in_array($post->ID, $popularArr) ) $popularArr[] = $post->ID;
        }
        else
        {
            $popularArr[] = $post->ID;
        }

        setcookie('popular',implode(",", $popularArr),time()+3600*24*30);

    }
endif;
if ( ! function_exists( 'tfuse_clickPost' ) ) :
    function tfuse_clickPost()
    {
        if ( is_single())
        {
            global $post, $tfuse_count;
            $tfuse_post = get_posts();
            $tfuse_count =  get_post_meta($post->ID,PREFIX.'_post_viewed', true);
            if (!$tfuse_count)
            {
                $tfuse_count = 0;
                update_post_meta($post->ID,PREFIX.'_post_viewed',0);
            }

            $tfuse_cookie = ( isset( $_COOKIE['popular']) )? explode(",", $_COOKIE['popular']) : array();

            foreach( $tfuse_post as $postArr )
            {
                if ( $post->ID == $postArr->ID && !in_array($post->ID, $tfuse_cookie) )
                {
                    update_post_meta($postArr->ID,PREFIX.'_post_viewed',++$tfuse_count);
                }
            }

            return $tfuse_count;

        }
        return false;

    }
endif;

    function tfuse_sidebar_add($param = 'page')
    {
        $query = new WP_Query( array ( 'post_type' => 'page', 'orderby' => 'meta_value', 'meta_key' => PREFIX.'_page_featured_tabs', 'meta_value' => 'true', 'order'=>'DESC' ) );
        $tfuse_posts  = $query->get_posts();
        for ($i=0; $i<count($tfuse_posts); $i++)
        {
            $tfuse_ID[] = $tfuse_posts[$i]->ID;
        }

        $category = get_categories();
		//echo "<pre>"; print_r($category); echo "</pre>";
		foreach($category as $key=> $val)
		{
			$tfuse_categ_ID = $val->cat_ID;
            $tfuse_top_sidabar = get_option(PREFIX.'_category_featured_tabs_'.$tfuse_categ_ID);
            if ( $tfuse_top_sidabar == 'true') $tfuse_cat_ID[] = $tfuse_categ_ID;
		}
        return ($param == 'cat') ? @$tfuse_cat_ID : @$tfuse_ID;
    }
?>