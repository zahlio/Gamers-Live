<?php
error_reporting(0);
session_start();
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");
            if ($_SESSION['access'] != true) {
                $login_box = ' <div class="top_login_box"><a href="'.$conf_site_url.'/account/login/">Sign in</a><a href="'.$conf_site_url.'/account/register/">Register</a></div>';
            }else{
                $login_box = '<div class="top_login_box"><a href="'.$conf_site_url.'/account/logout/">Logout</a><a href="'.$conf_site_url.'/account/settings/">Settings</a></div>';
            }?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="Description" content="A short description of your company" />
    <meta name="Keywords" content="Some keywords that best describe your business" />
    <title><?=$conf_site_name?></title>
<link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
    <link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$conf_site_url?>/js/preloadCssImages.js"></script>
    <script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.color.js"></script>

    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/general.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.tools.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.easing.1.3.js"></script>

    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/slides.jquery.js"></script>

    <link rel="stylesheet" href="<?=$conf_site_url?>/css/prettyPhoto.css" type="text/css" media="screen" />
    <script src="<?=$conf_site_url?>/js/jquery.prettyPhoto.js" type="text/javascript"></script>

    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?=$conf_site_url?>css/ie.css" />
    <![endif]-->
</head>
<body>
<div class="body_wrap thinpage">

<div class="header_image" style="background-image:url(<?=$conf_site_url?>/images/header.png)">&nbsp;</div>

<div class="header_menu">
	<div class="container">
		<div class="logo"><a href="<?=$conf_site_url?>/"><img src="<?=$conf_site_url?>/images/logo.png" alt="" /></a></div>
        <?=$login_box?>
        <div class="top_search">
        	<form id="searchForm" action="<?=$conf_site_url?>/browse/" method="get">
                <fieldset>
                	<input type="submit" id="searchSubmit" value="" />
                    <div class="input">
                        <input type="text" name="s" id="s" value="Type & press enter" />
                    </div>                    
                </fieldset>
            </form>
        </div>
        
          <!-- topmenu -->
        <div class="topmenu">
                    <ul class="dropdown">
                        <li><a href="<?=$conf_site_url?>/browse/lol/"><span>LoL</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/dota2/"><span>Dota 2</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/hon/"><span>HoN</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/sc2/"><span>SC 2</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/wow/"><span>WoW</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/callofduty/"><span>Call Of Duty</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/minecraft/"><span>Minecraft</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/other/"><span>Others</span></a></li>
                        <li><a href="<?=$conf_blog?>"><span>Blog</span></a></li>
                        <li><a href="#"><span>More</span></a>                        
                        	<ul>
                                
                                <li><a href="<?=$conf_site_url?>/company/support/"><span>Contact</span></a></li>
                                <li><a href="<?=$conf_site_url?>/account/partner/"><span>Partner</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
        	<!--/ topmenu -->
    </div>
</div>     	
<!--/ header -->



<!-- middle -->
<div class="middle">
<div class="container_12">

	<div class="back_title">
    	<div class="back_inner">
		<a href="index.html"><span>Home</span></a>
        </div>
    </div>

    <div class="divider_space_thin"></div>

    <!-- content -->
    <div class="grid_8 content">

		<h1>Support & Contact</h1><br />
        <a href="<?=$conf_support?>">
        <img src="<?=$conf_site_url?>/images/support.png" class="tabs_framed" />
        </a>
        <br />
        <a href="<?=$conf_support?>">
        <img src="<?=$conf_site_url?>/images/contact_us.png" class="tabs_framed" />
        </a>

    </div>
    <!--/ content -->

    <!-- sidebar -->
    <div class="grid_4 sidebar">

    	<div class="widget-container widget_text">
            <div class="textwidget">
                <span class="meta-date">Headquarters</span>
                <h5><?=$conf_site_name?></h5>
                <p><?=$conf_address?></p>
                <p><strong>Phone</strong>: <?=$conf_phone?><br />
    <strong>Email:</strong> <?=$conf_support_email?><br />

        	</div>
		</div>

		<div class="post-share">
				<a href="<?=$conf_site_url?>/twitter/" class="btn-share"><img src="<?=$conf_site_url?>/images/share_twitter.png" width="79" height="25" alt="" /></a> <a href="<?=$conf_site_url?>/facebook/" class="btn-share"><img src="<?=$conf_site_url?>/images/share_facebook.png" width="88" height="25" alt="" /></a>
		</div>
    </div>
    <!--/ sidebar -->



    <div class="clear"></div>

</div>
</div>
<!--/ middle -->

<div class="footer">
<div class="footer_inner">
<div class="container_12">
	
    <div class="grid_8">
    	<h3><?=$conf_site_name?></h3>   
		
        <div class="copyright">
		<?=$conf_site_copy?> <br /><a href="<?=$conf_site_url?>/company/legal/">Terms of Service</a> - <a href="<?=$conf_site_url?>/company/support/">Contact</a> -
		<a href="<?=$conf_site_url?>/company/legal/">Privacy guidelines</a> - <a href="<?=$conf_site_url?>/company/support/">Advertise with Us</a> - <a href="<?=$conf_site_url?>/company/about/">About Us</a></p>
		</div>          
    </div>
    
    <div class="grid_4">
    	<h3>Follow us</h3>
        <div class="footer_social">
        	<a href="<?=$conf_site_url?>/facebook/" class="icon-facebook">Facebook</a> 
            <a href="<?=$conf_site_url?>/twitter/" class="icon-twitter">Twitter</a>
            <a href="<?=$conf_site_url?>/rss/" class="icon-rss">RSS</a>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="clear"></div>
</div>
</div>
</div>   

</div>   
</body>
</html>
