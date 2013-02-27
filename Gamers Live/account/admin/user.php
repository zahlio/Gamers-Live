<?php
session_start();

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
	header( 'Location: http://www.gamers-live.net/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$admin = $_SESSION['admin'];

$client_to_edit = $_GET['channel'];
$channel_id = $client_to_edit;

// get all user details from this account
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";
			
// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

// first we need to the get email of the channel id

$get_email = mysql_query("SELECT * FROM users WHERE channel_id='$client_to_edit'");
$get_email_row = mysql_fetch_array($get_email);
$email = $get_email_row['email'];
	
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
$banned = $row_channel['banned'];
$ads = $row_channel['ads'];
$donate = $row_channel['donate'];
$tip_perc = $row_channel['tip_perc'];
$partner_id = "".$row_channel['id']."-".$channel_id."";
$featured = $row_channel['featured'];
$feature_level = $row_channel['feature_level'];
$ad_level = $row_channel['ad_level'];
$feature_level = $row_channel['feature_level'];
$payment_email = $row_channel['payment_email'];
$payment_gateway = $row_channel['payment_gateway'];
$featured_img = $row_channel['feature_img'];

// get payments for this account
$result_pay = mysql_query("SELECT * FROM partner_payments WHERE partner_channel_id='$channel_id' ORDER BY id DESC") or die(mysql_error());

// get totals for this user
$result_ads_total = mysql_query("SELECT SUM(ads_amount) FROM partner_payments WHERE partner_channel_id='$channel_id'") or die(mysql_error());
$total_ads = mysql_fetch_array($result_ads_total);

$result_tips_total = mysql_query("SELECT SUM(tips_amount) FROM partner_payments WHERE partner_channel_id='$channel_id'") or die(mysql_error());
$total_tips = mysql_fetch_array($result_tips_total);
					
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
    <div class="content"><br />  
        <!-- account menu -->
    <center>
    <a href="http://www.gamers-live.net/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="http://www.gamers-live.net/account/channel/?<?=SID; ?>" class="button_link"><span>Channel</span></a><a href="http://www.gamers-live.net/account/settings/?<?=SID; ?>" class="button_link"><span>Settings</span></a><a href="http://www.gamers-live.net/account/partner/?<?=SID; ?>" class="button_link"><span>Partner</span></a><a href="http://www.gamers-live.net/account/help/?<?=SID; ?>" class="button_link"><span>Support</span></a>
	<?php if($admin == true){ 
	echo "<a href='http://www.gamers-live.net/account/admin/?' class='button_link btn_red'><span>Admin CP</span></a>";
	} ?>
    </center>    
    <!-- account menu end -->
    <!--/ content --> 
    <h3>Viewing: <?=$client_to_edit?></h3>
    <?php
	if($banned == 1){
		// then user is banned and we can unban him
        echo '<a href="update.php?msg=ban&email='.$email.'&channel_id='.$channel_id.'&value=0" class="button_link btn_green"><span>UnBan Member</span></a>';
	}else{
		// he is not banend and we will ban him	
        echo '<a href="update.php?msg=ban&email='.$email.'&channel_id='.$channel_id.'&value=1" class="button_link btn_red"><span>Ban Member</span></a>';
	}

	if($partner == 1){
		// then user is banned and we can unban him
	echo '<a href="update.php?msg=partner&email='.$email.'&channel_id='.$channel_id.'&value=0" class="button_link btn_red"><span>Delete Partner</span></a>';
	}else{
		// he is not banend and we will ban him	
        echo '<a href="update.php?msg=partner&email='.$email.'&channel_id='.$channel_id.'&value=1" class="button_link btn_green"><span>Make Partner</span></a>';
	}

    if($featured == 1){
        // then user is banned and we can unban him
        echo '<a href="p_update.php?msg=featured&email='.$email.'&channel_id='.$channel_id.'&value=0" class="button_link btn_red"><span>Delete Featured</span></a>';
        // if we are featured then we must have a featured level where 0 is the smallest and 999 is the highest
        echo '<form action="p_update.php?msg=feature_level&email='.$email.'&channel_id='.$channel_id.'" method="post">Featured Level (0-999):
            <input name="value" id="value" class="input" value="'.$feature_level.'" size="3" type="text" maxlength="3">
            <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
        </form>';
    }else{
        // he is not banend and we will ban him
        echo '<a href="p_update.php?msg=featured&email='.$email.'&channel_id='.$channel_id.'&value=1" class="button_link btn_green"><span>Make Featured</span></a>';
    }
	
	?>
    <h3 class="toggle box">Partner Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                         <strong>Advertisement</strong>
                         <?php if($ads == "1"){echo "Currently enabled";}else{echo "Currently disabled";} ?> on your channel.<br />
                         <strong>Video Ads</strong>
						 <?php 
						 	if($ad_level == "none"){echo "You are currently not displaying video ads.";}
							if($ad_level == "low"){echo "You are currently displaying a preroll. Defaults to an overlay if no preroll is returned.";}
							if($ad_level == "medium"){echo "You are currently displaying a preroll and an overlay at 10 seconds.";}
							if($ad_level == "high"){echo "You are currently displaying a preroll and an overlay at 10 seconds. Shows a midroll + overlay every 7 minutes.";}
							if($ad_level == "insane"){echo "You are currently displaying a preroll and an overlay at 10 seconds. Shows a midroll + overlay every 3 minutes.";}
						 
						 ?><br />
                         <strong>Tips</strong>
						 <?php if($donate == "1"){echo "Currently enabled";}else{echo "Currently disabled";} ?> on your channel.<br />
                         <strong>Frontpage Stream Featuring</strong>
						 <?php if($featured == "1"){echo "You are currently featured on the frontpage.";}else{echo "You are currently NOT featured on the frontpage.";} ?><br />
                         <strong>Payment Email</strong>
                         <?=$payment_email?><br />
                         <strong>Payment Gateway</strong>
                         <?=$payment_gateway?><br />
                         <i>Note that if the payment email is not valid for the payment gateway specified, the transaction will be lost and you will NOT recieve the payment!</i>
                         
                    </div>
                    
                <h3 class="toggle box">Update Settings<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                    <b>Advertisement:</b> 
                             <form action="p_update.php?msg=ads&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
                                <select name="value">
                                <option value="1" id="value">Enable</option>
                                <option value="0" id="value">Disable</option>
                                </select>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                            
                     <b>Video Ads:</b> 
                             <form action="p_update.php?msg=video_ads&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
                                <select name="value">
                                <option value="none" id="value">No Video Ads</option>
                                <option value="low" id="value">Display a preroll. Defaults to an overlay if no preroll is returned.</option>
                                <option value="medium" id="value">Display a preroll and an overlay at 10 seconds</option>
                                <option value="high" id="value">Display a preroll and an overlay at 10 seconds. Shows a midroll + overlay every 7 minutes.</option>
                                <option value="insane" id="value">Display a preroll and an overlay at 10 seconds. Shows a midroll + overlay every 3 minutes.</option>
                                </select>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                     <b>Tips:</b> 
                             <form action="p_update.php?msg=tips&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
                                <select name="value">
                                <option value="1" id="value">Enable</option>
                                <option value="0" id="value">Disable</option>
                                </select>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>

                    <b>Featured IMG <a href="javascript:window.open('<?=$featured_img?>','mywindowtitle','width=1280,height=720')">LINK</a></b>
                            <form action="p_update.php?msg=featured_img&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
                                <input name="value" id="value" class="input" value="<?=$featured_img?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                     <b>Payment Email:</b> 
                             <form action="p_update.php?msg=pay_email&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
                                <input name="value" id="value" class="input" value="<?=$payment_email?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                     <b>Payment Gateway:</b> 
                             <form action="p_update.php?msg=pay_gateway&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
                                <select name="value">
                                <option value="payza" id="value">Payza</option>
                                <option value="moneybookers" id="value">Moneybookers</option>
                                </select>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                            <i>Note that if the payment email is not valid for the payment gateway specified, the transaction will be lost and you will NOT recieve the payment!</i>
                    </div>
                    
                <h3 class="toggle box">Payments<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
							    <div class="styled_table table_white"/>
									<?php
                                    echo "<table width='100%' cellpadding='0' cellspacing='0'>
                                    <tbody>
                                    <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>ADS Amount</th>
                                        <th>TIPS Amount</th>
                                        <th>Transaction ID</th>
                                        <th>Send Date</th>
										<th>Send to email</th>
                                    </tr>
                                    </thead>";
                                    
                                    while($row_pay = mysql_fetch_array($result_pay))
                                    {
                                        echo "<tr>";
                                        echo "<td>" . $row_pay['for_month'] . "</td>";
                                        echo "<td>" . $row_pay['ads_amount'] . " $</td>";
                                        echo "<td>" . $row_pay['tips_amount'] . " $</td>";
                                        echo "<td>" . $row_pay['skrill_trans_id'] . "</td>";
                                        echo "<td>" . $row_pay['send_date'] . "</td>";
                                        echo "<td><a href='mailto:" . $row_pay['to_email'] . "?Subject=Regarding Payment " . $row_pay['skrill_trans_id'] . "&body=Hello " . $row_pay['partner_channel_id'] . ", We are contacting you regarding the partner payment made on the " . $row_pay['send_date'] . " for the month: " . $row_pay['for_month'] . " with the following amount: " . $row_pay['ads_amount'] . " USD + " . $row_pay['tips_amount'] . " USD.'>" . $row_pay['to_email'] . "</td>";
                                        echo "</tr>";
                                    }
										echo "<tr>";
                                        echo "<td><b>Total</b></td>";
                                        echo "<td><b>" . $total_ads[0] . " $</b></td>";
                                        echo "<td><b>" . $total_tips[0] . " $</b></td>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                        echo "</tr>";
                                        echo "<tbody>
                                        </table>";
                                    ?>
								</div><p><b>NOTE:</b> Payment are usually send between the 14'th and 20'th in the following month. So an example would be: Payments for 1/2055 will first arrive on the 14-20/02/2055. This is to make sure that purchases made at the end of a month has the full 14 days refund period, and we dont need to charge our partners if a possible refund should happen. Also for administration purposes we do ADS and TIPS payouts at the same time.</p>
                    </div>
    <br />
<div class="col col_1_2 ">
                <div class="inner">
                <h1>User Settings</h1>
                <div class="sb">
                    <div class="box_title">Display name</div>
                        <div class="box_content">
                            <form action="update.php?msg=display_name&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
								<input name="value" id="value" class="input" value="<?=$display_name?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                        <div class="clear"></div>
                    </div>
                </div>
				<div class="sb">
                    <div class="box_title">Email</div>
                        <div class="box_content">
                       		<a href="mailto:<?=$email?>"><?=$email?></a>
                        <div class="clear"></div>
                    </div>
                </div>
                <h3 class="toggle box">Password<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                            <form action="update.php?msg=password&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
								<input name="value" id="value" class="input" value="<?=$password?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                    </div>
                </div>
                <h3 class="toggle box">Short bio<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                         <form action="update.php?msg=short_bio&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="200"><?=$short_bio?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 200 characters</i>
                    </div>
                <h3 class="toggle box">Long Bio<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                            <form action="update.php?msg=long_bio&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
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
                            <form action="update.php?msg=game&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
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
                       		<form action="update.php?msg=title&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
								<input name="value" id="value" class="input" value="<?=$title?>" size="40" type="text" maxlength="50">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                        <div class="clear"></div>
                    </div>
                </div>
                <h3 class="toggle box">Stream Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                            <form action="update.php?msg=info1&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="2500"><?=$info1?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 2500 characters</i>
                    </div>
                                    <h3 class="toggle box">Streamer Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                                                     <form action="update.php?msg=info2&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
								<textarea name="value" id="value" class="input" cols="25" rows="5" maxlength="2500"><?=$info2?></textarea>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                         	</form>
                            <i>Max length is 2500 characters</i>
                    </div>
                                    <h3 class="toggle box">Additional Information<span class="ico"></span></h3>
                    <div class="toggle_content boxed" style="display: none;">
                                                     <form action="update.php?msg=info3&email=<?=$email?>&channel_id=<?=$channel_id?>" method="post">
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
