<?php
session_start();

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: http://www.gamers-live.net/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$ads = $_POST['ads'];
$tips = $_POST['tips'];
$partner_id = $_POST['streamer'];
$email = $_POST['email'];
$tran_id = $_POST['tran_id'];
$month = $_POST['month'];
$send_date = date("j/n/Y");

$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

// we first make the new payment
$insert_payment = mysql_query("INSERT INTO partner_payments (partner_channel_id, ads_amount, tips_amount, for_month, skrill_trans_id, to_email, send_date) VALUES ('$partner_id', '$ads', '$tips', '$month', '$tran_id', '$email', '$send_date')") or die(mysql_error());

// then we update the payments for that streamer to be processed
$update_payment = mysql_query("UPDATE partner_payments_to_do SET done='1' WHERE partner_id='$partner_id'") or die(mysql_error());

die("<center><br><br><br>The payment data was updated<br><br><a href='http://www.gamers-live.net/account/admin/payments/'>GO BACK</a></center>");
?>