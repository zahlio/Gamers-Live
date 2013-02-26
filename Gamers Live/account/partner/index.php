<?php
session_start();

if ($_SESSION['access'] != true) {
	header( 'Location: partner.php' ) ;	
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
$ads = $row_channel['ads'];
$donate = $row_channel['donate'];
$tip_perc = $row_channel['tip_perc'];
$partner_id = "".$row_channel['id']."-".$channel_id."";
$featured = $row_channel['featured'];
$feature_level = $row_channel['feature_level'];
$ad_level = $row_channel['ad_level'];
$payment_email = $row_channel['payment_email'];
$payment_gateway = $row_channel['payment_gateway'];
$feature_img = $row_channel['feature_img'];

// get payments for this account
$result_pay = mysql_query("SELECT * FROM partner_payments WHERE partner_channel_id='$channel_id' ORDER BY id DESC") or die(mysql_error());

// get totals for this user
$result_ads_total = mysql_query("SELECT SUM(ads_amount) FROM partner_payments WHERE partner_channel_id='$channel_id'") or die(mysql_error());
$total_ads = mysql_fetch_array($result_ads_total);

$result_tips_total = mysql_query("SELECT SUM(tips_amount) FROM partner_payments WHERE partner_channel_id='$channel_id'") or die(mysql_error());
$total_tips = mysql_fetch_array($result_tips_total);

if($partner == "0"){
// then we reditct
	header( 'Location: partner.php' ) ;	
	exit;	
}
					
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
    </center>    
    <!-- account menu end -->
    <h1>Welcome to the partner panel</h1>
    			<div class="sb">
                    <div class="box_title">Partner Agreement</div>
                        <div class="box_content">
							<p>You are currently recieving: <?=$tip_perc?>% of the revenue generated by ads / tips on your channel.</p>
                            <p>You are currently recieving: <?=$tip_perc - 20?>% of the revenue generated by video ads. (Our partner takes 20 % of all video ad revenue)</p>
                        <div class="clear"></div>
                    </div>
                </div>
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
                             <form action="update.php?msg=ads" method="post">
                                <select name="value">
                                <option value="1" id="value">Enable</option>
                                <option value="0" id="value">Disable</option>
                                </select>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                            
                     <b>Video Ads:</b> 
                             <form action="update.php?msg=video_ads" method="post">
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
                             <form action="update.php?msg=tips" method="post">
                                <select name="value">
                                <option value="1" id="value">Enable</option>
                                <option value="0" id="value">Disable</option>
                                </select>
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                    <b>Featured Image URL (is only showed in a 16:9 aspect ratio) <a href="javascript:window.open('<?=$feature_img?>','mywindowtitle','width=1280,height=720')"><i>LINK</i></a>:</b>
                    <form action="update.php?msg=feature_img" method="post">
                        <input name="value" id="value" class="input" value="<?=$feature_img?>" size="40" type="text">
                        <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                    </form>
                            
                     <b>Payment Email:</b> 
                             <form action="update.php?msg=pay_email" method="post">
                                <input name="value" id="value" class="input" value="<?=$payment_email?>" size="40" type="text" maxlength="30">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button_link" value="Update" tabindex="100">
                            </form>
                     <b>Payment Gateway:</b> 
                             <form action="update.php?msg=pay_gateway" method="post">
                                <select name="value">
                                <option value="payza" id="value">Payza</option>
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
                                        echo "<td>" . $row_pay['to_email'] . "</td>";
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
								</div><p><b>NOTE:</b> Payment are usually send between the 14'th and 20'th in the following month. So an examble would be: Payments for 1/2055 will first arrive on the 14-20/02/2055. This is to make sure that purchases made at the end of a month has the full 14 days refund period, and we dont need to charge our partners if a possible refund should happen. Also for administration purposes we do ADS and TIPS payouts at the same time.</p>
                    </div>
                    
                    <div class="sb">
                    <div class="box_title">Partner Support</div>
                        <div class="box_content">
							<p>Should you need support or any settings changed, then please contact support by creating a ticket in "Partner Support" with the subject of: <br /><center><h2><?=$partner_id?>: [YOUR SUBJECT]</h2></center></p><p><i>Delete the []'s. An example would be: "1-zahlio: I wish to change my payment email"</i></p>
                            Link to support: <a href="https://gamerslive.zendesk.com/anonymous_requests/new">Click here to create a ticket</a>
                        <div class="clear"></div>
                    </div>
                </div>
</div>
    </div>
    <!--/ content --> 
    
   
    <div class="clear"></div>
    
</div>
</div>
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
