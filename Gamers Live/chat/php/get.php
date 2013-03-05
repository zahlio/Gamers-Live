<?php
// this scripts returns the last 100 msg for a channel and returns them
error_reporting(0);

$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

$channel_id = $_GET['channel'];

$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

$select_db = mysql_select_db("live", $connect) or die(mysql_error());


$get_msg = mysql_query("SELECT * FROM chat_msg WHERE channel_id='$channel_id' ORDER BY id") or die(mysql_error());

while($row = mysql_fetch_array($get_msg)){
    $username = $row['sender'];
    $msg = $row['msg'];
    $date = $row['date'];
    $type = $row['type'];
    if($type == "0"){
        $type_msg = " ";
    }
    if($type == "1"){
        $type_msg = " MOD - ";
    }
    if($type == "2"){
        $type_msg = " STAFF - ";
    }
    if($type == "3"){
        $type_msg = " OWNER - ";
    }

    echo '<img src="http://www.gamers-live.net/user/'.$username.'/avatar.png" alt="'.$username.'" height="15" width="15"><i>'.$type_msg.'</i><b><a href="http://www.gamers-live.net/account/channel/chat/ban.php?username='.$username.'&channel='.$channel_id.'" target="_blank" title="'.$date.'">'.$username.'</a></b>: '.$msg.'<br>';
}
exit;
?>