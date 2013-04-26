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

$sub_channel_id = $_GET['channel'];



// we first check if we not already are subscribed
$check = mysql_query("SELECT * FROM subscribtions WHERE fan_channel_id='$channel_id' AND owner_channel_id='$sub_channel_id'");
$count = mysql_num_rows($check);
			
if($count == 0){		
$result = mysql_query("INSERT INTO subscribtions (fan_channel_id, owner_channel_id, date) VALUES ('$channel_id', '$sub_channel_id', '$date')");
header( 'Location: '.$conf_site_url.'/account/' ) ;
}else{
	header( 'Location: '.$conf_site_url.'/account/login/?msg=You are already subscribed to this channel' ) ;	
}
			
?>