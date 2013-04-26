<?php
error_reporting(0);
include_once("../../config.php");
include_once("../../analyticstracking.php");

session_start(); 
session_destroy();
header( 'Location: '.$conf_site_url.'/account/login/?msg=You have been logged out' ) ;	
exit;
?>