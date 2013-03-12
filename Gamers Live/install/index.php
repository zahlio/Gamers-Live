<?php
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

$new = $_GET['new'];

if($conf_installed == "1"){
    header( 'Location: '.$conf_site_url.'' ) ;
    exit;
}



?>
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />

<body>
<div class="body_wrap thinpage">
<!-- middle -->
<div class="middle">
    <div class="container_12">

        <div class="divider_space_thin"></div>

        <!-- content -->

            <div class="post-detail">

                <div class="page-title">
                    <div class="meta-date">&nbsp;</div>
                    <h1>Install</h1>
                </div>
                <h2>Install Information</h2>
                <p>You are about to install Gamers Live Version: <?=$conf_version?>.<br>
                    <br>
                To succesfully install this version you will need the following:<br>
                - PHP 5.2.7 or greater<br>
                - mySQL 5.6 or greater<br>
                - WOWZA MEDIA SERVER 3.5 or greater<br>
                - A valid Gamers Live Serial Key</p>

                <h2>Setup</h2>
                <p>You will need to fill in all details, and if you don't the installation might crash.</p>

                <form name="install" action="doInstall.php" method="post" id="loginform" class="loginform">

                    <p><label>Serial Key</label><br><input name="serial_key" id="serial_key" class="gamersTextbox" value=""style="width: 500px; height: 30px"></p>

                    <h4>Admin Information</h4>
                    <p><label>Administrator Username</label><br><input name="admin_name" id="admin_name" class="gamersTextbox" value=""style="width: 500px; height: 30px"></p>
                    <p><label>Administrator Password</label><br><input name="admin_pw" id="admin_pw" class="gamersTextbox" value=""style="width: 500px; height: 30px"></p>
                    <h4>Database Information</h4>

                    <p><label>Database Host</label><br><input name="db_host" id="db_host" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "localhost" or "127.0.0.1" etc.</p>
                    <p><label>Database User</label><br><input name="db_user" id="db_user" class="gamersTextbox" value=""style="width: 500px; height: 30px"></p>
                    <p><label>Database Password</label><br><input name="db_pw" id="db_pw" class="gamersTextbox" value=""style="width: 500px; height: 30px"></p>

                    <h4>Site Information</h4>
                    <p><label>Site Name</label><br><input name="site_name" id="site_name" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "Gamers Live" etc.</p>
                    <p><label>Site URL</label><br><input name="site_url" id="site_url" class="gamersTextbox" value=""style="width: 500px; height: 30px">  full URL no backslash = "http://www.gamers-live.net"</p>
                    <p><label>Copyrights Text</label><br><input name="site_copy" id="site_copy" class="gamersTextbox" value=""style="width: 500px; height: 30px">  example = "2011 Gamers Live. All Rights Reserved."</p>
                    <p><label>Site RTMP</label><br><input name="site_rtmp" id="site_rtmp" class="gamersTextbox" value=""style="width: 500px; height: 30px">  full URL no backslash = "rtmp://gamers-live.net/"</p>
                    <p><label>Admin Email</label><br><input name="site_email" id="site_email" class="gamersTextbox" value=""style="width: 500px; height: 30px">  email used to get contacted on the site and to email users = "admin@gamers-live.net"</p>

                    <h4>Company Information</h4>
                    <p><label>Company Address</label><br><input name="comp_address" id="comp_address" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "Hagenstrupparken 49, 8860 Ulstrup Denmark" etc.</p>
                    <p><label>Company Phone</label><br><input name="comp_phone" id="comp_phone" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "+45 21126570" etc.</p>
                    <p><label>Company Email</label><br><input name="comp_email" id="comp_email" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "admin@gamers-live.net" etc.</p>

                    <h4>Blog & Support Links</h4>
                    <p><label>Blog Link</label><br><input name="link_blog" id="link_blog" class="gamersTextbox" value=""style="width: 500px; height: 30px">  Link to your blog, where events will be posted at (we advice to use wordpress) "http://www.gamers-live.net/blog/" etc.</p>
                    <p><label>Support Link</label><br><input name="link_support" id="link_support" class="gamersTextbox" value=""style="width: 500px; height: 30px">   Link to your support page, where help articles and tickets can be submitted (we advice to use zendesk) "http://www.support.gamers-live.net/" etc.</p>

                    <h4>Social Media</h4>
                    <p><label>Facebook URL</label><br><input name="facebook" id="facebook" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "http://www.facebook.com/pages/Gamers-Live/301016116668756" etc.</p>
                    <p><label>Twitter URL</label><br><input name="twitter" id="twitter" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "https://twitter.com/GamersLiveNet" etc.</p>

                    <h4>WOWZA Information</h4>
                    <p><label>Connectioncounts User</label><br><input name="con_user" id="con_user" class="gamersTextbox" value=""style="width: 500px; height: 30px">  see more here <a href="http://www.wowza.com/forums/content.php?129-How-to-get-realtime-connection-counts-from-Wowza-Media-Server">link</a></p>
                    <p><label>Connectioncounts Password</label><br><input name="con_pw" id="con_pw" class="gamersTextbox" value=""style="width: 500px; height: 30px">  see more here <a href="http://www.wowza.com/forums/content.php?129-How-to-get-realtime-connection-counts-from-Wowza-Media-Server">link</a></p>
                    <p><label>Connectioncounts URL</label><br><input name="con_host" id="con_host" class="gamersTextbox" value=""style="width: 500px; height: 30px">  no backslash "gamers-live.net" etc.</p>

                    <h4>Patchs</h4>
                    <p><label>WOWZA Path</label><br><input name="wowza_path" id="wowza_path" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "c:/live" etc.</p>
                    <p><label>HTDOCS Path</label><br><input name="htdocs_path" id="htdocs_path" class="gamersTextbox" value=""style="width: 500px; height: 30px">  "c:/xampp/htdocs" etc.</p>

                    <h4>ADS Setup</h4>
                    <p><label>Video Channel ID</label><br><input name="video_ads_id" id="video_ads_id" class="gamersTextbox" value=""style="width: 500px; height: 30px">  like "ca-video-pub-2504383399867703" see more here <a href="http://flash.flowplayer.org/plugins/advertising/adsense/index.html">link</a></p>
                    <p><label>Google Ads</label><br><input name="ads_id" id="ads_id" class="gamersTextbox" value=""style="width: 500px; height: 30px">  like "
                    google_ad_client = "ca-pub-2504383399867703";
                    /* Gamers Live Chat ad */
                    google_ad_slot = "5072251451";
                    google_ad_width = 728;
                    google_ad_height = 90;
>" </p>
                    <a href="#" id="login_but" class="button_link"><span>Install Now</span></a>

                </form>

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
                <h3>Gamers Live</h3>

                <div class="copyright">
2013 Gamers Live. All Rights Reserved.
                </div>
            </div>


            <div class="clear"></div>
        </div>
    </div>
</div>

</div>


</body>