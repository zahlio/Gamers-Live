<?php
//error_reporting(0);
session_start();
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";

include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");

if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to comment' ) ;
    exit;
}

// we first see what action  we are about to do

$auther = $_SESSION['channel_id'];
$id = $_GET['id'];
$channel_id = $_SESSION['channel_id'];
$msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));

$date = date("d/m-Y G:i");


$insert = mysql_query("INSERT INTO event_comments (auther, msg, dateSend, event_id) VALUES ('$auther', '$msg', '$date', '$id')") or die(mysql_error());


// redict back to the ticket
header( 'Location: '.$conf_site_url.'/events/view/?id='.$id ) ;
exit;
?>