<?php
// this script returns the number of viewers for any chat
// also remember that the viewers tab are only updated every 1 min

$channel = $_GET['channel'];

// get all user details from this account
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());
$result = mysql_query("SELECT * FROM channels WHERE channel_id='$channel'");
$row = mysql_fetch_array($result);

if($row['viewers'] >= 1){
echo $row['viewers'];
}else{
    echo '0';
}

?>