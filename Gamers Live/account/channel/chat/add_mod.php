<?php

session_start();

error_reporting(0);

include_once("http://www.gamers-live.net/analyticstracking.php");
if ($_SESSION['access'] != true) {
    header( 'Location: http://www.gamers-live.net/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

$dir_name = basename(__DIR__);

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

$login_name = $_SESSION['channel_id'];

$mod_name = $_POST['mod'];
$channel_id = $_POST['channel'];

// now we check the database

// we need to see if user is mod
$get_auth_user = mysql_query("SELECT * FROM chat_mods WHERE user_id='$login_name' AND channel_id='$channel_id'") or die(mysql_error());
$get_auth_rows_user = mysql_fetch_array($get_auth_user);

if(($get_auth_rows_user['admin'] == "1") || ($login_name == $channel_id)){
    $is_admin = true;
}else{
    header( 'Location: http://www.gamers-live.net/account/channel/chat/ban.php?channel='.$channel_id.'&msg=You are not allowed to add moderators on this channel' ) ;
    exit;
}

if($is_admin == true){
    // we add moderator
    $add_mod = mysql_query("INSERT INTO chat_mods (channel_id, user_id, moderator) VALUES ('$channel_id', '$mod_name', '1')") or die(mysql_error());
    header( 'Location: http://www.gamers-live.net/account/channel/chat/ban.php?channel='.$channel_id.'&msg=You have added a new moderator to the chat of your channel' ) ;
    exit;
}else{
    header( 'Location: http://www.gamers-live.net/account/channel/chat/ban.php?channel='.$channel_id.'&msg=You are not allowed to add moderators on this channel' ) ;
    exit;
}

?>