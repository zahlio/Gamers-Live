<?php
error_reporting(0);


// this script makes an existing user admin on the site

session_start();
include_once("../../../config.php");
include_once("../../../analyticstracking.php");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];
$admin = $_SESSION['admin'];
$username = $_POST['username'];

// we now check that the user is existing

$checkUser = mysql_query("SELECT * FROM users WHERE channel_id='$username'") or die(mysql_error());
$checkUserCount = mysql_num_rows($checkUser);
$checkUserResults = mysql_fetch_array($checkUser);

if($checkUserCount != "1"){
    header( 'Location: '.$conf_site_url.'/account/admin/config/?error=There is no user with the username: '.$username );
    exit;
}

if($checkUserCount == "1"){
    // there is a user with that name
    // we now check if he is admin
    if($checkUserResults['admin'] == "1"){
        header( 'Location: '.$conf_site_url.'/account/admin/config/?error=The user with username: '.$username.' is already an admin' );
        exit;
    }
    // if we continue then the user is not an admin and we should make him one
    $createAdminUserTable = mysql_query("UPDATE users SET admin='1' WHERE channel_id='$username'") or die(mysql_error());
    $createAdminChannelTable = mysql_query("UPDATE channels SET admin='1' WHERE channel_id='$username'") or die(mysql_error());
    header( 'Location: '.$conf_site_url.'/account/admin/config/?error=The user with username: '.$username.' is now an admin' );

}
?>