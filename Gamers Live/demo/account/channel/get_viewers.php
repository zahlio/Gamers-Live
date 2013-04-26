<?php
error_reporting(0);
ob_start();
include_once("../../config.php");
include_once("../../analyticstracking.php");
ob_end_clean();

// this script returns the number of viewers for any chat
// also remember that the viewers tab are only updated every 1 min

$channel = $_GET['channel'];

// get all user details from this account
ob_start();

ob_end_clean();

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