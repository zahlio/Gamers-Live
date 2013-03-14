<?php
// delete all msg for a channel so we only have the 250 latest ones
// should be runned every hour

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

// first we need select all data from our channels db

$channels = mysql_query("SELECT * FROM channels") or die(mysql_error());

while($row = mysql_fetch_array($channels)){
    // we now count the msg of each channel
    $channel_id = $row['channel_id'];
    $chat_msg = mysql_query("SELECT * FROM chat_msg WHERE channel_id='$channel_id'") or die(mysql_error());
    // and we count
    $chat_msg_count = mysql_num_rows($chat_msg);
    // if we have more the 100 then we will delete

    if($chat_msg_count > 250){
        // we now delete all chat msg from that channel and leave the 25(1) newest.
        $amount = $chat_msg_count - 250;
        $chat_msg_delete = mysql_query("DELETE FROM chat_msg WHERE channel_id='$channel_id' LIMIT $amount") or die(mysql_error());
    }else{
        // we do nothing
    }
}

exit;
?>