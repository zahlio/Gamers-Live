<?php
error_reporting(0);
session_start();

include_once("../../../config.php");
include_once("../../../analyticstracking.php");

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