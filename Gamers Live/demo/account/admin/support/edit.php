<?php
//error_reporting(0);
session_start();
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";

include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

// we first see what action  we are about to do

$title = mysql_real_escape_string(nl2br(strip_tags($_POST['title'])));
$msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));
$cat = mysql_real_escape_string(nl2br(strip_tags($_POST['cat'])));
$id = $_GET['id'];
$delete = $_GET['delete'];

if($delete == null){
    $update = mysql_query("UPDATE kbase SET title='$title', msg='$msg', cat='$cat' WHERE id='$id'") or die(mysql_error());
}else{
    $delete = mysql_query("DELETE FROM kbase WHERE id='$id'") or die(mysql_error());
}
// redict back to the ticket
header( 'Location: '.$conf_site_url.'/account/admin/support/') ;
exit;
?>