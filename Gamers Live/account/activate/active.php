<?php

$email = $_GET['email'];

$email_key = $_GET['key'];

// we first get data from our mysql database
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

// connect to database

			
// select thje database we need


$update = mysql_query("UPDATE users SET active='1' WHERE email='$email' AND activate_id='$email_key'");

	header( 'Location: '.$conf_site_url.'/account/login/?msg=Your account is now active and you may now login!' ) ;

?>