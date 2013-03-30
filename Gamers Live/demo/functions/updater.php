<?php
error_reporting(0);


// in the first part we will update offline and online for all channels.
// this script checks if a stream is online and updates the value in the database.

// we first get data from our mysql database
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");

$dir_name = basename(__DIR__);

// we then select the streams (that are offline) we want to update to online first

$streams = mysql_query("SELECT * FROM channels") or die(mysql_error());
// we now have selected all the streams that in our db.

while($streams_row = mysql_fetch_array($streams))
{
    // vars
    $channel_id = $streams_row['channel_id'];
    $SessionsFlash = null;

    $ch = curl_init('http://'.$conf_connec_user.':'.$conf_connec_pw.'@'.$conf_connec_host.':8086/connectioncounts');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
    $xml = curl_exec($ch);

    $dom = new DOMDocument();
    @$dom->loadXML($xml);
    $xpath = new DOMXPath($dom);
    $items = $xpath->query('/WowzaMediaServer/VHost/Application[Name="' . $channel_id . '"]/ApplicationInstance/Stream[Name="' . $channel_id . '"]');
    for ($i = 0; $i < $items->length; $i++)
    {
        $temp = $xpath->query('SessionsFlash', $items->item($i));
        $SessionsFlash = $temp->item(0)->nodeValue;
    }

    $viewers = $SessionsFlash + 0;

    if($SessionsFlash != null)
    {
        // the stream is online
        $set_online = mysql_query("UPDATE channels SET online='Online', viewers='$viewers' WHERE channel_id='$channel_id'") or die (mysql_error());

        // we will now count the actual number of subscribers and update the database
        $sub_count = mysql_query("SELECT * FROM subscribtions WHERE owner_channel_id='$channel_id'");
        $sub_real_count = mysql_num_rows($sub_count);
        // now update the value in the users tab
        $update_sub = mysql_query("UPDATE channels SET subscribers='$sub_real_count' WHERE channel_id='$channel_id'");

    }else{
        // the stream is offline
        $set_offline = mysql_query("UPDATE channels SET online='Offline', viewers='$viewers' WHERE channel_id='$channel_id'") or die (mysql_error());

        // we will now count the actual number of subscribers and update the database
        $sub_count = mysql_query("SELECT * FROM subscribtions WHERE owner_channel_id='$channel_id'");
        $sub_real_count = mysql_num_rows($sub_count);
        // now update the value in the users tab
        $update_sub = mysql_query("UPDATE channels SET subscribers='$sub_real_count' WHERE channel_id='$channel_id'");
    }
}

// get viewers for all games

// we first get all the games that the admin is listing

$games_get = mysql_query("SELECT * FROM games") or die(mysql_error());

while($games_row = mysql_fetch_array($games_get)){
    $game = $games_row['game'];
    $game_get = mysql_query("SELECT SUM(viewers) as gameSum FROM channels WHERE game='$game'") or die(mysql_error());
    $game_row = mysql_fetch_array($game_get);
    $this_game_viewers = $game_row['gameSum'] + 0;
    $update_games = mysql_query("UPDATE games SET viewers='$this_game_viewers' WHERE game='$game'") or die(mysql_error());
}

exit;
?>