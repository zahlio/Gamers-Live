<?php
// Starter session
session_start();

$password = $_POST['password'];
$email = $_POST['email'];
$link = $_POST['link'];


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

$time = date("d/m-Y G:i:s");
$ip = $_SERVER['REMOTE_ADDR'];

$admin = $row['admin'];

$active = $row['active'];
// if we get 1 row we know its valid

if($active == 1){
	if($count == 1){
		// login log
		$login_log_insert = mysql_query("INSERT INTO login_log (email, password, time, ip) VALUES ('$email', '$password', '$time', '$ip')") or die(mysql_error());
		
		// we are logged in and we will create a session etc
			// set to admin if admin is true
			if($admin == 1){
				$_SESSION['admin'] = true;	
			}
		$_SESSION['access'] = true;
		$_SESSION['email'] = $email;
		$_SESSION['channel_id'] = $row['channel_id'];
        if($link != null){
            header("Location: http://www.gamers-live.net/user/".$link."/");
        }else{
		    header("Location: http://www.gamers-live.net/account/?".SID);
        }
		
	}else{
		header( 'Location: http://www.gamers-live.net/account/login/?msg=The information entered was not correct, please try again' ) ;	
	}
}else{
	header( 'Location: http://www.gamers-live.net/account/activate/?email='.$email.'' ) ;	
}
			
?>