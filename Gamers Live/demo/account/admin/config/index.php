<?php
error_reporting(0);


session_start();

include_once("../../../config.php");
include_once("../../../analyticstracking.php");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];
$admin = $_SESSION['admin'];
$error = $_GET['error'];

?>
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

    <script type="text/javascript">
        // Popup window code
        function newPopup(url) {
            popupWindow = window.open(
                url,'popUpWindow','height=700,width=1200,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
        }
    </script>

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
                    <li><a href="<?=$conf_site_url?>/browse/?s=league+of+legends"><span>LoL</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=dota+2"><span>Dota 2</span></a></li></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Heroes+of+Newerth"><span>HoN</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Star+Craft+2"><span>SC 2</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=World+Of+Warcraft"><span>WoW</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Call+Of+Duty"><span>Call Of Duty</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Minecraft"><span>Minecraft</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/"><span>Other</span></a></li>
                    <li><a href="<?=$conf_site_url?>/events/"><span>Events</span></a></li>
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
                    <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/admin/?<?=SID; ?>" class="button_link btn_red"><span>Admin CP</span></a><a href="<?=$conf_site_url?>/account/admin/payments/?" class="button_link btn_red"><span>Partner Payments</span></a><a href="<?=$conf_site_url?>/account/admin/config/?" class="button_link btn_black"><span>Site Configurations</span></a><a href="<?=$conf_site_url?>/account/admin/games/?" class="button_link btn_red"><span>Games Management</span></a><a href="<?=$conf_site_url?>/account/admin/support/?" class="button_link btn_red"><span>Support</span></a>
                </center>
                <!-- account menu end -->
                <?php
error_reporting(0);


                if($error != null){
                    echo "<br>";
                    echo "<center><h3>";
                    echo $error;
                    echo "</h3></center>";
                    echo "<br>";
                }
                ?>
                <h1>Site Configurations</h1>
                <br>
                <p>
                    <b>Site Name:</b> <?=$conf_site_name?><br>
                    <b>Site URL:</b> <?=$conf_site_url?><br>
                    <b>Site RTMP:</b> <?=$conf_site_rtmp?><br>
                    <b>Paypal Email:</b> <?=$conf_store_paypal_email?><br>
                    <i>If you would like to chance some of these values, please run the installation again <a href="http://www.gamers-live.net/installer/">here</a>.</i>
                </p>
                <h3>Make User Admin</h3>
                <form name="createAdmin" action="createAdmin.php" method="post" id="loginform" class="loginform">

                    <p><label>Username</label><br><input name="username" id="username" class="gamersTextbox" value="" size="20" tabindex="10" type="text" style="width: 250px; height: 30px">
                    <a href="#" onclick="document.createAdmin.submit()" id="login_but" class="button_link"><span>Make Admin</span></a></p>

                </form>
                <i><a href="JavaScript:newPopup('list.php');">List admins / remove admins</a></i>
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
