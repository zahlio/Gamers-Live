<?php
session_start();

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$ads = $_POST['ads'];
$tips = $_POST['tips'];
$partner_id = $_POST['streamer'];
$email = $_POST['email'];
$tran_id = $_POST['tran_id'];
$month = $_POST['month'];
$send_date = date("j/n/Y");

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

// connect to database


// select the database we need


// we first make the new payment
$insert_payment = mysql_query("INSERT INTO partner_payments (partner_channel_id, ads_amount, tips_amount, for_month, skrill_trans_id, to_email, send_date) VALUES ('$partner_id', '$ads', '$tips', '$month', '$tran_id', '$email', '$send_date')") or die(mysql_error());

// then we update the payments for that streamer to be processed
$update_payment = mysql_query("UPDATE partner_payments_to_do SET done='1' WHERE partner_id='$partner_id'") or die(mysql_error());

die("<center><br><br><br>The payment data was updated<br><br><a href='<?=$conf_site_url?>/account/admin/payments/'>GO BACK</a></center>");
?>