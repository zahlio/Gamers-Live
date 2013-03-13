<?php
// this script returns the number of viewers for any chat
// also remember that the viewers tab are only updated every 1 min

$channel = $_GET['channel'];

// get all user details from this account
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

// connect to database


// select the database we need

$result = mysql_query("SELECT * FROM channels WHERE channel_id='$channel'");
$row = mysql_fetch_array($result);

if($row['viewers'] >= 1){
echo $row['viewers'];
}else{
    echo '0';
}

?>