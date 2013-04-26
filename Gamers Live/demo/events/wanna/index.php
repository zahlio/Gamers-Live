<?php
error_reporting(0);
include_once("../../config.php");
include_once("../../analyticstracking.php");
session_start();

$id = $_GET['id'];

if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to comment' ) ;
    exit;
}
$sub = $_GET['sub'];
$viewer = $_SESSION['channel_id'];
$ip = $_SERVER['REMOTE_ADDR'];
$start = $_GET['time'];

if($sub == 1){
    // we sub the user
    $sub = mysql_query("INSERT INTO event_wanna (event_id, viewer, ip, startDate) VALUES ('$id', '$viewer', '$ip', '$start')") or die(mysql_error());
}

// redict back to the ticket
header( 'Location: '.$conf_site_url.'/events/view/?id='.$id ) ;
exit;
?>