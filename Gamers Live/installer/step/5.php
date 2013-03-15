<?php
error_reporting(0);
session_start();

if($_SESSION['valid_key'] != true){
    header('Location: http://www.gamers-live.net/installer/?error=Please try the installation again&app='.$app.'');
    exit;
}
// set sessions
$_SESSION['paypal_email'] = $_POST['paypal_email'];
$_SESSION['address'] = $_POST['address'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['email'] = $_POST['email'];

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

                <h3>Links & Social Information</h3>
                <form method="post" action="6.php">
                    <p>
                        <b>Blog URL</b>
                        <input name="blog" id="blog" value="<?=$_SESSION['blog']?>" type="text" style="width: 860px"/>
                        <i>Could be "http://www.gamers-live.net/demo/blog/" etc.</i><br><br>
                        <b>Support URL</b>
                        <input name="support" id="support" value="<?=$_SESSION['support']?>" type="text" style="width: 860px"/>
                        <i>Could be "http://www.support.gamers-live.net/" etc.</i><br><br>
                        <b>Facebook URL</b>
                        <input name="facebook" id="facebook" value="<?=$_SESSION['facebook']?>" type="text" style="width: 860px"/>
                        <i>Could be "http://www.facebook.com/pages/Gamers-Live/301016116668756" etc.</i><br><br>
                        <b>Twitter URL</b>
                        <input name="twitter" id="twitter" value="<?=$_SESSION['twitter']?>" type="text" style="width: 860px"/>
                        <i>Could be "https://twitter.com/GamersLiveNet" etc.</i>
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