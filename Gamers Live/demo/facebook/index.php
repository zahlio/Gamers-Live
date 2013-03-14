<?php
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");
include_once("".$conf_site_url."/analyticstracking.php");
header( 'Location: '.$conf_facebook.'' ) ;
?>