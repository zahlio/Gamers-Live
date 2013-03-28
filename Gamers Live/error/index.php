<?php
error_reporting(0);
$site = $_GET['site'];

if($site == null){
    $site = "your website";
}
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
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- CSS - Setup -->
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/base.css" rel="stylesheet" type="text/css" />
    <link href="../css/grid.css" rel="stylesheet" type="text/css" />
    <!-- CSS - Theme -->
    <link id="theme" href="../css/themes/light.css" rel="stylesheet" type="text/css" />
    <link id="color" href="../css/themes/blue.css" rel="stylesheet" type="text/css" />

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="../js/modernizr-1.5.min.js"></script>
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
        <h1 id="logo"><a href="../index.html">Gamers Live</a></h1>
        <br class="cl" />
    </header>
    <!-- end header -->
    <!-- page container -->
    <div id="page">
        <!-- page title -->
        <h2 class="ribbon full">License Error <span>Yep.. There was an error</span> </h2>
        <div class="triangle-ribbon"></div>
        <br class="cl">
        <!-- page content -->
        <div id="page-content" class="two-col container_12">
            <h4>License Error</h4>
        <p>There was an error with <?=$site?>.</p>
        <p>One of the issues can be that you do not have a valid Gamers Live license. Should this be the case then please redo the installation <a href="http://www.gamers-live.net/installer/">here</a>, or purchase a valid license key <a href="http://www.gamers-live.net/order.html">here</a>.</p>
        <h4>I am not the owner of the site</h4>
            <p>If you are not the owner or webmaster of the site, then please contact the owner, administrator, webmaser or really any staff on the site with this error. The staff should then be able to fix it.</p>
        </div>

        <!-- page sidebar -->
        <aside>
            <h3><cufon class="cufon cufon-canvas" alt="Our " style="width: 36px; height: 18px;"><canvas width="52" height="20" style="width: 52px; height: 20px; top: 0px; left: -1px;"></canvas><cufontext>Our </cufontext></cufon><cufon class="cufon cufon-canvas" alt="Address" style="width: 69px; height: 18px;"><canvas width="81" height="20" style="width: 81px; height: 20px; top: 0px; left: -1px;"></canvas><cufontext>Address</cufontext></cufon></h3>
            <p><strong>Corporate Info</strong><br>
                Hagenstrupparken 49,<br>
                8860 Ulstrup, Denmark<br>
                Phone: +45 2112 6570</p>
            <p class="border-top"><strong>Sales Inquiries</strong><br>
                Email: admin@gamers-live.net<br>
                Phone: +45 2112 6570<br>
            </p>
            <h3><cufon class="cufon cufon-canvas" alt="Socialise " style="width: 80px; height: 18px;"><canvas width="96" height="20" style="width: 96px; height: 20px; top: 0px; left: -1px;"></canvas><cufontext>Socialise </cufontext></cufon><cufon class="cufon cufon-canvas" alt="With " style="width: 45px; height: 18px;"><canvas width="61" height="20" style="width: 61px; height: 20px; top: 0px; left: -1px;"></canvas><cufontext>With </cufontext></cufon><cufon class="cufon cufon-canvas" alt="Us" style="width: 21px; height: 18px;"><canvas width="33" height="20" style="width: 33px; height: 20px; top: 0px; left: -1px;"></canvas><cufontext>Us</cufontext></cufon></h3>
            <ul class="social-list">
                <li><a href="https://twitter.com/GamersLiveNet"><img class="tooltip" src="../img/social/32/twitter.png" alt="twitter" original-title="Follow us on Twitter"></a></li>
                <li><a href="https://www.facebook.com/pages/Gamers-Live/301016116668756"><img class="tooltip" src="../img/social/32/facebook.png" alt="facebook" title="Our Facebook page"></a></li>
                <li><a href="http://gamers-live.net/store/index.php?/rss/forums/1-gamers-live-news/"><img class="tooltip" src="../img/social/32/rss.png" title="Grab our RSS feed" alt="rss"></a></li>
            </ul>
        </aside>
        <br class="cl">
        <br class="cl">
    </div>
    <!-- footer Start -->
    <footer>
        <ul class="footer-nav">
            <ul class="footer-nav">
                <li><a href="http://gamers-live.net/store/index.php?app=forums&module=extras&section=boardrules">Terms Of Service</a> |</li>
                <li><a href="http://gamers-live.net/store/index.php?/privacypolicy/">Privacy Policy</a></li>
            </ul>
        </ul>
        <p>Copyright ©2013 <a href="http://www.gamers-live.net">Gamers Live</a></p>
        <br class="cl" />
    </footer>
    <!-- footer end -->

    <!-- Javascript at the bottom for fast page loading -->
    <script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="../js/jquery.tools.min.js" type="text/javascript"></script>
    <script src="../js/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
    <script src="../js/jquery.form.js" type="text/javascript"></script>
    <script src="../js/cufon-yui.js" type="text/javascript"></script>
    <script src="../js/Aller.font.js" type="text/javascript"></script>
    <script src="../js/jquery.tipsy.js" type="text/javascript"></script>
    <script src="../js/functions.js" type="text/javascript"></script>
    <!--[if lt IE 7 ]>
    <script src="../js/dd_belatedpng.js"></script>
    <![endif]-->
</div>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-38386578-1']);
    _gaq.push(['_setDomainName', 'gamers-live.net']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
</body>
</html>