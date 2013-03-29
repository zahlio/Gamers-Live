<?php
error_reporting(0);


session_start();

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
	header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_GET['email'];
$channel_id = $_GET['channel_id'];

$value = $_POST['value'];

$msg = $_GET["msg"];
if($msg == ""){
$msg = header( 'Location: '.$conf_site_url.'/account/admin?<? SID; ?>' );
}

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");
			
// connect to database

			
// select thje database we need


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

if($msg == "ban"){
    $ban_value = $_GET['value'];
	$ban_1 = mysql_query("UPDATE channels SET banned='$ban_value' WHERE channel_id='$channel_id'") or die(mysql_error());
	$ban_2 = mysql_query("UPDATE users SET banned='$ban_value' WHERE channel_id='$channel_id'") or die(mysql_error());
	
}

if($msg == "partner"){
    $partner_value = $_GET['value'];
	$partner = mysql_query("UPDATE users SET partner='$partner_value' WHERE channel_id='$channel_id'") or die(mysql_error());
}



header( 'Location: '.$conf_site_url.'/account/admin/user.php?channel='.$channel_id.'') ;	
?>