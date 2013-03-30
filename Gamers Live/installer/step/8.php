<?php
error_reporting(0);
session_start();

if($_SESSION['valid_key'] != true){
    header('Location: http://www.gamers-live.net/installer/?error=Please try the installation again&app='.$app.'');
    exit;
}

$app = "Gamers Live";
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">

    <!-- www.phpied.com/conditional-comments-block-downloads/ -->
    <!--[if IE]><![endif]-->

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame  -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Gamers Live</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="http://gamers-live.net/favicon.ico">
    <link rel="apple-touch-icon" href="http://gamers-live.net/apple-touch-icon.png">

    <!-- CSS - Setup -->
    <link href="http://gamers-live.net/css/style.css" rel="stylesheet" type="text/css" />
    <link href="http://gamers-live.net/css/base.css" rel="stylesheet" type="text/css" />
    <link href="http://gamers-live.net/css/grid.css" rel="stylesheet" type="text/css" />
    <!-- CSS - Theme -->
    <link id="theme" href="http://gamers-live.net/css/themes/light.css" rel="stylesheet" type="text/css" />
    <link id="color" href="http://gamers-live.net/css/themes/blue.css" rel="stylesheet" type="text/css" />
    <!-- Syntax -->
    <link href="http://gamers-live.net/css/syntax/shCore.css" rel="stylesheet" type="text/css" />
    <link href="http://gamers-live.net/css/syntax/shThemeDefault.css" rel="stylesheet" type="text/css" />
    <script src="http://gamers-live.net/css/syntax/shCore.js"></script>
    <script src="http://gamers-live.net/css/syntax/shBrushPhp.js"></script>

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="http://gamers-live.net/js/modernizr-1.5.min.js"></script>
</head>

<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->
<div id="wrapper">



    <!-- start header -->
    <header>
        <!-- logo -->
        <h1 id="logo"><a href="./">Gamers Live</a></h1>
        <!-- nav -->
        <br class="cl" />
    </header>
    <!-- end header -->
    <!-- page container -->
    <div id="page">
        <!-- page title -->
        <h2 class="ribbon blue full">Installer<span>You are about to to install <?=$app?></span> </h2>
        <div class="triangle-ribbon blue"></div>
        <br class="cl">
        <!-- page content -->
        <div id="page-content">
            <div class="grid_12">
                <p>The following is your config.php file, this should be placed at the root directory of your htdocs folder. Should you need help with this procedure then see more information <a href="http://gamers-live.net/store/index.php?/topic/3-gamers-live-installation-guide/">here</a>.</p>

                <h3>Config.php</h3>

                <p><pre class="brush: php">
&lt;?php
$conf_installed = "1";
$conf_key = "<?=$_SESSION['serial_key']?>";
$conf_demo_mode = "0";

// Database info
$database_url = "<?=$_SESSION['db_host']?>";
$database_user = "<?=$_SESSION['db_user']?>";
$database_pw = "<?=$_SESSION['db_pw']?>";
$database_name = "<?=$_SESSION['db_name']?>";

// Information
$conf_site_name = "<?=$_SESSION['site_name']?>";
$conf_site_url = "<?=$_SESSION['site_url']?>";
$conf_site_copy = "&copy; 2013 <?=$_SESSION['site_name']?>. All Rights Reserved.";
$conf_site_rtmp = "<?=$_SESSION['site_rtmp']?>";
$conf_email = "<?=$_SESSION['site_email']?>";

// ads
$conf_video_ads = "<?=$_SESSION['ads_video']?>";
$conf_google_ads = '<?=$_SESSION['ads_google']?>';
$conf_video_channel = "<?=$_SESSION['ads_channel']?>";

// store
$conf_store_paypal_email = "<?=$_SESSION['paypal_email']?>";

// company information<
$conf_address = "<?=$_SESSION['address']?>";
$conf_phone = "<?=$_SESSION['phone']?>";
$conf_support_email = "<?=$_SESSION['email']?>";

// blog & support links
$conf_blog = "<?=$_SESSION['blog']?>";
$conf_support = "<?=$_SESSION['support']?>";

// social media
$conf_facebook = "<?=$_SESSION['facebook']?>";
$conf_twitter = "<?=$_SESSION['twitter']?>";

// wowza connectioncounts setup
$conf_connec_user = "<?=$_SESSION['con_user']?>";
$conf_connec_pw = "<?=$_SESSION['con_pw']?>";
$conf_connec_host = "<?=$_SESSION['con_host']?>";

// installation paths
$conf_ht_docs = "<?=$_SESSION['ht_docs']?>";
$conf_wowza = "<?=$_SESSION['wowza']?>";
$conf_ht_docs_gl = "<?=$_SESSION['ht_docs_gl']?>";

// DO NOT CHANGE BELOW HERE!!

//*******************************************************************//

// system
$conf_version = "<?=$_SESSION['version']?>";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db($database_name, $connect) or die(mysql_error());

