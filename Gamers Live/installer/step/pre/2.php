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
        <h1 id="logo"><a href="../">Gamers Live</a></h1>
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
                <h3>WOWZA installation</h3>
                <p>To use Gamers Live you will need to have WOWZA running on your machine. WOWZA is the program that Gamers Live uses to handle the live streaming from your clients PC's.</p>
                
                <h4>Step 1: Register a WOWZA account</h4>
                
                <?php
                // TODO add license stuff here
                ?>
                
                <b>Buy a license</b>
                <p>If you wish to buy a WOWZA license then please check out the following <a href="http://www.wowza.com/pricing/" target="_blank">page</a>.</p>
                <b>FREE Trial</b>
                <p>If you wish to use the FREE TRIAL of WOWZA, then please check out the following <a href="http://www.wowza.com/pricing/trial" target="_blank">page</a>.</p>
                
                <div class="notification info"> <span class="strong">Information:</span> You will need an active valid license of WOWZA to make Gamers Live work.</div>
                <br>
                <h4>Step 2: Download WOWZA</h4>
                <p>You will now need to download the latest version of WOWZA for your OS.</p>
                <p><a href="http://www.wowza.com/pricing/installer" target="_blank">DOWNLOAD THE WOWZA INSTALLER</a></p>
                
                <br>
                <h4>Step 3: Install WOWZA</h4>
                <p>Now that we have a valid license and have installed WOWZA, we will need to install it. <i>(Your machine will need to have the Java Runtime Environment (JRE) version 6 or greater)</i></p>
                <p>Now please follow the installation guide for your OS:</p>
                <b>Windows Installation</b>
                <p>To install Wowza Media Server 3.5 on Windows® operating systems, double-click the installer file and follow the instructions on the screen. (To find the installer file on Windows 8 and Windows Server 2012 operating systems, press WIN key + F and then search for WowzaMediaServer-3.5.2.)</p>

                <p><b>Note:</b> To run Wowza Transcoder AddOn on 64-bit versions of the Windows Server operating system, the following server features must be installed:</p>
                    <ul class="bullet-list">
                        <li>.NET Framework 3.5.1</li>
                        <li>Desktop Experience</li>
                    </ul>
                <b>Mac OS X Installation</b>
                <p>To install Wowza Media Server 3.5 on Mac OS X, mount the disk image (double-click .dmg) file, double-click the installer package (.pkg) file, and then follow the instructions on the screen. </p>
                
                <b>Red Hat Package Manager (RPM) Installation</b>
                <p>Open a command shell and enter the following commands:</p>
                <pre class="brush: php">
sudo chmod +x WowzaMediaServer-3.5.2.rpm.bin
sudo ./WowzaMediaServer-3.5.2.rpm.bin
                </pre>
                
                
                
                <b>Debian Package Manager (DEB) Installation</b>
                <p>Open a command shell and enter the following commands:</p>
                <pre class="brush: php">
sudo chmod +x WowzaMediaServer-3.5.2.deb.bin
sudo ./WowzaMediaServer-3.5.2.deb.bin
                </pre>
                <b>TAR Installer (TAR) Installation</b>
                <p>Open a command shell and enter the following commands:</p>
                <pre class="brush: php">
sudo chmod +x WowzaMediaServer-3.5.2.tar.bin
sudo ./WowzaMediaServer-3.5.2.tar.bin
                </pre>
                
                <p><b>Note:</b> On platforms other than Windows, Wowza Media Server must first be started in standalone mode. When you start the server in standalone mode for the first time, you'll be asked to enter your license key from your approval email in a terminal window. After the license key is entered successfully, you can run the server as a system service.</p>
                
                <h4>Step 4: Configuring WOWZA</h4>
                <p>You will need to setup <i>connectioncounts</i> in WOWZA so that Gamers Live can use the statistics (viewers etc.) to display on your site.</p>
                <p><b>Note:</b> Please upgrade to Wowza Media Server 3.0.3.08 or greater before following the steps below.</p>

                <p>Using a text editor enter a username/password into the [wowza-install-dir]/conf/admin.password file.</p>
                
                <p>An example of this could be:</p>
                <pre class="brush: php">
# Admin password file (format [username][space][password])
#username password
live_stats livelive123
                </pre>
                
                <b>Installing the Gamers Live files into WOWZA</b>
                <p>You have already downloaded the latest Gamers Live version, if you have not do so <a href="http://gamers-live.net/store/index.php/files/" target="_blank">here</a>.</p>
                <p>Now open the folder where your Gamers Live files are located and drag the content from the directory <i>WOWZA</i> into your WOWZA installation folder:</p>
                
                <center>
                    <a href="http://gamers-live.net/img/drag.PNG" target="_blank">
                        <img class="inlinepic" src="http://gamers-live.net/img/drag.PNG" alt="" width="600" height="200">
                    </a>
                </center>
                <br>
                <div class="notification info"> <span class="strong">Information:</span> WOWZA will need to be <b>RUNNING</b> at all time to make Gamers Live work!</div>
                <p><b>Note:</b> Should you need additional documentation using WOWZA, then please refer to their official <a href="http://www.wowza.com/forums/content.php?3-quick-start-guide" target="_blank">documentation</a>.</p>
   
                <h4>Step 5: Installing the mySQL database</h4>
                <p>You will need to import the SQL file that is included in the Gamers Live installation folder, <i>("main.sql")</i> into your mySQL database. Please make a database that only is used for Gamers Live and create backups regularly, as should you lose it, all information regarding your costumers will be lost. AND THERE IS NO WAY OF GETTING IT BACK!</p>
                <p>When the database has been made and the main.sql has been imported, then you need to import the <i>INSERT AT THE END.sql</i> file.</p>
                <p>You have now installed and configured WOWZA, and you can run WOWZA and start the installation and configuration of Gamers Live.</p>
                
                <p>Now we can process by installing and configuring Gamers Live.</p>
                <form method="post" action="../check.php">
                    <button class="fr blue" type="submit" id="submit">Start the Gamers Live installation</button>
                </form>                
            </div>
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