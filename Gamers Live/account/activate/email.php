<?php
// first get email we need to send to

$email = $_GET['email'];

// then we update the data base with a key that the user needs to confirm

$email_key = time();

// we now update the database for this email

// we first get data from our mysql database
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
// select thje database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());

$update = mysql_query("UPDATE users SET activate_id='$email_key' WHERE email='$email' AND active='0'");

$data = mysql_query("SELECT * FROM users WHERE email='$email'");
$row = mysql_fetch_array($data);

$display_name = $row['display_name'];

// we now send the email

$modtager = $email; //Hvem skal have mailen?
$emne = "Gamers Live Activation Email"; //Emnefeltet

$besked = "Hello ".$display_name.",<br>
<br>
You have recently signed up for a GAMERS LIVE account. And to use this account you need to confirm your email.<br><br>
This is done by clicking the link: <a href='http://www.gamers-live.net/account/activate/active.php?email=".$email."&key=".$email_key."'>Confirm Email</a><br>
<br>
Should you not have performed this action you can completely ignore this email.<br>
<br>
Best Regards,<br>
Gamers Live";

$header  = "MIME-Version: 1.0" . "\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$header .= "from:admin@gamers-live.net";

mail($modtager, $emne, $besked, $header); //Send!!

header( 'Location: http://www.gamers-live.net/account/activate/?email='.$email.'' ) ;	
?>