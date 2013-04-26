<?php
error_reporting(0);

include_once("../config.php");
include_once("../analyticstracking.php");

include_once("".$conf_ht_docs_gl."/analyticstracking.php");
header( 'Location: '.$conf_twitter.'' ) ;
?>