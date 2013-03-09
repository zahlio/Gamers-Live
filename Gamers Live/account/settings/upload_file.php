<?php
session_start();

if ($_SESSION['access'] != true) {
	header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;	
	exit;
}
$email = $_SESSION['email'];
$channel_id = $_SESSION['channel_id'];

$file = $_FILES['file'];

$id = $_GET["id"];

if($id == "avatar"){
$allowedExts = array("png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 125000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {	
	// we will first delete the old file
	unlink("c:/xampp/htdocs/user/".$channel_id."/avatar.png");	
	// then we can move the file
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "c:/xampp/htdocs/user/".$channel_id."/avatar.png");
      header( 'Location: '.$conf_site_url.'/account/settings/?') ;	
    }
  }
else
  {
  echo "Invalid file";
  }
}

if($id == "header"){
$allowedExts = array("png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 125000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {	
	// we will first delete the old file
	unlink("c:/xampp/htdocs/user/".$channel_id."/header.png");	
	// then we can move the file
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "c:/xampp/htdocs/user/".$channel_id."/header.png");
      header( 'Location: '.$conf_site_url.'/account/settings/?') ;	
    }
  }
else
  {
  echo "Invalid file";
  }
}

if($id == "offline_img"){
$allowedExts = array("png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 125000)
&& ($_FILES["file"]["size"] < 125000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {	
	// we will first delete the old file
	unlink("c:/xampp/htdocs/user/".$channel_id."/offline_img.png");	
	// then we can move the file
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "c:/xampp/htdocs/user/".$channel_id."/offline_img.png");
      header( 'Location: '.$conf_site_url.'/account/settings/?') ;	
    }
  }
else
  {
  echo "Invalid file";
  }
}



	
?>