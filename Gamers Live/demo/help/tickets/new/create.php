<?php
error_reporting(0);
include_once("../../../config.php");
include_once("../../../analyticstracking.php");
session_start();

if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

// we first see what action  we are about to do

$title = mysql_real_escape_string(nl2br(strip_tags($_POST['title'])));
$msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));
$channel_id = $_POST['owner'];
$partner = $_POST['partner'];
$banned = $_POST['banned'];
$name = $_POST['name'];

// others
$staff = "0";
$date = date("d/m-Y G:i");
$ip = $_SERVER['REMOTE_ADDR'];
$status = "open";

$insert = mysql_query("INSERT INTO tickets (owner, title, msg, isTicket, isReply, replySender, originTicketID, isStaff, dateSend, ip, status, partner, banned, userName) VALUES ('$channel_id', '$title', '$msg', '1', '0', '0', '0', '$staff', '$date', '$ip', '$status', '$partner', '$banned', '$name')") or die(mysql_error());

// redict back to the ticket
header( 'Location: '.$conf_site_url.'/help/tickets/') ;
exit;
?>