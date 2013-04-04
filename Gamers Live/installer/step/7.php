<?php
error_reporting(0);
session_start();

if($_SESSION['valid_key'] != true){
    header('Location: http://www.gamers-live.net/installer/?error=Please try the installation again&app='.$app.'');
    exit;
}
// set sessions
$_SESSION['con_user'] = $_POST['con_user'];
$_SESSION['con_pw'] = $_POST['con_pw'];
$_SESSION['con_url'] = $_POST['con_url'];
$_SESSION['ht_docs'] = $_POST['ht_docs'];
$_SESSION['wowza'] = $_POST['wowza'];
$_SESSION['ht_docs_gl'] = $_POST['ht_docs_gl'];

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
    <script src="http://gamers-live.net/css/syntax/shBrushJScript.js"></script>

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
                <p>Please verify that the information below is correct. If some information should be incorrect then you can go back and correct it.</p>
                <p><b>Serial Key: </b><?=$_SESSION['serial_key']?></p>

                <h4>mySQL Information</h4>
                <p><b>Database Host: </b><?=$_SESSION['db_host']?></p>
                <p><b>Database User: </b><?=$_SESSION['db_user']?></p>
                <p><b>Database Password: </b><?=$_SESSION['db_pw']?></p>
                <p><b>Database Name: </b><?=$_SESSION['db_name']?></p>

                <h4>Site Information</h4>
                <p><b>Site Name: </b><?=$_SESSION['site_name']?></p>
                <p><b>Site Url: </b><?=$_SESSION['site_url']?></p>
                <p><b>Site RTMP URL: </b><?=$_SESSION['site_rtmp']?></p>
                <p><b>Main Email: </b><?=$_SESSION['site_email']?></p>

                <h4>Ads Information</h4>
                <p><b>Bigsool Video Ads Id: </b><?=$_SESSION['ads_video']?></p>
                <p><b>Google Ads Code: </b></p>
                <pre class="brush: javascript">
<?=$_SESSION['ads_google']?>
                </pre>
                <p><b>Video Ads Channel: </b><?=$_SESSION['ads_channel']?></p>

                <h4>Company Information</h4>
                <p><b>PayPal Email: </b><?=$_SESSION['paypal_email']?></p>
                <p><b>Company Address: </b><?=$_SESSION['address']?></p>
                <p><b>Company Phone: </b><?=$_SESSION['phone']?></p>
                <p><b>Company Email: </b><?=$_SESSION['email']?></p>

                <h4>Links & Social Information</h4>
                <p><b>Facebook URL: </b><?=$_SESSION['facebook']?></p>
                <p><b>Twitter URL: </b><?=$_SESSION['twitter']?></p>

                <h4>WOWZA & Path Information</h4>
                <p><b>WOWZA Connectioncounts User: </b><?=$_SESSION['con_user']?></p>
                <p><b>WOWZA Connectioncounts Password: </b><?=$_SESSION['con_pw']?></p>
                <p><b>WOWZA Connectioncounts URL: </b><?=$_SESSION['con_url']?></p>
                <p><b>Gamers Live Installation Path: </b><?=$_SESSION['ht_docs']?></p>
                <p><b>Path to Gamers Live from root htdocs folder: </b><?=$_SESSION['ht_docs_gl']?></p>
                <p><b>WOWZA Installation Path: </b><?=$_SESSION['wowza']?></p>

                <button class="fr" type="submit" id="submit" ONCLICK="window.location.href='8.php'">Finish</button>

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