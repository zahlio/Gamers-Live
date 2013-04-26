<?php
error_reporting(0);
include_once("../../config.php");
include_once("../../analyticstracking.php");
session_start();

if ($_SESSION['access'] != true) {
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to view this page' ) ;
    exit;
}

$id = $_GET['id'];

// we now echo that event wiht that id
$events = mysql_query("SELECT * FROM events WHERE id='$id'") or die(mysql_error());
$eventsRow = mysql_fetch_array($events);

if($_SESSION['channel_id'] != $eventsRow['auther'] && $_SESSION['admin'] != true){
    header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to the event owners account to edit the event' ) ;
    exit;
}

// big box
if($_GET['change'] == "1"){
    $title = mysql_real_escape_string(nl2br(strip_tags($_POST['title'])));
    $msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));

    $game = $_POST['game'];

    $Startday = $_POST['Startday'];
    $Startmonth = $_POST['Startmonth'];
    $Startyear = $_POST['Startyear'];
    $Starthour = $_POST['Starthour'];
    $Startmin = $_POST['Startmin'];

    $startDate = mktime($Starthour, $Startmin, 0, $Startmonth, $Startday, $Startyear);

    $endday = $_POST['endday'];
    $endmonth = $_POST['endmonth'];
    $endyear = $_POST['endyear'];
    $endhour = $_POST['endhour'];
    $endmin = $_POST['endmin'];

    $channel = $_POST['channel'];

    $username = $_SESSION['channel_id'];

    $endDate = mktime($endhour, $endmin, 0, $endmonth, $endday, $endyear);

    $img = $_POST['img'];

    $time = time();

    if($_SESSION['admin'] == true){

        $frontday = $_POST['frontday'];
        $frontmonth = $_POST['frontmonth'];
        $frontyear = $_POST['frontyear'];
        $fronthour = $_POST['fronthour'];
        $frontmin = $_POST['frontmin'];

        $frontDate = mktime($fronthour, $frontmin, 0, $frontmonth, $frontday, $frontyear);

        $featured = $_POST['featured'];

        // mysql string

        $update = mysql_query("INSERT INTO events (title, msg, auther, submitDate, endDate, views, channel, featured, startDate, img, game, featuredShow) VALUES ('$title', '$msg', '$username', '$time', '$endDate', '0', '$channel', '$featured', '$startDate', '$img', '$game', '$frontDate')") or die(mysql_error());
    }else{
        $update = mysql_query("INSERT INTO events (title, msg, auther, submitDate, endDate, views, channel, featured, startDate, img, game, featuredShow) VALUES ('$title', '$msg', '$username', '$time', '$endDate', '0', '$channel', '0', '$startDate', '$img', '$game', '0')") or die(mysql_error());
    }

}

header( 'Location: '.$conf_site_url.'/events/manage/') ;
exit;

?>