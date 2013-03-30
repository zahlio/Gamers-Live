<?php
error_reporting(0);


session_start();

header("Refresh: 120;");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
	header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];
$admin = $_SESSION['admin'];
				
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");

// connect to database


// select thje database we need


// get all live viewers
$live_viewers = mysql_query("SELECT SUM(viewers) AS viewers_sum FROM channels") or die(mysql_error());
$live_viewers_row = mysql_fetch_assoc($live_viewers);
$live_viewers_total = $live_viewers_row['viewers_sum'];

// get total online live streamers
$live_streams =  mysql_query("SELECT * FROM channels WHERE online='Online'") or die(mysql_error());
$live_streams_count = mysql_num_rows($live_streams);

// get total views
$live_views = mysql_query("SELECT SUM(views) AS views_sum FROM channels") or die(mysql_error());
$live_views_row = mysql_fetch_assoc($live_views);
$live_views_total = $live_views_row['views_sum'];

// get total number of members
$total_members = mysql_query("SELECT * FROM channels") or die(mysql_error());
$total_members_count = mysql_num_rows($total_members);
					
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
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
		<div class="logo"><a href="<?=$conf_site_url?>/account/?<?=SID; ?>"><img src="<?=$conf_site_url?>/images/logo.png" alt="" /></a></div>
        <div class="top_login_box"><a href="<?=$conf_site_url?>/account/logout/?<?=SID; ?>">Logout</a><a href="<?=$conf_site_url?>/account/settings/?<?=SID; ?>">Settings</a></div>
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
                        <li><a href="<?=$conf_site_url?>/browse/lol/?<?=SID; ?>"><span>LoL</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/dota2/?<?=SID; ?>"><span>Dota 2</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/hon/?<?=SID; ?>"><span>HoN</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/sc2/?<?=SID; ?>"><span>SC 2</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/wow/?<?=SID; ?>"><span>WoW</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/callofduty/?<?=SID; ?>"><span>Call Of Duty</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/minecraft/?<?=SID; ?>"><span>Minecraft</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/other/?<?=SID; ?>"><span>Others</span></a></li>
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
		<a href="<?=$conf_site_url?>/account/?"<? SID;?><span>Home</span></a>
        </div>
    </div> 	 
   
    
    <!-- content -->
    <div class="content"><br />
        <!-- account menu -->
    <center>
    <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/admin/?<?=SID; ?>" class="button_link btn_black"><span>Admin CP</span></a><a href="<?=$conf_site_url?>/account/admin/payments/?" class="button_link btn_red"><span>Partner Payments</span></a><a href="<?=$conf_site_url?>/account/admin/config/?" class="button_link btn_red"><span>Site Configurations</span></a><a href="<?=$conf_site_url?>/account/admin/games/?" class="button_link btn_red"><span>Games Management</span></a>
    <?php
error_reporting(0);


	$now_time = date('l jS \of F Y H:i:s');
	?>
    </center>    
    <!-- account menu end -->
    <!--/ content --> 
    <h3>Current Stats <i>(<?=$now_time?>)</i></h3>
    <b>Live viewers:</b> <?=$live_viewers_total?>
    <b>Live streams:</b> <?=$live_streams_count?>
    <b>Total views:</b> <?=$live_views_total?>
    <b>Member count:</b> <?=$total_members_count?>
    
    <br /><br /><br />
    <h3>Graphs</h3>
    <?php
