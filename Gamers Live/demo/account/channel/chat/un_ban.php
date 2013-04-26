<?php
error_reporting(0);
include_once("../../../config.php");
include_once("../../../analyticstracking.php");


session_start();



include_once("".$conf_ht_docs_gl."/analyticstracking.php");
if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$mod_name = $_SESSION['channel_id'];

$username = $_GET['user'];

$channel_id = $_GET['channel'];

// we need to see if user is mod
$get_auth_user = mysql_query("SELECT * FROM chat_mods WHERE user_id='$mod_name' AND channel_id='$channel_id'") or die(mysql_error());
$get_auth_rows_user = mysql_fetch_array($get_auth_user);

if(($get_auth_rows_user['mod'] == "1") || ($get_auth_rows_user['admin'] == "1")){
    $can_ban = true;
}else{
    $msg = "You cannot unban on this channel";
}

// if we are owner
if($mod_name == $channel_id){
    $can_ban = true;
}

$staff_check = mysql_query("SELECT * FROM channels WHERE channel_id='$mod_name' AND admin='1'");
$staff_check_count = mysql_num_rows($staff_check);
if($staff_check_count == 1){
    $can_ban = true;
}

if($can_ban == true){
    // we will unban
    $unban = mysql_query("UPDATE chat_bans SET banned='0' WHERE channel_id='$channel_id' AND user_id='$username'") or die(mysql_error());
    $msg = 'You have unbanned '.$username.'';
}
?>
<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />
<title>Bannned Chat User</title>
<center><h3><?=$msg?></h3></center>