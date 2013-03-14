<?php
error_reporting(0);
session_start();
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
include_once("".$conf_site_url."/analyticstracking.php");
if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];
$admin = $_SESSION['admin'];



// select features streamer who is online / active

// select features streamer who is online / active
$result = mysql_query("SELECT * FROM users WHERE email='$email'") or die(mysql_error());
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
$result_channel = mysql_query("SELECT * FROM channels WHERE channel_id='$channel_id'") or die(mysql_error());
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

// change so we dont see this page again

$read = $_GET['r'];

if($read == "true"){
    $update = mysql_query("UPDATE users SET first_time_login='0' WHERE email='$email'") or die(mysql_error());
    header( 'Location: '.$conf_site_url.'/account/' ) ;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$conf_site_name?> - Welcome</title>
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
                    <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/channel/?<?=SID; ?>" class="button_link"><span>Channel</span></a><a href="<?=$conf_site_url?>/account/settings/?<?=SID; ?>" class="button_link"><span>Settings</span></a><a href="<?=$conf_site_url?>/account/partner/?<?=SID; ?>" class="button_link"><span>Partner</span></a><a href="<?=$conf_site_url?>/account/help/?<?=SID; ?>" class="button_link"><span>Support</span></a>
                    <?php if($admin == true){
                    echo "<a href='<?=$conf_site_url?>/account/admin/?' class='button_link btn_red'><span>Admin CP</span></a>";
                    echo "<a href='<?=$conf_site_url?>/account/admin/payments/?' class='button_link btn_red'><span>Partner Payments</span></a>";
                } ?>
                </center>
                <br>
                    <br>
                <h1>Welcome to <?=$conf_site_name?>!</h1>
                <p><img src="<?=$conf_site_url?>/images/welcome/champ_1.jpg" alt="" width="300" height="200" class="frame_right">
                    <br>
                    Thank you for joining the revolution of gaming!<br>
                    Our goal here at <?=$conf_site_name?> is to improve the competitive scene in gaming. We feel this is best done by supporting the PRO gamers and the events that they participate in. But we do not oversee the “up and coming” gamers that are hard at work trying to become PRO.<br><br>
                    Also charity is something we look at with great interest, which is why we are supporting as many charity events as we possibly can.<br><br>
                    Now that we got you signed up and told you our goals with this service, we would like to introduce you to some of the tips and trick of <?=$conf_site_name?>.<br>
                </p>
                <br>
                <center>
                    <img src="<?=$conf_site_url?>/images/hr.png">
                </center>
                <br>
                <h2 align="right">Tip #1: Unleash the games!</h2>
                <p><img src="<?=$conf_site_url?>/images/welcome/play1.png" alt="" width="300" height="200" class="frame_left">
                    <br>
                    There are some items you will need before you can start streaming your games. But if you are not interested in streaming any games and just want to watch others, then you can completely skip this step.<br><br>
                    <b>1.</b> The first item you will need a computer…<br>
                    <b>2.</b> You will also need a video game to stream…<br>
                    <b>3.</b> You will need a streaming software, you can choose one and set it up using our <a href="<?=$conf_support?>" target="_blank">handy guide here</a>.<br><br>
                    That’s basically it! You should now be up and running, and on the way to become the new internet sensation!<br>

                </p>
                <br><br>
                <center>
                    <img src="<?=$conf_site_url?>/images/hr.png">
                </center>
                <br>
                <p>
                    <h2 align="left">Tip #2: Setting up your channel!</h2>
                    You could start streaming now, but how awesome wouldn’t it be to customize your channel?<br>
                    Like creating a custom title, information and images! This is all done easy by using our online interface.<br>
                    If you wish to change your information click <a href="<?=$conf_site_url?>/account/settings/?" target="_blank">here</a>, if you wish to edit your channel click <a href="<?=$conf_site_url?>/account/channel/?" target="_blank">here</a>.<br><br>
                    Should you need more information regarding this, we have a full length help article <a href="<?=$conf_support?>" target="_blank">right here</a> for you!<br>

                </p>
                <br><br>
                <center>
                    <img src="<?=$conf_site_url?>/images/hr.png">
                </center>
                <br>
                <h2 align="right">Tip #3: Manage your chat from trolls!</h2>
                <p><img src="<?=$conf_site_url?>/images/welcome/troll.png" alt="" width="300" height="200" class="frame_left">
                    Once you started streaming and you gain a viewer base, trolls and fan boys will start coming into your chat. Some can be fun and interesting to talk to, while others should be removed from the chat. Of cause <?=$conf_site_name?> has a system for this which we call: “Manage Your Chat (system-ish)” clever right?<br><br>
                    So should you ever feel the need to ban a member from the chat, just click on the name in the chat window and you will be prompted to ban this user, should you have the authority to do so. You can also access this tool at your <a href="<?=$conf_site_url?>/account/channel/?" target="_blank">channel page</a>.<br>
                    Additionally you can add other moderators which can moderate your chat and ban users.<br><br>
                    Should you need more information, <a href="<?=$conf_support?>" target="_blank">then get over here.</a><br>
                </p>
                <br><br>
                <center>
                    <img src="<?=$conf_site_url?>/images/hr.png">
                </center>
                <br>

                <p><img src="<?=$conf_site_url?>/images/welcome/help.png" alt="" width="300" height="200" class="frame_right">
                <p>
                <h2 align="left">Tip #4: PLZ READ HELP ARTICLES</h2>
                    Help articles is where you will find everything you need, and should these articles not be enough then our support team is more than happy to assist you!<br><br>
                    You can find our help articles <a href="<?=$conf_support?>" target="_blank">here</a> and should you need to submit a ticket, then it can be done <a href="<?=$conf_support?>" target="_blank">here</a>.<br>
                </p>
                <br><br>
                <center>
                    <img src="<?=$conf_site_url?>/images/hr.png">
<br><br>
                <b>Have your read everything? And most important, did you understand everything?</b><br><br>
                <a href="?r=true" class="button_link btn_green"><span>Yes i did, and i don't need to see this message again!</span></a> <a href="welcome.php" class="button_link btn_red"><span>No i did not, please enlighten me again!</span></a>
                </center>
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
