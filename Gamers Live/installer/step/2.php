<?php
error_reporting(0);
session_start();

if($_SESSION['valid_key'] != true){
    header('Location: http://www.gamers-live.net/installer/?error=Please try the installation again&app='.$app.'');
    exit;
}
// set sessions

$_SESSION['db_host'] = $_POST['db_host'];
$_SESSION['db_user'] = $_POST['db_user'];
$_SESSION['db_pw'] = $_POST['db_pw'];
$_SESSION['db_name'] = $_POST['db_name'];

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
                <ul class="breadcrumbs">
                    <li><a href="http://www.gamers-live.net/installer/?<?=$post_app?>" >Installer</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/1.php?" >Step 1: mySQL</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/2.php?" >Step 2: Site Info</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/3.php?" >Step 3: Ads Setup</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/4.php?" >Step 4: Company Information</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/5.php?" >Step 5: Links & Social</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/6.php?" >Step 6: WOWZA & Paths</a> &gt;</li>
                    <li><a href="http://www.gamers-live.net/installer/step/7.php?" >Verify</a></li>
                </ul>
                <p>Please make sure you have installed WOWZA media server and knows what the RTMP URL is for your setup. If you need help with this, see more information <a href="http://gamers-live.net/store/index.php?/topic/3-gamers-live-installation-guide/" >here</a></p>
                <h3>Site Information</h3>
                <form method="post" action="3.php">
                    <p>
                        <b>Site Name</b>
                        <input name="site_name" id="site_name" value="<?=$_SESSION['site_name']?>" type="text" style="width: 860px"/>
                        <i>Could be "Gamers Live" or "Twitch.tv" etc.</i><br><br>
                        <b>Site URL</b>
                        <input name="site_url" id="site_url" value="<?=$_SESSION['site_url']?>" type="text" style="width: 860px"/>
                        <i>Could be "http://www.gamers-live.net/demo" or "http://www.google.com" etc. (no ending backslash)</i><br><br>
                        <b>Site RTMP URL</b>
                        <input name="site_rtmp" id="site_rtmp" value="<?=$_SESSION['site_rtmp']?>" type="text" style="width: 860px"/>
                        <i>Could be "rtmp://gamers-live.net/" or "rtmp://google.com/" etc.</i><br><br>
                        <b>Main Email</b>
                        <input name="site_email" id="site_email" value="<?=$_SESSION['site_email']?>" type="text" style="width: 860px"/>
                        <i>Could be "admin@gamers-live.net" or "blabla@google.com" etc.</i>
                    </p>
                    <button class="fr" type="submit" id="submit">Continue</button>
                </form>
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

</body>
</html>