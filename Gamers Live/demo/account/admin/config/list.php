

<?php
error_reporting(0);


session_start();

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");

if ($_SESSION['access'] != true && $_SESSION['admin'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

// first we check if user is already banned
$accounts = mysql_query("SELECT * FROM users WHERE admin='1'") or die(mysql_error());
$total_admin = mysql_num_rows($accounts);

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
    echo "<td>".$row['channel_id']."</td>";
    echo "<td><a href='removeAdmin.php?user=".$row['channel_id']."'>Remove</a></td>";
    echo '</tr>';
}

echo '</table>';
echo '</div>';

echo 'Total admins on the site: ';
echo $total_admin;

?>
<link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />
<title>Admins</title>