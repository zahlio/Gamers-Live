<?php

// we will now reset the password for the email and send the new password to that email

$email = $_POST['email'];

if($email == null){
    header( 'Location: http://www.gamers-live.net/account/login/?msg=Please try to reset the password again' );
}

if($email == ""){
    header( 'Location: http://www.gamers-live.net/account/login/?msg=Please try to reset the password again' );
}

if(strpos($email,'@') == false){
    header( 'Location: http://www.gamers-live.net/account/login/?msg=Please enter a valid email' );
}
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

$new_pw = rand(10000000, 90000000);

$update_pw = mysql_query("UPDATE users SET password='$new_pw' WHERE email='$email' AND pw_reset='1'") or die(mysql_error());

$get_info = mysql_query("SELECT * FROM users WHERE email='$email'") or die(mysql_error());
$row = mysql_fetch_array($get_info);

$display_name = $row['display_name'];

// we now send the new pw as a email

$emne = "Gamers Live Password Reset"; //Emnefeltet

$besked = "Hello ".$display_name.",<br>
<br>
You have recently requested a password reset for your account with email: ".$email."<br><br>
Your new password for this account is: ".$new_pw."<br>
<br>
Should you not have performed this action please contact support and we can disable this feature for your account.<br>
<br>
Best Regards,<br>
Gamers Live";

$header  = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$header .= "from:admin@gamers-live.net";

mail($email, $emne, $besked, $header); //Send!!

header( 'Location: http://www.gamers-live.net/account/login/?msg=Your password was successfully reset, and we have emailed the new one to '.$email.'' );
?>