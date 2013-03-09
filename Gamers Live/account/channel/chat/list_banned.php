<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />
    <title>Bannned Chat User</title>

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
include_once($inc_path);

$dir_name = basename(__DIR__);

// connect to database


// select the database we need


// first we check if user is already banned
$accounts = mysql_query("SELECT * FROM chat_bans WHERE channel_id='$channel_id' AND banned='1'") or die(mysql_error());
$total_banned = mysql_num_rows($accounts);

echo '<center>';
echo '<div class="styled_table table_white">';
echo '<table border="1">';
echo '<tr>';
echo "<th>Username</th>";
echo "<th>Reason</th>";
echo "<th>Banned to</th>";
echo "<th>Unban</th>";
echo '</tr>';
while($row = mysql_fetch_array($accounts))
{
    echo '<tr>';
    echo "<td>".$row['user_id']."</td>";
    echo "<td>".$row['reason']."</td>";
    echo "<td>".$row['banned_until']."</td>";
    echo "<td><a href='un_ban.php?user=".$row['user_id']."&channel=".$channel_id."'>Unban User</a></td>";
    echo '</tr>';
}

echo '</table>';
echo '</div>';

echo 'Total users banned on this channel: ';
echo $total_banned;

?>
