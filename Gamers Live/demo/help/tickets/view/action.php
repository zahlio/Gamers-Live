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

$close = $_GET['close'];
$open = $_GET['open'];
$reply = $_GET['reply'];
$id = $_GET['id'];
$channel_id = $_SESSION['channel_id'];
$msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));
$owner = $_POST['owner'];

// vars for reply
$staff = "0";
$date = date("d/m-Y G:i");
$ip = $_SERVER['REMOTE_ADDR'];
$status = "open";

if($reply == "1"){
    // we will now add a reply to the ticket
    $insert = mysql_query("INSERT INTO tickets (owner, title, msg, isTicket, isReply, replySender, originTicketID, isStaff, dateSend, ip, status) VALUES ('$owner', '0', '$msg', '0', '1', '$channel_id', '$id', '$staff', '$date', '$ip', '$status')") or die(mysql_error());
}

if($close == "1"){
    // we will then set the tickets status to "closed"

    $close = mysql_query("UPDATE tickets SET status='closed' WHERE owner='$channel_id' AND id='$id'") or die(mysql_error());
}


if($open == "1"){
    // we will then set the tickets status to "closed"

    $close = mysql_query("UPDATE tickets SET status='open' WHERE owner='$channel_id' AND id='$id'") or die(mysql_error());
}

// redict back to the ticket
header( 'Location: '.$conf_site_url.'/help/tickets/view/?id='.$id ) ;
exit;
?>