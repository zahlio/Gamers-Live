<?php

$email = $_GET['email'];

$email_key = $_GET['key'];

// we first get data from our mysql database
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

$update = mysql_query("UPDATE users SET active='1' WHERE email='$email' AND activate_id='$email_key'");

	header( 'Location: http://www.gamers-live.net/account/login/?msg=Your account is now active and you may now login!' ) ;

?>