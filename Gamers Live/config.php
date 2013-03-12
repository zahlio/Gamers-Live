<?php

$conf_installed = "0";

// admin
$conf_admin_name = "";
$conf_admin_pw = "";
$conf_key = "";



// Database info
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// Information
$conf_site_name = "Gamers Live";
$conf_site_url = "http://www.gamers-live.net";
$conf_site_copy = "&copy; 2011 Gamers Live. All Rights Reserved.";
$conf_site_rtmp = "rtmp://gamers-live.net/";
$conf_email = "admin@gamers-live.net";

// ads
$conf_video_ads = "ca-video-pub-2504383399867703";

// store
$conf_store_paypal_email = "admin@gamers-live.net";

// company information
$conf_address = "Hagenstrupparken 49,<br>
8860 Ulstrup Denmark";
$conf_phone = "+45 21126570";
$conf_support_email = "admin@gamers-live.net";

// blog & support links
$conf_blog = "http://www.gamers-live.net/blog/";
$conf_support = "http://www.support.gamers-live.net/";

// wowza connectioncounts setup
$conf_connec_user = "live_stats";
$conf_connec_pw = "livelive123";
$conf_connec_host = "gamers-live.net";

// installation paths
$conf_ht_docs = "c:/xampp/htdocs";
$conf_wowza = "c:/live";

// social media
$conf_facebook = "http://www.facebook.com/pages/Gamers-Live/301016116668756";
$conf_twitter = "https://twitter.com/GamersLiveNet";


// DO NOT CHANGE BELOW HERE!!

//******************************************************************************************************************//

// system
$conf_version = "1.0";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

//******************************************************************************************************************//
?>