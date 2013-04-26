<?php
//error_reporting(0);
session_start();
include_once("../../../config.php");
include_once("../../../analyticstracking.php");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

// we first see what action  we are about to do

$title = mysql_real_escape_string(nl2br(strip_tags($_POST['title'])));
$msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));
$cat = mysql_real_escape_string(nl2br(strip_tags($_POST['cat'])));
$auther = $_SESSION['channel_id'];

// others
$date = date("d/m-Y G:i");
$ip = $_SERVER['REMOTE_ADDR'];

$insert = mysql_query("INSERT INTO kbase (title, auther, msg, dateSend, cat) VALUES ('$title', '$auther', '$msg', '$date', '$cat')") or die(mysql_error());

// redict back to the ticket
header( 'Location: '.$conf_site_url.'/account/admin/support/') ;
exit;
?>