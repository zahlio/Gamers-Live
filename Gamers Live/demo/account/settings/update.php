<?php
error_reporting(0);
include_once("../../config.php");
include_once("../../analyticstracking.php");


session_start();

if ($_SESSION['access'] != true) {
	header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];

$value = strip_tags($_POST['value'], '<br><b><i>');

$msg = $_GET["msg"];
if($msg == ""){
$msg = header( 'Location: '.$conf_site_url.'/account/settings/?<? SID; ?>' );
}
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

// update data with msg

if($msg == "display_name"){	

$display_name_update = mysql_query("UPDATE users SET display_name='$value' WHERE email='$email'") or die(mysql_error());
	
}

if($msg == "password"){
	
$password_name_update = mysql_query("UPDATE users SET password='$value' WHERE email='$email'") or die(mysql_error());
	
}

if($msg == "short_bio"){
	
$short_bio_name_update = mysql_query("UPDATE users SET short_bio='$value' WHERE email='$email'") or die(mysql_error());
	
}

if($msg == "long_bio"){

$long_bio_name_update = mysql_query("UPDATE users SET long_bio='$value' WHERE email='$email'") or die(mysql_error());
}

if($msg == "game"){
	
$game_update = mysql_query("UPDATE channels SET game='$value' WHERE channel_id='$channel_id'") or die(mysql_error());
	
}

if($msg == "title"){
	
	$title_update = mysql_query("UPDATE channels SET title='$value' WHERE channel_id='$channel_id'") or die(mysql_error());
}

if($msg == "info1"){
	$info1_update = mysql_query("UPDATE channels SET info1='$value' WHERE channel_id='$channel_id'") or die(mysql_error());
}

if($msg == "info2"){
	$info2_update = mysql_query("UPDATE channels SET info2='$value' WHERE channel_id='$channel_id'") or die(mysql_error());
}

if($msg == "info3"){
	$info3_update = mysql_query("UPDATE channels SET info3='$value' WHERE channel_id='$channel_id'") or die(mysql_error());
	
}

header( 'Location: '.$conf_site_url.'/account/settings/?') ;	
?>