//*******************************************************************//
?>
</pre>
                <button class="green small" ONCLICK="window.location.href='download.php'">Download Config.php</button>
                </p>
                <h3>Cron Jobs / Scheduled jobs</h3>
                <p>You will also need to setup some Cron Jobs / Scheduled jobs to make the automatisation of Gamers Live works. Should you need help with this, then read more about it <a href="http://gamers-live.net/store/index.php?/topic/3-gamers-live-installation-guide/">here</a>.</p>
                <p>To setup a these tasks you will need to do varius things depending on your operation system.<br>
                    On windows you should use the "Windows Task Scheduler" or "Task Scheduler".<br>
                    On Linux you should use the the cron job feature: <pre class="brush: php">$ crontab -e</pre>
                <br>You will need to add ALL the tasks to make Gamers Live work correctly!</p>

                <h4>Administrator Stats</h4>
                <p>Should be executed once every day. (Creates the statistics for admins, should only be runned once everyday or it will break.)<br></p>
                <b>Windows:</b>
                <pre class="brush: php">
                    {YOUR PHP PATH}/php.exe -f "<?=$_SESSION['site_url']?>/account/admin/log.php"
                </pre>
                <b>Linux:</b>
                <pre class="brush: php">
                     0 * * * <?=$_SESSION['site_url']?>/account/admin/log.php
                </pre>

                <h4>Chat Module</h4>
                    <p>Should be executed at minimum once every day. (This script will clear the chat for each channel so there is only the 250 newest messages left, having this run often improves chat reliability and speed.)<br></p>
                <b>Windows:</b>
                <pre class="brush: php">
                    {YOUR PHP PATH}/php.exe -f "<?=$_SESSION['site_url']?>/functions/clear_chat.php"
                </pre>
                <b>Linux:</b>
                <pre class="brush: php">
                     0 * * * <?=$_SESSION['site_url']?>/functions/clear_chat.php
                </pre>

                <h4>User Updater</h4>
                <p>Should be executed at minimum every 5 minute (The more the better as this script updates when users are online, viewers etc.).</p>
                <b>Windows:</b>
                <pre class="brush: php">
                    {YOUR PHP PATH}/php.exe -f "<?=$_SESSION['site_url']?>/functions/updater.php"
                </pre>
                <b>Linux:</b>
                <pre class="brush: php">
                     0,5,10,15,20,25,30,35,40,45,50,55 * * * * <?=$_SESSION['site_url']?>/functions/updater.php
                </pre>

                <h4>Payments</h4>
                <p>Should be executed the day before your do your partner payments (1'st of every month as this will update the payments and the amount you will need to pay to each partner.).<br></p>
                <b>Windows:</b>
                <pre class="brush: php">
                    {YOUR PHP PATH}/php.exe -f "<?=$_SESSION['site_url']?>/functions/payments.php"
                </pre>
                <b>Linux:</b>
                <pre class="brush: php">
                     0 0 1 * * <?=$_SESSION['site_url']?>/functions/payments.php
                </pre>

                <h3>Google Analytics</h3>
                <p>Gamers Live natively supports Google Analytics, and it is easy to implement.<br>
                Just edit the <i>analyticstracking.php</i> and insert your Google Analytics script here.</p>
                <h3>Admin Account</h3>
                <p>If you have installed Gamers Live correctly you should now be able to login. To login with your admin account please use the following information:<br><br><b>Email:</b> admin@admin.com<br><b>Password:</b> admin123</p>
                <p>You should be able to login from this page: <a href="http://<?=$_SESSION['site_url']?>/account/login/"><?=$_SESSION['site_url']?>/account/login/</a></p>
                <p><b>Also don't forget to change the password, username etc. for this admin account!</b></p>
                <h3>Support</h3>
                <p>Should you need further assistance or did you have issues you could not solve, please contact us <a href="http://gamers-live.net/store/index.php?app=nexus&module=support">here</a>.</p>
                <button class="fr" type="submit" id="submit" ONCLICK="window.location.href='exit.php?<? SID;?>'">Exit</button>
            </div>
            <br>
        </div>
        <br class="cl">
        <br class="cl">
    </div>
    <!-- footer Start -->
    <footer>
        <p>Copyright ©2013 <a href="http://www.gamers-live.net">Gamers Live</a></p>
        <br class="cl" />
    </footer>
    <!-- footer end -->

    <!-- Javascript at the bottom for fast page loading -->
    <script src="http://gamers-live.net/js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.tools.min.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.form.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/cufon-yui.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/Aller.font.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/jquery.tipsy.js" type="text/javascript"></script>
    <script src="http://gamers-live.net/js/functions.js" type="text/javascript"></script>
    <!--[if lt IE 7 ]>
    <script src="http://gamers-live.net/js/dd_belatedpng.js"></script>
    <![endif]-->
</div>

<script type="text/javascript">
    SyntaxHighlighter.all()
</script>
</body>
</html>