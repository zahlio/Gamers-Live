<?php
error_reporting(0);

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");
include_once("".$conf_ht_docs_gl."/analyticstracking.php");


			session_start();

			if ($_SESSION['access'] != true) {
			 $login_box = ' <div class="top_login_box"><a href="'.$conf_site_url.'/account/login/">Sign in</a><a href="'.$conf_site_url.'/account/register/">Register</a></div>';
			}else{
			$login_box = '<div class="top_login_box"><a href="'.$conf_site_url.'/account/logout/">Logout</a><a href="'.$conf_site_url.'/account/settings/">Settings</a></div>';
			}				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title><?=$conf_site_name?> - Partner</title>
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
                                <li><a href="<?=$conf_site_url?>/account/partner/?<?=SID; ?>"><span>Partner</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
        	<!--/ topmenu -->
    </div>
</div>     	
<!--/ header -->



<!-- middle -->
<div class="middle full_width">
<div class="container_12">

	<div class="back_title">
    	<div class="back_inner">
		<a href="<?=$conf_site_url?>/"<span>Home</span></a>
        </div>
    </div> 	 
   
    
    <!-- content -->
    <div class="content"><br />
    <h1><?=$conf_site_name?> partnership</h1>
    <p>To become a partner you must be within one of the following specifications:<br />
    <div class="list_check">
    <ul>
    <li>You have a YouTube channel with more then 25.000 subscribers and your average video has been viewed more then 2.500 times.</li>
	<li>You are already live streaming on another platform (can also be here on <?=$conf_site_name?>), you live stream has more then an average of 100 viewers.</li>
	<li>You are an event or streamer who will give all the revenue generated by ads to charity (there are no minimum requirements here, it will be a case to case decision.).</li>
    </ul>
    </div>
    <h3>What you get as a partner:</h3>
    <p>As a partner you will be able to custom design your channel page with the use of HTML and CSS. <br />You will also recieve a minimum of 80% of the revenue generated by your stream (video ads and static ads on your channel). In some cases we might give up to 99% of the revenue to the channel owner. <br />You will also be able to enable the "Tip" feature, where your viewers are able to tip you for a custom amount. Of this amount you will again get a minimum of 80% but we will in some cases give up to 99% of the revenue.
    <br /><h3>How do i apply?</h3><p>Well you do that right here! The only thing you need to do is send a application to us with the information you think is needed. Remember if you wish to be a partner a well written, funny and atractive application gets you further then a cheesy fast or even a long boring applications.<br /><br />
    <center><i>Please choose the Department: "Partner Application" or else you will not recieve a reply!</i><br /><a href="<?=$conf_support?>" class="button_link"><span>Apply Now</span></a></center>
    </p>
</div>
    </div>
    <!--/ content --> 
    
   
    <div class="clear"></div>
    
</div>
</div>
<!--/ middle -->
<!--/ middle -->

<div class="footer">
<div class="footer_inner">
<div class="container_12">
	
    <div class="grid_8">
    	<h3><?=$conf_site_name?></h3>   
		
        <div class="copyright">
		<?=$conf_site_copy?> <br /><a href="<?=$conf_site_url?>/company/legal/">Terms of Service</a> - <a href="<?=$conf_site_url?>/company/support/">Contact</a> -
		<a href="<?=$conf_site_url?>/company/legal/">Privacy guidelines</a> - <a href="<?=$conf_site_url?>/company/support/">Advertise with Us</a></p>
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
