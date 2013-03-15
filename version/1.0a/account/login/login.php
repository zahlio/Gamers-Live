<?php
// Starter session
session_start();

$password = $_POST['password'];
$email = $_POST['email'];
$link = $_POST['link'];


$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");

// select features streamer who is online / active
$result = mysql_query("SELECT * FROM users WHERE email='$email' AND password='$password'");

$row = mysql_fetch_array($result);
$count = mysql_num_rows($result);

$time = date("d/m-Y G:i:s");
$ip = $_SERVER['REMOTE_ADDR'];

$admin = $row['admin'];

$active = $row['active'];
// if we get 1 row we know its valid

if($active == "0"){
    header( 'Location: '.$conf_site_url.'/account/activate/?email='.$email.'' ) ;
}else{
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
                header("Location: ".$conf_site_url."/user/".$link."/");
            }else{
                header("Location: ".$conf_site_url."/account/?".SID);
            }

    }else{
        header( 'Location: '.$conf_site_url.'/account/login/?msg=The information entered was not correct, please try again' ) ;
    }
}


?>