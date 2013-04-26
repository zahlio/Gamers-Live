<?php
error_reporting(0);

include_once("../../config.php");
include_once("../../analyticstracking.php");

$email = $_GET['email'];

$email_key = $_GET['key'];

$update = mysql_query("UPDATE users SET active='1' WHERE email='$email' AND activate_id='$email_key'");

	header( 'Location: '.$conf_site_url.'/account/login/?msg=Your account is now active and you may now login!' ) ;

?>