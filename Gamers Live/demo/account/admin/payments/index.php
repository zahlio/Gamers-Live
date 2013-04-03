<?php
error_reporting(0);


session_start();

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];
$admin = $_SESSION['admin'];

$for_month = date("m/Y", strtotime("-1 month"));


$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");

// connect to database


// select the database we need


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
                <li><a href="<?=$conf_site_url?>/browse/other/?<?=SID; ?>"><span>Other</span></a></li>
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
                <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/admin/?<?=SID; ?>" class="button_link btn_red"><span>Admin CP</span></a><a href="<?=$conf_site_url?>/account/admin/payments/?" class="button_link btn_black"><span>Partner Payments</span></a><a href="<?=$conf_site_url?>/account/admin/config/?" class="button_link btn_red"><span>Site Configurations</span></a><a href="<?=$conf_site_url?>/account/admin/games/?" class="button_link btn_red"><span>Games Management</span></a><a href="<?=$conf_site_url?>/account/admin/support/?" class="button_link btn_red"><span>Support</span></a>
            </center>
            <!-- account menu end -->
            <h1>NEXT Payment Pending</h1>
            <div class="styled_table table_white">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="width:20%">Partner ID</th>
                        <th style="width:20%">Tips Amount</th>
                        <th style="width:20%">Ads Amount</th>
                        <th style="width:20%">Total</th>
                        <th style="width:20%">Total To Pay</th>
                    </tr>
                    </thead>
                    <tbody>
<?php
error_reporting(0);


// we first get all pending payments
$pending_payment = mysql_query("SELECT * FROM partner_payments_to_do WHERE done='0' LIMIT 1") or die(mysql_error());

$row = mysql_fetch_array($pending_payment);
        $partner_id = $row['partner_id'];
        $get_per = mysql_query("SELECT * FROM channels WHERE channel_id='$partner_id'") or die(mysql_error());
        $get_per_row = mysql_fetch_array($get_per);

        $tips_amount = mysql_query("SELECT SUM(amount) as tips_total FROM partner_payments_to_do WHERE done='0' AND partner_id='$partner_id' AND info='tips'") or die(mysql_error());
        $tips_amount_row = mysql_fetch_array($tips_amount);

        $ads_amount = mysql_query("SELECT SUM(amount) as ads_total FROM partner_payments_to_do WHERE done='0' AND partner_id='$partner_id' AND info='ads'") or die(mysql_error());
        $ads_amount_row = mysql_fetch_array($ads_amount);

        $total = $tips_amount_row['tips_total'] + $ads_amount_row['ads_total'] + 0;
        $ads_no = ($ads_amount_row['ads_total'] * ($get_per_row['tip_perc'] / 100));
        $ads =  $ads_no -($ads_no * 0.034) - 0.5;
        $tips_no = ($tips_amount_row['tips_total'] * ($get_per_row['tip_perc'] / 100));
        $tips = $tips_no -($tips_no * 0.034) - 0.5;
        $total_to_pay = $ads + $tips;

        echo '<tr>';
        echo '<td>';
        echo $row['partner_id'];
        echo '</td>';
        echo '<td>';
        echo round($ads, 2) + 0;
        echo ' USD';
        echo '<td>';
        echo round($tips, 2) + 0;
        echo ' USD';
        echo '</td>';
        echo '<td>';
        echo round($total, 2) + 0;
        echo ' USD';
        echo '</td>';
        echo '<td>';
        echo round($total_to_pay, 2) + 0;
        echo ' USD';
        echo '</td>';

        echo '</tr>';

echo '</tbody>
                </table>';

?>


                            <h3>Create Payment</h3>
                            <p>
                            <form name="pay" action="pay.php" method="post" id="loginform" class="loginform">

                    <div class="col col_1_3">
                        <div class="inner">
                                <p><label>Streamer</label><br><input name="streamer" id="streamer" class="gamersTextbox" value="<?=$row['partner_id']?>" type="text" readonly style="width: 200px"></p>
                                <p><label>Receiver Email</label><br><input name="email" id="email" class="gamersTextbox" value="<?=$get_per_row['payment_email']?>" readonly type="text" style="width: 200px"></p>
                        </div></div>

                        <div class="col col_1_3">
                            <div class="inner">
                                <p><label>Ads Amount</label><br><input name="ads" id="ads" class="gamersTextbox" value="<?=round($ads, 2) + 0;?>" readonly type="text" style="width: 200px"></p>
                                <p><label>Tips Amount</label><br><input name="tips" id="tips" class="gamersTextbox" value="<?=round($tips, 2) + 0?>" readonly type="text" style="width: 200px"></p>
                            </div></div>

                        <div class="col col_1_3">
                            <div class="inner">
                                <p><label>Transaction ID</label><br><input name="tran_id" id="tran_id" class="gamersTextbox" value="" type="text" style="width: 200px"></p>
                                <p><label>For Month</label><br><input name="month" id="month" class="gamersTextbox" value="<?=$for_month?>" type="text" style="width: 200px"></p>
                                </div></div>
<center>
                                <a href="#" onclick="document.pay.submit()" class="button_link"><span>Create Payment</span></a>
</center>


                            </form>
                            </p>

                    <div class="clear"></div>
            </div>
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
