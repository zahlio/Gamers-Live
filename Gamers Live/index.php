<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gamers Live</title>
<link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
</head>

<?php
error_reporting(0);
include_once("".$conf_site_url."/analyticstracking.php");
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
?>
<style>
	.beta_img {
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  margin-top: -158px;
	  margin-left: -351px;
	}
	.beta_footer {
	  position: fixed;
	  top: 95%;
	  color: #FFF;
	  font-size:12px;
	}
	.beta_but {
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  margin-top: 200px;
	  margin-left: -221px;	
	}
</style>
<body background="<?=$conf_site_url?>/beta_bg.png">
    <a href="http://gamers-live.net/blog/987">
    	<img src="<?=$conf_site_url?>/beta_img.png" class="beta_img"/>
    </a>
    <a href="<?=$conf_site_url?>/ind.php">
    <img src="<?=$conf_site_url?>/beta_but.png" class="beta_but"/>
    </a>
    
<p class="beta_footer">
<font face="Lucida Sans Unicode, Lucida Grande, sans-serif">
All trademarks referenced herein are the properties their respective owners. <br />
©2013 Gamers Live. All rights reserved.
</p>
</body>
</html>