error_reporting(0);


	// past hour live viewers
	// we get 12 stat indputs an hour
	// we use a seperation of 5 mins
	$current_min = date('i');
	$m_1 = '55'; 
	$m_2 = '50'; 
	$m_3 = '45'; 
	$m_4 = '40'; 
	$m_5 = '35'; 
	$m_6 = '30';  
	$m_7 = '25';  
	$m_8 = '20';  
	$m_9 = '15'; 
	$m_10 = '10';  
	$m_11 = '5'; 
	
	$last_hour = "now|".$m_11."mins ago|".$m_10."mins ago|".$m_9."mins ago|".$m_8."mins ago|".$m_7."mins ago|".$m_6."mins ago|".$m_5."mins ago|".$m_4."mins ago|".$m_3."mins ago|".$m_2."mins ago|".$m_1."mins ago|";
	
	// we will get the last 288 records and seperate them with a comma 
	
	$get_views_h = mysql_query("SELECT amount FROM admin_logs WHERE type='live_viewers' ORDER BY id DESC LIMIT 12") or die(mysql_error());
	
	echo '<img src="http://chart.apis.google.com/chart?cht=lc&amp;chtt=Past hour Live Viewers&amp;chl='.$last_hour.'&amp;chco=FF9900&amp;chs=950x290&amp;chd=t:';
	
	while($get_views_h_row = mysql_fetch_array($get_views_h)){
		echo "".$get_views_h_row['amount'].",";
	}
	echo '0&amp;chf=bg,s, FF9900" alt="Live Viewers" class="frame img_nofade"></p>';
	
	
	// we get 288 stats inputs a day.
		// current hour
	$current_h = date('H');
	
	$h_1 = date('H', strtotime('-24 hour')); 
	$h_2 = date('H', strtotime('-23 hour'));
	$h_3 = date('H', strtotime('-22 hour'));
	$h_4 = date('H', strtotime('-21 hour'));
	$h_5 = date('H', strtotime('-20 hour'));
	$h_6 = date('H', strtotime('-19 hour'));
	$h_7 = date('H', strtotime('-18 hour'));
	$h_8 = date('H', strtotime('-17 hour'));
	$h_9 = date('H', strtotime('-16 hour'));
	$h_10 = date('H', strtotime('-15 hour'));
	$h_11 = date('H', strtotime('-14 hour'));
	$h_12 = date('H', strtotime('-13 hour'));
	$h_13 = date('H', strtotime('-12 hour'));
	$h_14 = date('H', strtotime('-11 hour'));
	$h_15 = date('H', strtotime('-10 hour'));
	$h_16 = date('H', strtotime('-9 hour'));
	$h_17 = date('H', strtotime('-8 hour'));
	$h_18 = date('H', strtotime('-7 hour'));
	$h_19 = date('H', strtotime('-6 hour'));
	$h_20 = date('H', strtotime('-5 hour'));
	$h_21 = date('H', strtotime('-4 hour'));
	$h_22 = date('H', strtotime('-3 hour'));
	$h_23 = date('H', strtotime('-2 hour'));
	$h_24 = date('H', strtotime('-1 hour'));
		
	$last_24h_string = "".($current_h).":00|".$h_24.":00|".$h_23.":00|".$h_22.":00|".$h_21.":00|".$h_20.":00|".$h_19.":00|".$h_18.":00|".$h_17.":00|".$h_16.":00|".$h_15.":00|".$h_14.":00|".$h_13.":00|".$h_12.":00|".$h_11.":00|".$h_10.":00|".$h_9.":00|".$h_8.":00|".$h_7.":00|".$h_6.":00|".$h_5.":00|".$h_4.":00|".$h_3.":00|".$h_2.":00|".$h_1.":00|";
	
	// we will get the last 288 records and seperate them with a comma 
	
	$get_views = mysql_query("SELECT amount FROM admin_logs WHERE type='live_viewers' ORDER BY id DESC LIMIT 288") or die(mysql_error());
	
	echo '<img src="http://chart.apis.google.com/chart?cht=lc&amp;chtt=Past 24h Live Viewers&amp;chl='.$last_24h_string.'&amp;chco=FF9900&amp;chs=950x290&amp;chd=t:';
	
	while($get_views_row = mysql_fetch_array($get_views)){
		echo "".$get_views_row['amount'].",";
	}
	echo '0&amp;chf=bg,s, FF9900" alt="Live Viewers" class="frame img_nofade"></p>';
	
	?>

    <!-- charts end -->
      
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
