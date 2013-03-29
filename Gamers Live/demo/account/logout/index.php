<?php
error_reporting(0);


$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");

session_start(); 
session_destroy();
header( 'Location: '.$conf_site_url.'/account/login/?msg=You have been logged out' ) ;	
exit;
?>