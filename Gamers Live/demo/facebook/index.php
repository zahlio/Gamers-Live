<?php
error_reporting(0);


$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");
include_once("".$conf_ht_docs_gl."/analyticstracking.php");
header( 'Location: '.$conf_facebook.'' ) ;
?>