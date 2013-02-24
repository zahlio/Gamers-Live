<?php
// Starter session
error_reporting(0);

$password = $_POST['password'];
$email = $_POST['email'];


$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";
			
// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());
			
// select features streamer who is online / active
$result = mysql_query("SELECT * FROM users WHERE email='$email' AND password='$password'");
$row = mysql_fetch_array($result);
$count = mysql_num_rows($result);
$channel_id = $row['channel_id'];

$active = $row['active'];
// if we get 1 row we know its valid

if($active == 1){
	if($count == 1){
		// we are loged in and we will create a session etc
			//we now get the stream key for the user
			$result_channel = mysql_query("SELECT * FROM channels WHERE channel_id='$channel_id'");
			$row_channel = mysql_fetch_array($result_channel);
			$stream_key = $row_channel['stream_key'];
			
			die("".$channel_id."/?streamKey=".$stream_key."/".$channel_id."");
		
	}else{
		die("FAIL");
	}
}else{	
	die("FAIL");
}
			
?>