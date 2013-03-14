<?php

// we first get data from our mysql database
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

include_once("".$conf_site_url."/analyticstracking.php");
header( 'Location: '.$conf_twitter.'' ) ;
?>