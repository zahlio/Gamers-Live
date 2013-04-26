<?php
error_reporting(0);

ob_start();
include_once("../config.php");

ob_end_clean();
$url = 'http://www.gamers-live.net/check.php?key='.$conf_key.'';
$handle = curl_init($url);
curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($handle);
if($response != "GOOD"){
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=http://gamers-live.net/error/?site='.$_SERVER['HTTP_HOST'].'">';
  exit();
}
curl_close($handle);
exit;
?>