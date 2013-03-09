<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
error_reporting(0);
include_once("config.php");
session_start();

if ($_SESSION['access'] != true) {
 $login_box = ' <div class="top_login_box"><a href="'.$conf_site_url.'/account/login/">Sign in</a><a href="'.$conf_site_url.'/account/register/">Register</a></div>';
    $not_logged_in = '<a href="'.$conf_site_url.'/account/register/"><img src='.$conf_site_url.'/images/frontpage/register-now-img.png" class="tabs_framed"></a><br>';
}else{
$login_box = '<div class="top_login_box"><a href="'.$conf_site_url.'/account/logout/">Logout</a><a href="'.$conf_site_url.'/account/settings/">Settings</a></div>';
    $not_logged_in = "";
}

include_once("".$conf_site_url."/analyticstracking.php");



$selected = $_GET['id'];

if($selected != null){
    $result = mysql_query("SELECT * FROM channels WHERE channel_id='$selected' AND featured='1' AND online='Online'");
}else{
    $result = mysql_query("SELECT * FROM channels WHERE featured='1' AND online='Online' ORDER BY feature_level DESC LIMIT 1");
}

$featured_res = mysql_query("SELECT * FROM channels WHERE featured='1' AND online='Online' ORDER BY feature_level DESC LIMIT 5");
$row = mysql_fetch_array($result);
$count = mysql_num_rows($featured_res);

// offline rediction and updating
$offline_url = "window.location = '?status=offline'";
$status = $_GET['status'];

    $channel_id = $row['channel_id'];
    $server_rtmp = $row['server_rtmp'];
    $online = $row['online'];
    $title = $row['title'];

    if($title != ""){
        $button = '<a href="<?=$conf_site_url?>/user/'.$channel_id.'/" class="button_link"><span>Visit Stream</span></a>';
    }
    $featured = $row['featured'];
    $banned = $row['banned'];
    $views = $row['views'];
    $videoad = $row['ad_level'];
    $ads_channel = $row['adsense_video_channel'];

if($count > 1){
    $featured_bar = "<a href='<?=$conf_site_url?>/featured/'><img src='/images/frontpage/featured_bar.png' class='tabs_framed''></a>";
}else{
    $featured_bar = "";
}

// viewers for featured games

$viewers_get = mysql_query("SELECT * FROM frontpage WHERE id='1'") or die(mysql_error());
$viewers_row = mysql_fetch_array($viewers_get);

$lol_viewers = $viewers_row ['lol'];
$dota2_viewers = $viewers_row ['dota2'];
$hon_viewers = $viewers_row ['hon'];
$sc2_viewers = $viewers_row ['sc2'];
$wow_viewers = $viewers_row ['wow'];
$cod_viewers = $viewers_row ['cod'];
$minecraft_viewers = $viewers_row ['mine'];
$other_viewers = $viewers_row ['other'];

if($status == "offline"){
    // then our stream is offline
    $offline_url = ""; // stop redicting
}else{
    $new_views = $views + 1;
    // we will also then add one to the views
    $add_view = mysql_query("UPDATE channels SET views='$new_views' WHERE channel_id='$channel_id'");
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title>GAMERS LIVE</title>
<link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
<link rel="shortcut icon" href="/favicon.ico" />
<link href="style.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/preloadCssImages.js"></script>
<script type="text/javascript" src="js/jquery.color.js"></script>

<script type="text/javascript" language="JavaScript" src="js/general.js"></script>
<script type="text/javascript" language="JavaScript" src="js/jquery.tools.min.js"></script>
<script type="text/javascript" language="JavaScript" src="js/jquery.easing.1.3.js"></script>

<script type="text/javascript" language="JavaScript" src="js/slides.jquery.js"></script>

<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" />
<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/files/flowplayer-3.2.11.min.js"></script>

<!-- slider -->
<script src="js/jquery.bxSlider.min.js" type="text/javascript"></script>
<link href="css/bxSlider.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(window).load(function () {
  var slider = $('#slider1').bxSlider({
	controls: false,
	mode: 'vertical',
	speed: 1500,
	pause: 5000,
	easing: 'easeOutCubic',
	auto: true,
	autoHover: true
  });

  $('#go-prev').click(function(){
    slider.goToPreviousSlide();
    return false;
  });

  $('#go-next').click(function(){
    slider.goToNextSlide();
    return false;
  });
}); 
</script>

    <style type="text/css">

    </style>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="<?=$conf_site_url?>/css/ie.css" />
<![endif]-->
</head>

<body>
<div class="body_wrap homepage">

<?php
include('slider.php');
?>

	
    <div class="container_title">
    <div class="header_title">
    	<div class="header_tab_title">
            <a href="#prev" class="slider-prev" id="go-prev">Prev</a><a href="#next" class="slider-next" id="go-next">Next</a>
            <h1 class="title">Events</h1>
        </div>
    </div> 
    </div>  
    
    
