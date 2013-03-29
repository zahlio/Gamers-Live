<?php
error_reporting(0);
session_start();

if($_SESSION['valid_key'] != true){
    header('Location: http://www.gamers-live.net/installer/?error=Please try the installation again&app='.$app.'');
    exit;
}

$adsGoogle = "'".str_replace("&lt", "<", $_SESSION['ads_google'])."'";
$filename = "config.php";
$content = '
<?php
$conf_installed = "1";
$conf_key = "'.$_SESSION["serial_key"].'";
$conf_demo_mode = "0";

// Database info
$database_url = "'.$_SESSION['db_host'].'";
$database_user = "'.$_SESSION['db_user'].'";
$database_pw = "'.$_SESSION['db_pw'].'";
$database_name = "'.$_SESSION['db_name'].'";

// Information
$conf_site_name = "'.$_SESSION['site_name'].'";
$conf_site_url = "'.$_SESSION['site_url'].'";
$conf_site_copy = "&copy; 2013 '.$_SESSION['site_name'].'. All Rights Reserved.";
$conf_site_rtmp = "'.$_SESSION['site_rtmp'].'";
$conf_email = "'.$_SESSION['site_email'].'";

// ads
$conf_video_ads = "'.$_SESSION['ads_video'].'";
$conf_google_ads = '.$adsGoogle.';
$conf_video_channel = "'.$_SESSION['ads_channel'].'";

// store
$conf_store_paypal_email = "'.$_SESSION['paypal_email'].'";

// company information
$conf_address = "'.$_SESSION['address'].'";
$conf_phone = "'.$_SESSION['phone'].'";
$conf_support_email = "'.$_SESSION['email'].'";

// blog & support links
$conf_blog = "'.$_SESSION['blog'].'";
$conf_support = "'.$_SESSION['support'].'";

// social media
$conf_facebook = "'.$_SESSION['facebook'].'";
$conf_twitter = "'.$_SESSION['twitter'].'";

// wowza connectioncounts setup
$conf_connec_user = "'.$_SESSION['con_user'].'";
$conf_connec_pw = "'.$_SESSION['con_pw'].'";
$conf_connec_host = "'.$_SESSION['con_host'].'";

// installation paths
$conf_ht_docs = "'.$_SESSION['ht_docs'].'";
$conf_wowza = "'.$_SESSION['wowza'].'";
$conf_ht_docs_gl = "'.$_SESSION['ht_docs_gl'].'";

// DO NOT CHANGE BELOW HERE!!

//*******************************************************************//

// system
$conf_version = "'.$_SESSION['version'].'";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db($database_name, $connect) or die(mysql_error());

//*******************************************************************//
?>';

!$handle = fopen($filename, 'w');
fwrite($handle, $content);
fclose($handle);

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Length: ". filesize("$filename").";");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: application/octet-stream; ");
header("Content-Transfer-Encoding: binary");

readfile($filename);
?>