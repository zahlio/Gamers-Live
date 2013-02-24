<?php if (is_single()) tfuse_post_cookie();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php tfuse_title(); ?></title>
    <?php tfuse_meta(); ?>

    <link href="<?php echo get_stylesheet_uri() ?>" media="screen" rel="stylesheet" type="text/css" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo tfuse_options(PREFIX.'_feedburner_url', get_bloginfo_rss('rss2_url')); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php  tfuse_head(); ?>
    <?php  wp_head(); ?>
</head>
<body <?php body_class();?>>
    <div class="body_wrap <?php bodywrap_class() ?>">
        <?php tfuse_slider_include();?>
        <div class="header_menu">
            <div class="container">
                        <div class="logo">
                            <a href="http://www.gamers-live.net/" title="<?php bloginfo('description'); ?>">
                                <img src="<?php tfuse_logo();  ?>" alt="<?php bloginfo('name'); ?>"  alt="Sportedge" border="0" />
                            </a>
                        </div><!--/ .logo -->

                        <?php  if(tfuse_options(PREFIX.'_signin_button',true)== 'true')
                        {?>
                            <div class="top_login_box">
                                <a href="<?php echo wp_login_url(); ?>"><?php _e('Sign in', 'tfuse'); ?></a>
                                <?php wp_register('',''); ?>
                            </div>
                        <?php }

                         tfuse_include(THEME_DIR.'/searchform');
                 // Include Menu on the Theme
                     tfuse_menu();?>
                </div><!--/ .container -->
            </div><!--/ .header_menu -->