<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
error_reporting(0);
include_once("config.php");
include_once("analyticstracking.php");

session_start();

if(!include_once("config.php")){
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://gamers-live.net/installer/?app=gl">';
}else{
    include_once("".$conf_ht_docs_gl."/files/check.php");;
    include_once("".$conf_ht_docs_gl."/analyticstracking.php");
}


if ($_SESSION['access'] != true) {
 $login_box = ' <div class="top_login_box"><a href="'.$conf_site_url.'./account/login/">Sign in</a><a href="'.$conf_site_url.'/account/register/">Register</a></div>';
    $not_logged_in = '<a href="'.$conf_site_url.'/account/register/"><img src="'.$conf_site_url.'/images/frontpage/register-now-img.png" class="tabs_framed"></a><br>';
}else{
$login_box = '<div class="top_login_box"><a href="'.$conf_site_url.'/account/logout/">Logout</a><a href="'.$conf_site_url.'/account/">Account</a></div>';
    $not_logged_in = "";
}

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
        $button = '<a href="".$conf_site_url."/user/'.$channel_id.'/" class="button_link"><span>Visit Stream</span></a>';
    }
    $featured = $row['featured'];
    $banned = $row['banned'];
    $views = $row['views'];
    $videoad = $row['ad_level'];
    $ads_channel = $row['adsense_video_channel'];

if($count > 1){
    $featured_bar = "<a href='".$conf_site_url."".$conf_site_url."/featured/'><img src='".$conf_site_url."/images/frontpage/featured_bar.png' class='tabs_framed''></a>";
}else{
    $featured_bar = "";
}

// viewers for featured games

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

<title><?=$conf_site_name?></title>
<link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
<link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
<link href="style.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/js/preloadCssImages.js"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.color.js"></script>

<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/general.js"></script>
<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.tools.min.js"></script>
<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/slides.jquery.js"></script>

<link rel="stylesheet" href="<?=$conf_site_url?>/css/prettyPhoto.css" type="text/css" media="screen" />
<script src="<?=$conf_site_url?>/js/jquery.prettyPhoto.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/files/flowplayer-3.2.11.min.js"></script>

<!-- slider -->
<script src="<?=$conf_site_url?>/js/jquery.bxSlider.min.js" type="text/javascript"></script>
<link href="<?=$conf_site_url?>/css/bxSlider.css" media="screen" rel="stylesheet" type="text/css" />
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
error_reporting(0);


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
		<div class="logo"><a href=""><img src="<?=$conf_site_url?>/images/logo.png" alt="" /></a></div>
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
                        <li><a href="<?=$conf_site_url?>/browse/?s=league+of+legends"><span>LoL</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/?s=dota+2"><span>Dota 2</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/?s=Heroes+of+Newerth"><span>HoN</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/?s=Star+Craft+2"><span>SC 2</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/?s=World+Of+Warcraft"><span>WoW</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/callofduty/"><span>Call Of Duty</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/?s=Minecraft"><span>Minecraft</span></a></li>
                        <li><a href="<?=$conf_site_url?>/browse/"><span>Other</span></a></li>
                        <li><a href="<?=$conf_site_url?>/events/"><span>Events</span></a></li>
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
        <div class="page-title"><center><?=$not_logged_in?></center>
        <a href="<?=$conf_site_url?>/user/<?=$channel_id?>"><h2><?=$title?> </h2></a>
                    <center>

                        <a style="display:block;width:960px;height:540px;margin:10px auto" id="stream">
                        </a>
                    </center>
                    <?=$button?>
                    <br>
                    <?php
                    if($count >= 1){
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
                                        publisherId: "<?=$conf_video_ads?>",
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
        <?php
        $viewers_get = mysql_query("SELECT * FROM Games ORDER BY viewers DESC LIMIT 8") or die(mysql_error());
        while($viewers_row = mysql_fetch_array($viewers_get)){
            echo '<div class="col col_1_3">';
            echo '<div class="inner">';
            echo '<center>';
            echo '<a href="'.$conf_site_url.'/browse/?s='.$viewers_row['game'].'" /><h3>'.$viewers_row['game'].'</h3><h5>'.$viewers_row['viewers'].' viewers</b></h5>';
            echo '<div class="inner">';
            echo '<img src="'.$viewers_row['img'].'" class="tabs_framed"/>';
            echo '</a>';
            echo '</center>';
            echo '</div>';
            echo '</div>';
        }
        echo '<div class="col col_1_3">';
        echo '<div class="inner">';
        echo '<center>';
        echo '<a href="'.$conf_site_url.'/browse/" /><h3>Other Games</h3>';
        echo '<img src="'.$conf_site_url.'/images/frontpage/other_normal.png" class="tabs_framed"/>';
        echo '</a>';
        echo '</center>';
        echo '</div>';
        echo '</div>';
        ?>
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
            <?=$conf_site_copy?> <br /><a href="./company/legal/">Terms of Service</a> - <a href="./company/support/">Contact</a> -
		<a href="./company/legal/">Privacy guidelines</a> - <a href="<?=$conf_site_url?>/company/support/">Advertise with Us</a></p>
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
