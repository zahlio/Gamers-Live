<?php
// Database info
$database_url = "127.0.0.1";
$database_user = "root";
$database_pw = "";

// Information
$conf_site_name = "Gamers Live";
$conf_site_url = "http://www.gamers-live.net";
$conf_site_copy = "&copy; 2011 GAMERS LIVE. An Gamers Live production. All Rights Reserved.";


// DO NOT CHANGE!

// connect to database
$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());

// select the database we need
$select_db = mysql_select_db("live", $connect) or die(mysql_error());
?>