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

$game = $_POST['game'];
$img = $_POST['img'];
$short = $_POST['short'];

$insert = mysql_query("INSERT INTO games (game, viewers, img, short) VALUES ('$game', '0', '$img', '$short')")or die(mysql_error());

// we now close the window
echo '<a href="javascript:window.close()">The game was added.. CLOSE WINDOW</a>';

?>