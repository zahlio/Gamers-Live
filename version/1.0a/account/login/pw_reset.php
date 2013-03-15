<?php

// we will now reset the password for the email and send the new password to that email

$email = $_POST['email'];

if($email == null){
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please try to reset the password again' );
}

if($email == ""){
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please try to reset the password again' );
}

if(strpos($email,'@') == false){
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please enter a valid email' );
}
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");


$new_pw = rand(10000000, 90000000);

$update_pw = mysql_query("UPDATE users SET password='$new_pw' WHERE email='$email' AND pw_reset='1'") or die(mysql_error());

$get_info = mysql_query("SELECT * FROM users WHERE email='$email'") or die(mysql_error());
$row = mysql_fetch_array($get_info);

$display_name = $row['display_name'];

// we now send the new pw as a email

$emne = "".$conf_site_name." Password Reset"; //Emnefeltet

$besked = "Hello ".$display_name.",<br>
<br>
You have recently requested a password reset for your account with email: ".$email."<br><br>
Your new password for this account is: ".$new_pw."<br>
<br>
Should you not have performed this action please contact support and we can disable this feature for your account.<br>
<br>
Best Regards,<br>
".$conf_site_name."";

$header  = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$header .= "from:".$conf_email.";

mail($email, $emne, $besked, $header); //Send!!

header( 'Location: '.$conf_site_url.'/account/login/?msg=Your password was successfully reset, and we have emailed the new one to '.$email.'' );
?>