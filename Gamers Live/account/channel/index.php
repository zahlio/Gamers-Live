<?php
session_start();

error_reporting(0);
include_once("".$conf_site_url."/analyticstracking.php");
if ($_SESSION['access'] != true) {
	header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];

// get all user details from this account
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

$msg = $_GET["msg"];
			
// connect to database


// select thje database we need
	

// get channel info
$result_channel = mysql_query("SELECT * FROM channels WHERE channel_id='$channel_id'");
$row_channel = mysql_fetch_array($result_channel);

$server_rtmp = $row_channel['server_rtmp'];
$game = $row_channel['game'];
$stream_key = $row_channel['stream_key'];
$title = $row_channel['title'];
$views = $row_channel['views'];
$title = $row_channel['title'];
$info1 = $row_channel['info1'];
$info2 = $row_channel['info2'];
$info3 = $row_channel['info3'];
$subscribers = $row_channel['subscribers'];
$viewers = $row_channel['viewers'];
					
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title>GAMERS LIVE</title>
<link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/js/preloadCssImages.js"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.color.js"></script>

<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/general.js"></script>
<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.tools.min.js"></script>
<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/slides.jquery.js"></script>
<script type="text/javascript" src="<?=$conf_site_url?>/files/flowplayer-3.2.11.min.js"></script>

    <script type="text/javascript">
        function getViewers(){
            msgUpdate = setInterval(getViewers, 90000);

            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp_send=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp_send=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp_send.onreadystatechange=function()
            {
                if (xmlhttp_send.readyState==4 && xmlhttp_send.status==200)
                {
                    document.getElementById('viewers').innerHTML=xmlhttp_send.responseText;
                }
            }
            xmlhttp_send.open("GET","<?=$conf_site_url?>/account/channel/get_viewers.php?channel=<?=$channel_id?>", true);
            xmlhttp_send.send();

        }
    </script>

<link rel="stylesheet" href="<?=$conf_site_url?>/css/prettyPhoto.css" type="text/css" media="screen" />
<script src="<?=$conf_site_url?>/js/jquery.prettyPhoto.js" type="text/javascript"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="<?=$conf_site_url?>css/ie.css" />
<![endif]-->
    <script type="text/javascript">
        function popchat(url) {
            popupWindow = window.open(
                    url,'popUpWindow','height=700,width=400left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
        }
    </script>
</head>

<body onload="getViewers()">
<div class="body_wrap thinpage">

<div class="header_image" style="background-image:url(<?=$conf_site_url?>/images/header.png)">&nbsp;</div>

<div class="header_menu">
	<div class="container">
		<div class="logo"><a href="<?=$conf_site_url?>/"><img src="<?=$conf_site_url?>/images/logo.png" alt="" /></a></div>
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
                        <li><a href="<?=$conf_site_url?>/blog/"><span>Blog</span></a></li>
                        <li><a href="#"><span>More</span></a>                        
                        	<ul>
                                <li><a href="<?=$conf_site_url?>/company/about/"><span>About</span></a></li>
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
    <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/channel/?<?=SID; ?>" class="button_link btn_black"><span>Channel</span></a><a href="<?=$conf_site_url?>/account/settings/?<?=SID; ?>" class="button_link"><span>Settings</span></a><a href="<?=$conf_site_url?>/account/partner/?<?=SID; ?>" class="button_link"><span>Partner</span></a><a href="<?=$conf_site_url?>/account/help/?<?=SID; ?>" class="button_link"><span>Support</span></a>
    </center>    
    <!-- account menu end -->
    <div class="quoteBox2">
		<div class="quote-text"><?=$msg?></div>               	
    </div>
    <div class="col col_1_2 ">
        <div class="inner">
        <h3>Stream Information</h3>
        <div class="sb">
            <div class="box_title">Title</div>
            <div class="box_content">
        <form name="title" action="update.php?msg=title" method="post">
            <input name="value" id="value" class="gamersTextbox" value="<?=$title?>" type="text" maxlength="50" style="width: 310px;height: 30px">
            <a href="#" onclick="document.title.submit()" class="button_link"><span>Update</span></a>
        </form>
                        <div class="clear"></div>
            </div>
        </div>
        
        <div class="sb">
            <div class="box_title">Game <i>(Current is <?=$game?>)</i></div>
            <div class="box_content"> 
        <form name="game" action="update.php?msg=game" method="post">
            <select name="value" style="width: 310px">
            <option value="Other" id="value">Other</option>
            <option value="League Of Legends" id="value">League Of Legends</option>
            <option value="Dota 2" id="value">Dota 2</option>
            <option value="Heroes Of Newerth" id="value">Heroes Of Newerth</option>
            <option value="Starcraft 2" id="value">Starcraft 2</option>
            <option value="World Of Warcraft" id="value">World Of Warcraft</option>
            <option value="Call Of Duty" id="value">Call Of Duty</option>
            <option value="Minecraft" id="value">Minecraft</option>
            </select>
            <a href="#" onclick="document.game.submit()" class="button_link"><span>Update</span></a>
        </form>
                                <div class="clear"></div>
            </div>
        </div>
        <div class="sb">
            <div class="box_title">Total Views</div>
            <div class="box_content">
                <?=$views?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="sb">
            <div class="box_title">Total Viewers</div>
            <div class="box_content">
                    <div id="viewers">

                    </div>
                <div class="clear"></div>
            </div>
        </div>
    	</div>
    </div>
    <div class="col col_1_2 "
    	<div class="inner">

            <br>
			<a  
                    style="display:block;width:480px;height:270px;margin:10px auto"
                    id="stream">
                    </a>
                    <script type="text/javascript">
						flowplayer("stream", "<?=$conf_site_url?>/files/flowplayer-3.2.15.swf",
							{
								clip: {
									url: '<?=$channel_id?>',
									live: true,
									provider: 'rtmp',
								},
								plugins: {
									
									controls: {
										url: "<?=$conf_site_url?>/files/flowplayer.controls-3.2.14.swf",
										autoHide: "never"
									},
									rtmp: {
									url: '<?=$conf_site_url?>/files/flowplayer.rtmp-3.2.11.swf',
									netConnectionUrl: '<?=$server_rtmp?><?=$channel_id?>'
									}
								}		
							}
						);
					</script>
                    <i>NOTE: Remember to mute, or there will be an echo in the stream.</i>
            <br><br>
            <a href="<?=$conf_site_url?>/account/channel/chat/ban.php?channel=<?=$channel_id?>" class="button_link"><span>Manage your chat</span></a>
            <a href="?status=<?=$status?>&chat=false" onclick="JavaScript:popchat('<?=$conf_site_url?>/chat/?channel=<?=$channel_id?>');"" class="button_link"><span>Windowed Chat</span></a>
            <a href="<?=$conf_site_url?>/user/<?=$channel_id?>" class="button_link"><span>View channel</span></a>
        </div>
    </div>
	
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
    	<h3>Gamers Live</h3>   
		
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
