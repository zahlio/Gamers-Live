<?php
// first get email we need to send to

$email = $_GET['email'];

// then we update the data base with a key that the user needs to confirm

$email_key = time();

// we now update the database for this email

// we first get data from our mysql database
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);

// connect to database

			
// select thje database we need


$update = mysql_query("UPDATE users SET activate_id='$email_key' WHERE email='$email' AND active='0'");

$data = mysql_query("SELECT * FROM users WHERE email='$email'");
$row = mysql_fetch_array($data);

$display_name = $row['display_name'];

// we now send the email

$modtager = $email; //Hvem skal have mailen?
$emne = "".$conf_site_name." Activation Email"; //Emnefeltet

$besked = "Hello ".$display_name.",<br>
<br>
You have recently signed up for a ".$conf_site_name." account. And to use this account you need to confirm your email.<br><br>
This is done by clicking the link: <a href='".$conf_site_url."/account/activate/active.php?email=".$email."&key=".$email_key."'>Confirm Email</a><br>
<br>
Should you not have performed this action you can completely ignore this email.<br>
<br>
Best Regards,<br>
".$conf_site_name."";

$header  = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$header .= "from:".$conf_email."";

mail($modtager, $emne, $besked, $header); //Send!!

header( 'Location: '.$conf_site_url.'/account/activate/?email='.$email.'' ) ;	
?>