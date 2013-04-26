<?php
error_reporting(0);
include_once("../../../config.php");
include_once("../../../analyticstracking.php");


session_start();



include_once("".$conf_ht_docs_gl."/analyticstracking.php");
if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$channel_id = $_GET['channel'];
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
<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />
<title>Moderators</title>
