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

// now we will set the viewers of the games from the front page

// get viewers for all games

// lol
    $lol_get = mysql_query("SELECT SUM(viewers) as lolSum FROM channels WHERE game='League Of Legends'");
    $lol_row = mysql_fetch_array($lol_get);
    $lol_viewers = $lol_row['lolSum'] + 0;
    $update_lol_viewers = mysql_query("UPDATE frontpage SET lol='$lol_viewers' WHERE id='1'") or die(mysql_error());

// dota 2
    $dota2_get = mysql_query("SELECT SUM(viewers) as dota2Sum FROM channels WHERE game='Dota 2'");
    $dota2_row = mysql_fetch_array($dota2_get);
    $dota2_viewers = $dota2_row['dota2Sum'] + 0;
    $update_dota_viewers = mysql_query("UPDATE frontpage SET dota2='$dota2_viewers' WHERE id='1'") or die(mysql_error());

// hon
    $hon_get = mysql_query("SELECT SUM(viewers) as honSum FROM channels WHERE game='Heroes Of Newerth'");
    $hon_row = mysql_fetch_array($hon_get);
    $hon_viewers = $hon_row['hon2Sum'] + 0;
    $update_hon_viewers = mysql_query("UPDATE frontpage SET hon='$hon_viewers' WHERE id='1'") or die(mysql_error());

// sc2
    $sc2_get = mysql_query("SELECT SUM(viewers) as dota2Sum FROM channels WHERE game='Starcraft 2'");
    $sc2_row = mysql_fetch_array($sc2_get);
    $sc2_viewers = $sc2_row['sc2Sum'] + 0;
    $update_sc2_viewers = mysql_query("UPDATE frontpage SET sc2='$sc2_viewers' WHERE id='1'") or die(mysql_error());

// wow
    $wow_get = mysql_query("SELECT SUM(viewers) as wow2Sum FROM channels WHERE game='World Of Warcraft'");
    $wow_row = mysql_fetch_array($wow_get);
    $wow_viewers = $wow_row['wowSum'] + 0;
    $update_wow_viewers = mysql_query("UPDATE frontpage SET wow='$wow_viewers' WHERE id='1'") or die(mysql_error());

// cod
    $cod_get = mysql_query("SELECT SUM(viewers) as codSum FROM channels WHERE game='Call Of Duty'");
    $cod_row = mysql_fetch_array($cod_get);
    $cod_viewers = $cod_row['codSum'] + 0;
    $update_cod_viewers = mysql_query("UPDATE frontpage SET cod='$cod_viewers' WHERE id='1'") or die(mysql_error());

// minecraft
    $minecraft_get = mysql_query("SELECT SUM(viewers) as minecraftSum FROM channels WHERE game='Minecraft'");
    $minecraft_row = mysql_fetch_array($minecraft_get);
    $minecraft_viewers = $minecraft_row['minecraftSum'] + 0;
    $update_mine_viewers = mysql_query("UPDATE frontpage SET mine='$minecraft_viewers' WHERE id='1'") or die(mysql_error());

// other
    $other_get = mysql_query("SELECT SUM(viewers) as otherSum FROM channels WHERE game='Other'");
    $other_row = mysql_fetch_array($other_get);
    $other_viewers = $other_row['otherSum'] + 0;
    $update_other_viewers = mysql_query("UPDATE frontpage SET other='$other_viewers' WHERE id='1'") or die(mysql_error());

exit;
?>