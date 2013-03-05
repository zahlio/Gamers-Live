<?php
// clear the chat history
// should be run 1 time a day

$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

$select_db = mysql_select_db("live", $connect) or die(mysql_error());

$clear_table = mysql_query('TRUNCATE TABLE chat_msg;') or die(mysql_error());

if($clear_table){
    die("Chat history was deleted");
}
exit;
?>