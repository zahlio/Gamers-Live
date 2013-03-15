<?php
	
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_site_url."/files/check.php");

// connect to database


// select thje database we need


$time = date("d/m-Y G:i");

// get all live viewers
$live_viewers = mysql_query("SELECT SUM(viewers) AS viewers_sum FROM channels") or die(mysql_error());
$live_viewers_row = mysql_fetch_assoc($live_viewers);
$live_viewers_total = $live_viewers_row['viewers_sum'];

	// then we log it
	$live_viewers_log = mysql_query("INSERT INTO admin_logs (type, date, amount) VALUES ('live_viewers', '$time', '$live_viewers_total')") or die(mysql_error());
	
// get total online live streamers
$live_streams =  mysql_query("SELECT * FROM channels WHERE online='Online'") or die(mysql_error());
$live_streams_count = mysql_num_rows($live_streams);

	// then we log it
	$live_streams_log = mysql_query("INSERT INTO admin_logs (type, date, amount) VALUES ('live_streams', '$time', '$live_streams_count')") or die(mysql_error());
	
// get total views
$live_views = mysql_query("SELECT SUM(views) AS views_sum FROM channels") or die(mysql_error());
$live_views_row = mysql_fetch_assoc($live_views);
$live_views_total = $live_views_row['views_sum'];

	// then we log it
	$live_views_log = mysql_query("INSERT INTO admin_logs (type, date, amount) VALUES ('live_views', '$time', '$live_views_total')") or die(mysql_error());

// get total number of members
$total_members = mysql_query("SELECT * FROM channels") or die(mysql_error());
$total_members_count = mysql_num_rows($total_members);

	// then we log it
	$total_members_log = mysql_query("INSERT INTO admin_logs (type, date, amount) VALUES ('total_members', '$time', '$total_members_count')") or die(mysql_error());

exit;
?>