<?php
error_reporting(0);
session_start();

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$game = $_GET['game'];

// we now delete that game
$delete = mysql_query("DELETE FROM games WHERE game='$game'") or die(mysql_error());

header( 'Location: '.$conf_site_url.'/account/admin/games/?msg=The game was deleted' ) ;
exit;
?>