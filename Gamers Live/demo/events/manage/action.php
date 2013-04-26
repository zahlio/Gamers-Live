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

if($_SESSION['admin'] != true){
    if($_SESSION['channel_id'] != $eventsRow['auther']){
        header( 'Location: '.$conf_site_url.'/account/login/?msg=Please login to the event owners account to edit the event' ) ;
        exit;
    }
}

// big box
if($_GET['change'] == "1"){
    $title = mysql_real_escape_string(nl2br(strip_tags($_POST['title'])));
    $msg = mysql_real_escape_string(nl2br(strip_tags($_POST['msg'])));

    $update = mysql_query("UPDATE events SET msg='$msg', title = '$title' WHERE id='$id'") or die(mysql_error());
}

// small box
if($_GET['change'] == "2"){

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

    $endDate = mktime($endhour, $endmin, 0, $endmonth, $endday, $endyear);

    $img = $_POST['img'];

    if($_SESSION['admin'] == true){

        $frontday = $_POST['frontday'];
        $frontmonth = $_POST['frontmonth'];
        $frontyear = $_POST['frontyear'];
        $fronthour = $_POST['fronthour'];
        $frontmin = $_POST['frontmin'];

        $frontDate = mktime($fronthour, $frontmin, 0, $frontmonth, $frontday, $frontyear);

        $featured = $_POST['featured'];



        // mysql string

        $update = mysql_query("UPDATE events SET endDate = '$endDate', channel = '$channel', featured='$featured', startDate = '$startDate', img='$img', game = '$game', featuredShow = '$frontDate' WHERE id='$id'") or die(mysql_error());
    }else{
        $update = mysql_query("UPDATE events SET endDate = '$endDate', channel = '$channel', startDate = '$startDate', img='$img', game = '$game' WHERE id='$id'") or die(mysql_error());
    }

}

// delete

if($_GET['delete'] == "1"){
    $delete = mysql_query("DELETE FROM events WHERE id='$id'") or die(mysql_error());
}

if($_GET['deleteComment'] == "1"){
    $delete = mysql_query("DELETE FROM event_comments WHERE id='$id'") or die(mysql_error());
}

header( 'Location: '.$conf_site_url.'/events/manage/') ;
exit;

?>