<div class="header_menu">
	<div class="container">
		<div class="logo"><a href=""><img src="images/logo.png" alt="" /></a></div>
        <?=$login_box?>
        <div class="top_search">
        	<form id="searchForm" action="/browse/" method="get">
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
                        <li><a href="/browse/lol/"><span>LoL</span></a></li>
                        <li><a href="/browse/dota2/"><span>Dota 2</span></a></li>
                        <li><a href="/browse/hon/"><span>HoN</span></a></li>
                        <li><a href="/browse/sc2/"><span>SC 2</span></a></li>
                        <li><a href="/browse/wow/"><span>WoW</span></a></li>
                        <li><a href="/browse/callofduty/"><span>Call Of Duty</span></a></li>
                        <li><a href="/browse/minecraft/"><span>Minecraft</span></a></li>
                        <li><a href="/browse/other/"><span>Others</span></a></li>
                        <li><a href="/blog/"><span>Blog</span></a></li>
                        <li><a href="#"><span>More</span></a>                        
                        	<ul>
                                <li><a href="/company/about/"><span>About</span></a></li>
                                <li><a href="/company/support/"><span>Contact</span></a></li>
                                <li><a href="/account/partner/"><span>Partner</span></a></li>
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
        <div class="page-title"><center><?=$not_logged_in?></center>
        <a href="<?=$conf_site_url?>/user/<?=$channel_id?>"><h2><?=$title?> </h2></a>
                    <center>

         			<a style="display:block;width:960px;height:540px;margin:10px auto" id="stream">
                    </a>
                    </center>
                    <?=$button?>
                    <br>
                    <?php

                    if($count > 1){
                        while($featured_row = mysql_fetch_array($featured_res)){
                            echo '<a href="?id='.$featured_row['channel_id'].'"><img src="'.$featured_row['feature_img'].'" class="tabs_framed" height="108" width="184" alt="Watch '.$featured_row['channel_id'].'"></a>';
                        }
                    }
                    ?>

                    <script type="text/javascript">
                        flowplayer("stream", "<?=$conf_site_url?>/files/flowplayer.commercial-3.2.11.swf",
                            {
                                clip: {
                                    url: '<?=$channel_id?>',
                                    live: true,
                                    provider: 'rtmp',
                                    ads: "<?=$videoad?>"
                                },

                                plugins: {

                                    controls: {
                                        autoHide: "never"
                                    },

                                    rtmp: {
                                        url: '<?=$conf_site_url?>/files/flowplayer.rtmp-3.2.11.swf',
                                        netConnectionUrl: '<?=$server_rtmp?><?=$channel_id?>'
                                    },

                                    adsense: {
                                        url: "<?=$conf_site_url?>/files/bigsool.adsense-2.0.swf",
                                        publisherId: "ca-video-pub-2504383399867703",
                                        channel: "<?=$ads_channel?>"
                                    }
                                },

							    onError: function(err) {
								   	this.unload();
									var element = document.getElementById('stream');
									element.parentNode.removeChild(element);
									<?=$offline_url?>
								}
							}
						);
					</script>
            <center>
                <?=$featured_bar?>
            </center>
        <br />
                </div>
                <div class="col col_1_3">
                    <div class="inner">
                    <center>
                    <a href="/browse/lol/" /><h3><?=$lol_viewers?> viewers</h3>
                    <img src="/images/frontpage/lol_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>
                <div class="col col_1_3">
                    <div class="inner">
                    <center>
                    <a href="/browse/dota2/" /><h3><?=$dota2_viewers?> viewers</h3>
                    <img src="/images/frontpage/dota2_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>
                <div class="col col_1_3">
                    <div class="inner">
                    <center>

                    <a href="/browse/hon/" /><h3><?=$hon_viewers?> viewers</h3>
                    <img src="/images/frontpage/hon_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>
                <hr />
                <div class="col col_1_3">
                    <div class="inner">
                    <center>
                    <a href="/browse/sc2/" /><h3><?=$sc2_viewers?> viewers</h3>
                    <img src="/images/frontpage/sc2_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>
                <div class="col col_1_3">
                    <div class="inner">
                    <center>
                    <a href="/browse/wow/" /><h3><?=$wow_viewers?> viewers</h3>
                    <img src="/images/frontpage/wow_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>    
                <div class="col col_1_3">
                    <div class="inner">
                    <center>
                    <a href="/browse/callofduty/" /><h3><?=$cod_viewers?> viewers</h3>
                    <img src="/images/frontpage/cod_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>
                <div class="col col_1_3">
                    <div class="inner">
                    <center> 
                    <a href="/browse/minecraft/" /><h3><?=$minecraft_viewers?> viewers</h3>
                    <img src="/images/frontpage/minecraft_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>
                <div class="col col_1_3">
                    <div class="inner">
                    <center>
                    <a href="/browse/other/" /><h3><?=$other_viewers?> viewers</h3>
                    <img src="/images/frontpage/other_normal.png" class="tabs_framed"/>
                    </a>
                    </center>
                    </div>
                </div>        
                <br />
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--/ middle -->

<div class="footer">
<div class="footer_inner">
<div class="container_12">
	
    <div class="grid_8">
    	<h3>Gamers Live</h3>
		
        <div class="copyright">
            <?=$conf_site_copy?> <br /><a href="/company/legal/">Terms of Service</a> - <a href="/company/support/">Contact</a> -
		<a href="/company/legal/">Privacy guidelines</a> - <a href="/company/support/">Advertise with Us</a> - <a href="/company/about/">About Us</a></p>
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
