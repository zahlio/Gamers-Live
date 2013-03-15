<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />
<title>Moderators</title>

<?php

session_start();

error_reporting(0);

include_once("".$conf_site_url."/analyticstracking.php");
if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$channel_id = $_GET['channel'];

// we first get data from our mysql database
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");

// connect to database


// select the database we need


// first we check if user is already banned
$accounts = mysql_query("SELECT * FROM chat_mods WHERE channel_id='$channel_id' AND moderator='1'") or die(mysql_error());
$total_banned = mysql_num_rows($accounts);

echo '<center>';
echo '<div class="styled_table table_white">';
echo '<table border="1">';
echo '<tr>';
echo "<th>Username</th>";
echo "<th>Remove</th>";
echo '</tr>';
while($row = mysql_fetch_array($accounts))
{
    echo '<tr>';
    echo "<td>".$row['user_id']."</td>";
    echo "<td><a href='un_mod.php?user=".$row['user_id']."&channel=".$channel_id."'>REMOVE</a></td>";
    echo '</tr>';
}

echo '</table>';
echo '</div>';

echo 'Total Moderators on this channel: ';
echo $total_banned;

?>
