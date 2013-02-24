<?php
session_start();


if ($_SESSION['access'] != true) {
	header( 'Location: http://www.gamers-live.net/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];

$sub_channel_id = $_GET['channel'];

// we first get data from our mysql database
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

$date = date("m/d-Y"); 

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

// we first check if we not already are subscribed
$check = mysql_query("SELECT * FROM subscribtions WHERE fan_channel_id='$channel_id' AND owner_channel_id='$sub_channel_id'");
$count = mysql_num_rows($check);
			
if($count == 0){		
$result = mysql_query("INSERT INTO subscribtions (fan_channel_id, owner_channel_id, date) VALUES ('$channel_id', '$sub_channel_id', '$date')");
header( 'Location: http://www.gamers-live.net/account/' ) ;
}else{
	header( 'Location: http://www.gamers-live.net/account/login/?msg=You are already subscribed to this channel' ) ;	
}
			
?>