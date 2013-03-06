<link href="http://www.gamers-live.net/style.css" media="screen" rel="stylesheet" type="text/css" />
<title>Chat Moderators</title>
<?php

session_start();

error_reporting(0);

include_once("http://www.gamers-live.net/analyticstracking.php");
if ($_SESSION['access'] != true) {
    header( 'Location: http://www.gamers-live.net/account/login/?msg=Please login to view this page' ) ;
    exit;
}

// we first get data from our mysql database
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

$mod_name = $_SESSION['channel_id'];

$username = $_GET['user'];

$channel_id = $_GET['channel'];


if($mod_name == $channel_id){
    $can_ban = true;
}

$staff_check = mysql_query("SELECT * FROM channels WHERE channel_id='$mod_name' AND admin='1'");
$staff_check_count = mysql_num_rows($staff_check);
if($staff_check_count == 1){
    $can_ban = true;
}


if($can_ban == true){
    // we will unban
    $unban = mysql_query("UPDATE chat_mods SET moderator='0' WHERE channel_id='$channel_id' AND user_id='$username'") or die(mysql_error());
    $msg = 'You have removed '.$username.' as a moderator';
}else{
    $msg = 'You cannot delete moderators on this channel.';
}
?>
<center><h3><?=$msg?></h3></center>