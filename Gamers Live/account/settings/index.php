<?php
session_start();


if ($_SESSION['access'] != true) {
	header( 'Location: http://www.gamers-live.net/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];

// get all user details from this account
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";
			
// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());
			
// select features streamer who is online / active
$result = mysql_query("SELECT * FROM users WHERE email='$email'");
$row = mysql_fetch_array($result);

$display_name = $row['display_name'];
$password = $row['password'];
$avatar = $row['avatar'];
$short_bio = $row['short_bio'];
$long_bio = $row['long_bio'];
$timezone = $row['timezone'];
$partner = $row['partner'];
$reg_date = $row['reg_date'];

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
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title>GAMERS LIVE</title>
<link href="http://www.gamers-live.net/style.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://www.gamers-live.net/js/jquery.min.js"></script>
<script type="text/javascript" src="http://www.gamers-live.net/js/preloadCssImages.js"></script>
<script type="text/javascript" src="http://www.gamers-live.net/js/jquery.color.js"></script>

<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/general.js"></script>
<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/jquery.tools.min.js"></script>
<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/slides.jquery.js"></script>

<link rel="stylesheet" href="http://www.gamers-live.net/css/prettyPhoto.css" type="text/css" media="screen" />
<script src="http://www.gamers-live.net/js/jquery.prettyPhoto.js" type="text/javascript"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]-->
</head>

<body>
<div class="body_wrap thinpage">

<div class="header_image" style="background-image:url(http://www.gamers-live.net/images/header.png)">&nbsp;</div>

<div class="header_menu">
	<div class="container">
		<div class="logo"><a href="http://www.gamers-live.net/account/?<?=SID; ?>"><img src="http://www.gamers-live.net/images/logo.png" alt="" /></a></div>
        <div class="top_login_box"><a href="http://www.gamers-live.net/account/logout/?<?=SID; ?>">Logout</a><a href="http://www.gamers-live.net/account/settings/?<?=SID; ?>">Settings</a></div>
                <div class="top_search">
        	<form id="searchForm" action="http://www.gamers-live.net/browse/" method="get">
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
                        <li><a href="http://www.gamers-live.net/browse/lol/?<?=SID; ?>"><span>LoL</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/dota2/?<?=SID; ?>"><span>Dota 2</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/hon/?<?=SID; ?>"><span>HoN</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/sc2/?<?=SID; ?>"><span>SC 2</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/wow/?<?=SID; ?>"><span>WoW</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/callofduty/?<?=SID; ?>"><span>Call Of Duty</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/minecraft/?<?=SID; ?>"><span>Minecraft</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/other/?<?=SID; ?>"><span>Others</span></a></li>
                        <li><a href="http://www.gamers-live.net/blog/"><span>Blog</span></a></li>
                        <li><a href="#"><span>More</span></a>                        
                        	<ul>
                                <li><a href="http://www.gamers-live.net/company/about/"><span>About</span></a></li>
                                <li><a href="http://www.gamers-live.net/company/support/"><span>Contact</span></a></li>
                                <li><a href="http://www.gamers-live.net/account/partner/?<?=SID; ?>"><span>Partner</span></a></li>
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
		<a href="http://www.gamers-live.net/account/?"<? SID;?><span>Home</span></a>
        </div>
    </div> 	 
   
    
    <!-- content -->
    <div class="content">
    <br />
    <!-- account menu -->
    <center>
    <a href="http://www.gamers-live.net/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="http://www.gamers-live.net/account/channel/?<?=SID; ?>" class="button_link"><span>Channel</span></a><a href="http://www.gamers-live.net/account/settings/?<?=SID; ?>" class="button_link"><span>Settings</span></a><a href="http://www.gamers-live.net/account/partner/?<?=SID; ?>" class="button_link"><span>Partner</span></a><a href="http://www.gamers-live.net/account/help/?<?=SID; ?>" class="button_link"><span>Support</span></a>
    </center>    
    <!-- account menu end -->
    <br />
       <div class="col col_1_2 ">
                <div class="inner">
                <h1>User Settings</h1>
                <div class="sb">
                    <div class="box_title">Display name</div>
                        <div class="box_content">
                            <form action="update.php?msg=display_name" method="post">
								<input name="value" id="value" class="input" value="<?=$display_name?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                        <div class="clear"></div>
                    </div>
                </div>
				<div class="sb">
                    <div class="box_title">Email</div>
                        <div class="box_content">
                       		<?=$email?>
                        <div class="clear"></div>
                    </div>
                </div>
                <h3 class="toggle box">Password<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                            <form action="update.php?msg=password" method="post">
								<input name="value" id="value" class="input" value="<?=$password?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                    </div>
                </div>
                <h3 class="toggle box">Short bio<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                         <form action="update.php?msg=short_bio" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="200"><?=$short_bio?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 200 characters</i>
                    </div>
                <h3 class="toggle box">Long Bio<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                            <form action="update.php?msg=long_bio" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="2500"><?=$long_bio?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 2500 characters</i>
                    </div>
    	</div>
        <div class="col col_1_2 ">
                <div class="inner">
                <h1>Channel Settings</h1>
                 <div class="sb">
                    <div class="box_title">Channel name</div>
                        <div class="box_content">
                       		<?=$channel_id?>
                        <div class="clear"></div>
                    </div>
                </div>
                 <div class="sb">
                    <div class="box_title">Game</div>
                        <div class="box_content">
                       		<?=$game?>
                            <form action="update.php?msg=game" method="post">
                            <select name="value">
							<option value="Other" id="value">Other</option>
							<option value="League Of Legends" id="value">League Of Legends</option>
                            <option value="Dota 2" id="value">Dota 2</option>
                            <option value="Heroes Of Newerth" id="value">Heroes Of Newerth</option>
                            <option value="Starcraft 2" id="value">Starcraft 2</option>
                            <option value="World Of Warcraft" id="value">World Of Warcraft</option>
                            <option value="Call Of Duty" id="value">Call Of Duty</option>
                            <option value="Minecraft" id="value">Minecraft</option>
							</select>
                            <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                        <div class="clear"></div>
                    </div>
                </div>
                    <h3 class="toggle box">Stream key<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                         <h2>xSplit:</h2>
						 <strong>RTMP URL: </strong><?=$server_rtmp?><?=$channel_id?>/?streamKey=<?=$stream_key?><br />
                         <strong>Stream Name:</strong> <?=$channel_id?><br /><br />
                         <h2>FFSplit:</h2>
						 <strong>RTMP URL:</strong> <?=$server_rtmp?><?=$channel_id?>/?streamKey=<?=$stream_key?>/<?=$channel_id?>
                    </div>

                <div class="sb">
                    <div class="box_title">Stream Title</div>
                        <div class="box_content">
                       		<form action="update.php?msg=title" method="post">
								<input name="value" id="value" class="input" value="<?=$title?>" size="40" type="text" maxlength="50">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                        <div class="clear"></div>
                    </div>
                </div>
                <h3 class="toggle box">Stream Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                            <form action="update.php?msg=info1" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="2500"><?=$info1?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 2500 characters</i>
                    </div>
                                    <h3 class="toggle box">Streamer Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                                                     <form action="update.php?msg=info2" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="2500"><?=$info2?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 2500 characters</i>
                    </div>
                                    <h3 class="toggle box">Additional Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                                                     <form action="update.php?msg=info3" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="2500"><?=$info3?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 2500 characters</i>
                    </div>                    
                    <div class="sb">
                    <div class="box_title">Total Views</div>
                        <div class="box_content">
                       		<?=$views?>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="sb">
                    <div class="box_title">Total Subscribers</div>
                        <div class="box_content">
                       		<?=$subscribers?>
                        <div class="clear"></div>
                    </div>
                </div>    
                                <h3 class="toggle box">Upload Images<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
					<form action="upload_file.php?id=avatar" method="post"
                    enctype="multipart/form-data">
                    <label for="file">Avatar (50x50):</label>
                    <input type="file" name="file" id="file"><br>
                    <input type="submit" name="submit" value="Submit">
                    </form>
                    <br />
                    <form action="upload_file.php?id=offline_img" method="post"
                    enctype="multipart/form-data">
                    <label for="file">Offline img (1280x720):</label>
                    <input type="file" name="file" id="file"><br>
                    <input type="submit" name="submit" value="Submit">
                    </form>
                    <br />
                    <form action="upload_file.php?id=header" method="post"
                    enctype="multipart/form-data">
                    <label for="file">Header img (1920x200):</label>
                    <input type="file" name="file" id="file"><br>
                    <input type="submit" name="submit" value="Submit">
                    </form>
                    <br />
                    <i>All files must be .PNG and less then 1mb</i>
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
    	<h3>Hostse.net</h3>   
		
        <div class="copyright">
		&copy; 2013 GAMERS LIVE. An Hostse.net production. All Rights Reserved. <br /><a href="http://www.gamers-live.net/company/legal/">Terms of Service</a> - <a href="http://www.gamers-live.net/company/support/">Contact</a> -
		<a href="http://www.gamers-live.net/company/legal/">Privacy guidelines</a> - <a href="http://www.gamers-live.net/company/support/">Advertise with Us</a> - <a href="http://www.gamers-live.net/company/about/">About Us</a></p>
		</div>          
    </div>
    
    <div class="grid_4">
    	<h3>Follow us</h3>
        <div class="footer_social">
        	<a href="http://www.gamers-live.net/facebook/" class="icon-facebook">Facebook</a> 
            <a href="http://www.gamers-live.net/twitter/" class="icon-twitter">Twitter</a>
            <a href="http://www.gamers-live.net/rss/" class="icon-rss">RSS</a>
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