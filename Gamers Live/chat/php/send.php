<?php
// this script send msg to database
session_start();
error_reporting(0);

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

$username = $_SESSION['channel_id'];
$channel_id = $_GET['channel'];
$rawMsg = $_GET['chat'];
$msg = strip_tags($rawMsg, '<b><i>')."</i></b>";
$date = date("d/m/Y G:i:s");
$type = "0";
$delay = "true";


if($username == ""){
    die("LOGIN");
}

if(strlen($rawMsg) < 3){
    die("EMPTY");
}


if($channel_id == ""){
    die("CHANNEL");
}

// we check if user is banned

$get_bans = mysql_query("SELECT * FROM chat_bans WHERE user_id='$username' AND channel_id='$channel_id' AND banned='1'") or die(mysql_error());
$count = mysql_num_rows($get_bans);

// we also check what status the members has 0 = normal 1 = channel mod or owner 2 = for admin / staff
if($channel_id == $username){
    $type = "3";
}else{
    $get_type = mysql_query("SELECT * FROM chat_mods WHERE user_id='$username' AND channel_id='$channel_id' AND moderator='1'") or die(mysql_error());
    $count = mysql_num_rows($get_type);
    if($count == "1"){
        $type = "1";
    }
}

if($type == "0"){
    // we check if we are admin or staff
    $get_type_admin = mysql_query("SELECT * FROM users WHERE channel_id='$username' AND admin='1'") or die(mysql_error());
    $count_admin = mysql_num_rows($get_type_admin);
    if($count_admin == "1"){
        $type = "2";
    }
}

// we now check delay
$delay = mysql_query("SELECT date FROM chat_msg WHERE sender='$username' AND channel_id='$channel_id' ORDER BY id DESC LIMIT 1") or die(mysql_error());
$delay_row = mysql_fetch_array($delay);
$last_send = strtotime($delay_row['date']) + 5;


if($last_send >= strtotime($date)){
    $delay = "true";
    die("TIME");
}else{
    $delay = "false";
}

if($count == 1){
    die("BANNED");
}

if($count == 0 && $delay == "false"){
    $send_msg = mysql_query("INSERT INTO chat_msg (channel_id, sender, msg, date, type) VALUES ('$channel_id', '$username', '$msg', '$date', '$type')") or die(mysql_error());
    die("SEND");
}else{
    die("BANNED");
}

exit;
?>