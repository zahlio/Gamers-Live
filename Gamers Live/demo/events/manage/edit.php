<?php
error_reporting(0);
session_start();
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";

include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");

if ($_SESSION['access'] != true) {
    $login_box = ' <div class="top_login_box"><a href="'.$conf_site_url.'/account/login/">Sign in</a><a href="'.$conf_site_url.'/account/register/">Register</a></div>';
}else{
    $login_box = '<div class="top_login_box"><a href="'.$conf_site_url.'/account/logout/">Logout</a><a href="'.$conf_site_url.'/account/">Account</a></div>';
}
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
// get subs

$getSubs = mysql_query("SELECT * FROM event_wanna WHERE event_id='$id'") or die(mysql_error());
$subs = mysql_num_rows($getSubs);

// we now get the games we can select
$games_get = mysql_query("SELECT * FROM Games ORDER BY game") or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="Description" content="A short description of your company" />
    <meta name="Keywords" content="Some keywords that best describe your business" />
    <title><?=$conf_site_name?></title>
    <link rel="shortcut icon" href="<?=$conf_site_url?>/favicon.ico" />
    <link href="<?=$conf_site_url?>/style.css" media="screen" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$conf_site_url?>/js/preloadCssImages.js"></script>
    <script type="text/javascript" src="<?=$conf_site_url?>/js/jquery.color.js"></script>

    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/general.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.tools.min.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/jquery.easing.1.3.js"></script>

    <script type="text/javascript" language="JavaScript" src="<?=$conf_site_url?>/js/slides.jquery.js"></script>

    <link rel="stylesheet" href="<?=$conf_site_url?>/css/prettyPhoto.css" type="text/css" media="screen" />
    <script src="<?=$conf_site_url?>/js/jquery.prettyPhoto.js" type="text/javascript"></script>

    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?=$conf_site_url?>css/ie.css" />
    <![endif]-->
</head>
<body>
<div class="body_wrap thinpage">

<div class="header_image" style="background-image:url(<?=$conf_site_url?>/images/header.png)">&nbsp;</div>

<div class="header_menu">
    <div class="container">
        <div class="logo"><a href="<?=$conf_site_url?>/"><img src="<?=$conf_site_url?>/images/logo.png" alt="" /></a></div>
        <?=$login_box?>
        <div class="top_search">
            <form id="searchForm" action="<?=$conf_site_url?>/browse/" method="get">
                <fieldset>
                    <input type="submit" id="searchSubmit" value="" />
                    <div class="input">
                        <input type="text" name="s" id="s" value="Type & press enter" />
                    </div>
                </fieldset>
            </form>
        </div>

        <!-- topmenu -->
        <div class="topmenu">
            <ul class="dropdown">
                <li><a href="<?=$conf_site_url?>/browse/lol/"><span>LoL</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/dota2/"><span>Dota 2</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/hon/"><span>HoN</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/sc2/"><span>SC 2</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/wow/"><span>WoW</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/callofduty/"><span>Call Of Duty</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/minecraft/"><span>Minecraft</span></a></li>
                <li><a href="<?=$conf_site_url?>/browse/other/"><span>Other</span></a></li>
                <li><a href="<?=$conf_site_url?>/events/"><span>Events</span></a></li>
                <li><a href="#"><span>More</span></a>
                    <ul>

                        <li><a href="<?=$conf_site_url?>/company/support/"><span>Contact</span></a></li>
                        <li><a href="<?=$conf_site_url?>/account/partner/"><span>Partner</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/ topmenu -->
    </div>
</div>
<!--/ header -->



<!-- middle -->
<div class="middle">
    <div class="container_12">
        <div class="back_title">
            <div class="back_inner">
                <a href="<?=$conf_site_url?>"><span>Home</span></a>
            </div>
        </div>
        <center>
            <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/channel/?<?=SID; ?>" class="button_link"><span>Channel</span></a><a href="<?=$conf_site_url?>/events/manage/?<?=SID; ?>" class="button_link btn_black"><span>Events</span></a><a href="<?=$conf_site_url?>/account/settings/?<?=SID; ?>" class="button_link"><span>Settings</span></a><a href="<?=$conf_site_url?>/account/partner/?<?=SID; ?>" class="button_link"><span>Partner</span></a><a href="<?=$conf_site_url?>/account/help/?<?=SID; ?>" class="button_link"><span>Support</span></a>
        </center>
        <div class="divider_space_thin"></div>
        <!-- content -->
        <img src="<?=$eventsRow['img']?>" width="937" height="293" alt="" class="frame_center">
        <div class="grid_8 content">

            <?php
            $time = time();
            $start = $eventsRow['startDate'];
            $end = $eventsRow['endDate'];
            $startTime = date('d/m-Y G:i', $eventsRow['startDate'])." GMT +1";
            $endTime = date('d/m-Y G:i', $eventsRow['endDate'])." GMT +1";
            $diff = $end-$start;
            $duration = round($diff / (60*60))." hour(s)";

            // todo make so we can edit this info

            ?>
            <form name="login" action="action.php?change=1&id=<?=$id?>" method="post" id="loginform" class="loginform">

                <p><input name="title" id="title" class="gamersTextbox" value="<?=$eventsRow['title']?>" type="text" style="width: 625px; height: 35px"></p>

                <textarea cols="30" rows="10" name="msg" id="msg" class="textarea textarea_middle required" style="width: 625px; height: 500px"><?=$eventsRow['msg']?></textarea>

                <a href="#" onclick="document.login.submit()" id="login_but" class="button_link"><span>Save</span></a> (HTML will not work! Line breaks will automatically be created when there is an enter!)

            </form>

            <!-- comments -->
            <h5>Comments</h5>
            <?php
            // we get the comments
            $getReplies = mysql_query("SELECT * FROM event_comments WHERE event_id='$id' ORDER By id") or die(mysql_error());
            while($getRepliesRow = mysql_fetch_array($getReplies)){

                echo '<li class="comment">';
                echo '<div class="comment-body">';
                echo '<div class="comment-avatar">';
                echo '<div class="avatar"><img src="';
                echo ''.$conf_site_url.'/user/'.$getRepliesRow['auther'].'/avatar.png'; // img url
                echo '" width="90" height="90" alt=""></div>';
                echo '<a href="'.$conf_site_url.'/user/'.$getRepliesRow['auther'].'" class="link-author">'.$getRepliesRow['auther'].'</a>';
                echo '</div>';
                echo '<div class="comment-text">';
                echo '<div class="comment-author"> <span class="comment-date">';
                echo $getRepliesRow['dateSend']." <a href='action.php?deleteComment=1&id=".$getRepliesRow['id']."'>DELETE</a>"; // date
                echo '</span></div>';
                if($getRepliesRow['auther'] == $eventsRow['auther']){
                    echo '<h5>Event holder commented:</h5>';
                }
                echo '<div class="comment-entry">';
                echo $getRepliesRow['msg']; // msg
                echo '</div></div>';
                echo '<div class="clear"></div>';
                echo '</div>';
                echo '</li>';
                echo '<br>';
            }

            ?>
            <!--/ comments -->
        </div>
        <!--/ content -->

        <!-- sidebar -->
        <div class="grid_4 sidebar">

            <div class="widget-container widget_text">
                <?php
                // echo we will here display how long to the event start or if it has started or ended
                if($start >= $time){
                    // then it has not started so show countdown
                    // calc how many hours to start
                    $toStart = round(($start-$time) / (60*60));
                    echo '<h2>Start in: '.$toStart.' hour(s)</h2>';
                }
                if($start <= $time && $time <= $end){
                    // then we are in the event
                    echo 'The event has started!<br>';
                    echo '<a href="'.$conf_site_url.'/user/'.$eventsRow['channel'].'" class="button_link"><span>View Event!</span></a><br>';
                }
                if($time >= $end){
                    // then it has ended
                    echo 'The event has ended...';
                }

                ?>
            </div>
            <div class="post-share">
                <h5>Event details</h5>
                <b>Subscribers:</b> <?=$subs?><br>
                <b>Start time:</b> <?=$startTime?><br>
                <b>Duration:</b> <?=$duration?><br>
                <b>End time:</b> <?=$endTime?><br>
                <b>Event holder:</b> <?=$eventsRow['auther']?><br>

                <?php

                $StartTime = getdate($start);
                $endTime = getdate($end);
                $frontTime = getdate($eventsRow['featuredShow']);

                $Startday = "$StartTime[mday]";
                $Startmonth = "$StartTime[mon]";
                $Startyear = "$StartTime[year]";
                $Starthour = "$StartTime[hours]";
                $Startmin = "$StartTime[minutes]";

                $endday = "$endTime[mday]";
                $endmonth = "$endTime[mon]";
                $endyear = "$endTime[year]";
                $endhour = "$endTime[hours]";
                $endmin = "$endTime[minutes]";

                $frontday = "$frontTime[mday]";
                $frontmonth = "$frontTime[mon]";
                $frontyear = "$frontTime[year]";
                $fronthour = "$frontTime[hours]";
                $frontmin = "$frontTime[minutes]";

                ?>

                <form name="login2" action="action.php?change=2&id=<?=$id?>" method="post" id="loginform" class="loginform">

                    <p><b>Game:</b> <select name="game" id="game" style="width: 275px">
                            <option value="Other" id="game">Other</option>
                            <?php
                            while($games_row = mysql_fetch_array($games_get)){
                                echo '<option value="'.$games_row['game'].'" id="game">'.$games_row['game'].'</option>';
                            }
                            ?>
                        </select>
                        <p><b>Start Time:<br></b>
                        Date: <select name="Startday" id="Startday" style="width: 50px">
                            <option value="<?=$Startday?>" id="Startday"><?=$Startday?></option>
                            <option value="1" id="Startday">1</option>
                            <option value="2" id="Startday">2</option>
                            <option value="3" id="Startday">3</option>
                            <option value="4" id="Startday">4</option>
                            <option value="5" id="Startday">5</option>
                            <option value="6" id="Startday">6</option>
                            <option value="7" id="Startday">7</option>
                            <option value="8" id="Startday">8</option>
                            <option value="9" id="Startday">9</option>
                            <option value="10" id="Startday">10</option>
                            <option value="11" id="Startday">11</option>
                            <option value="12" id="Startday">12</option>
                            <option value="13" id="Startday">13</option>
                            <option value="14" id="Startday">14</option>
                            <option value="15" id="Startday">15</option>
                            <option value="16" id="Startday">16</option>
                            <option value="17" id="Startday">17</option>
                            <option value="18" id="Startday">18</option>
                            <option value="19" id="Startday">19</option>
                            <option value="20" id="Startday">20</option>
                            <option value="21" id="Startday">21</option>
                            <option value="22" id="Startday">22</option>
                            <option value="23" id="Startday">23</option>
                            <option value="24" id="Startday">24</option>
                            <option value="25" id="Startday">25</option>
                            <option value="26" id="Startday">26</option>
                            <option value="27" id="Startday">27</option>
                            <option value="28" id="Startday">28</option>
                            <option value="29" id="Startday">29</option>
                            <option value="30" id="Startday">30</option>
                            <option value="31" id="Startday">31</option>
                        </select>
                        /
                        <select name="Startmonth" id="Startmonth" style="width: 50px">
                            <option value="<?=$Startmonth?>" id="Startmonth"><?=$Startmonth?></option>
                            <option value="1" id="Startmonth">1</option>
                            <option value="2" id="Startmonth">2</option>
                            <option value="3" id="Startmonth">3</option>
                            <option value="4" id="Startmonth">4</option>
                            <option value="5" id="Startmonth">5</option>
                            <option value="6" id="Startmonth">6</option>
                            <option value="7" id="Startmonth">7</option>
                            <option value="8" id="Startmonth">8</option>
                            <option value="9" id="Startmonth">9</option>
                            <option value="10" id="Startmonth">10</option>
                            <option value="11" id="Startmonth">11</option>
                            <option value="12" id="Startmonth">12</option>

                        </select>
                        -
                        <select name="Startyear" id="Startyear" style="width: 60px">
                            <option value="<?=$Startyear?>" id="Startyear"><?=$Startyear?></option>
                            <option value="2013" id="Startyear">2013</option>
                            <option value="2014" id="Startyear">2014</option>
                            <option value="2015" id="Startyear">2015</option>
                        </select>
                        <br>
                        Time:
                        <select name="Starthour" id="Starthour" style="width: 50px">
                            <option value="<?=$Starthour?>" id="Starthour"><?=$Starthour?></option>
                            <option value="0" id="Starthour">0</option>
                            <option value="1" id="Starthour">1</option>
                            <option value="2" id="Starthour">2</option>
                            <option value="3" id="Starthour">3</option>
                            <option value="4" id="Starthour">4</option>
                            <option value="5" id="Starthour">5</option>
                            <option value="6" id="Starthour">6</option>
                            <option value="7" id="Starthour">7</option>
                            <option value="8" id="Starthour">8</option>
                            <option value="9" id="Starthour">9</option>
                            <option value="10" id="Starthour">10</option>
                            <option value="11" id="Starthour">11</option>
                            <option value="12" id="Starthour">12</option>
                            <option value="13" id="Starthour">13</option>
                            <option value="14" id="Starthour">14</option>
                            <option value="15" id="Starthour">15</option>
                            <option value="16" id="Starthour">16</option>
                            <option value="17" id="Starthour">17</option>
                            <option value="18" id="Starthour">18</option>
                            <option value="19" id="Starthour">19</option>
                            <option value="20" id="Starthour">20</option>
                            <option value="21" id="Starthour">21</option>
                            <option value="22" id="Starthour">22</option>
                            <option value="23" id="Starthour">23</option>
                        </select>
                        :
                        <select name="Startmin" id="Startmin" style="width: 50px">
                            <option value="<?=$Startmin?>" id="Startmin"><?=$Startmin?></option>
                            <option value="00" id="Startmin">00</option>
                            <option value="10" id="Startmin">10</option>
                            <option value="20" id="Startmin">20</option>
                            <option value="30" id="Startmin">30</option>
                            <option value="40" id="Startmin">40</option>
                            <option value="50" id="Startmin">50</option>
                        </select></p>

                    <p><b>End Time:<br></b>
                        Date: <select name="endday" id="endday" style="width: 50px">
                            <option value="<?=$endday?>" id="endday"><?=$endday?></option>
                            <option value="1" id="endday">1</option>
                            <option value="2" id="endday">2</option>
                            <option value="3" id="endday">3</option>
                            <option value="4" id="endday">4</option>
                            <option value="5" id="endday">5</option>
                            <option value="6" id="endday">6</option>
                            <option value="7" id="endday">7</option>
                            <option value="8" id="endday">8</option>
                            <option value="9" id="endday">9</option>
                            <option value="10" id="endday">10</option>
                            <option value="11" id="endday">11</option>
                            <option value="12" id="endday">12</option>
                            <option value="13" id="endday">13</option>
                            <option value="14" id="endday">14</option>
                            <option value="15" id="endday">15</option>
                            <option value="16" id="endday">16</option>
                            <option value="17" id="endday">17</option>
                            <option value="18" id="endday">18</option>
                            <option value="19" id="endday">19</option>
                            <option value="20" id="endday">20</option>
                            <option value="21" id="endday">21</option>
                            <option value="22" id="endday">22</option>
                            <option value="23" id="endday">23</option>
                            <option value="24" id="endday">24</option>
                            <option value="25" id="endday">25</option>
                            <option value="26" id="endday">26</option>
                            <option value="27" id="endday">27</option>
                            <option value="28" id="endday">28</option>
                            <option value="29" id="endday">29</option>
                            <option value="30" id="endday">30</option>
                            <option value="31" id="endday">31</option>

                        </select>
                        /
                        <select name="endmonth" id="endmonth" style="width: 50px">
                            <option value="<?=$endmonth?>" id="endmonth"><?=$endmonth?></option>
                            <option value="1" id="endmonth">1</option>
                            <option value="2" id="endmonth">2</option>
                            <option value="3" id="endmonth">3</option>
                            <option value="4" id="endmonth">4</option>
                            <option value="5" id="endmonth">5</option>
                            <option value="6" id="endmonth">6</option>
                            <option value="7" id="endmonth">7</option>
                            <option value="8" id="endmonth">8</option>
                            <option value="9" id="endmonth">9</option>
                            <option value="10" id="endmonth">10</option>
                            <option value="11" id="endmonth">11</option>
                            <option value="12" id="endmonth">12</option>

                        </select>
                        -
                        <select name="endyear" id="endyear" style="width: 60px">
                            <option value="<?=$endyear?>" id="endyear"><?=$endyear?></option>
                            <option value="2013" id="endyear">2013</option>
                            <option value="2014" id="endyear">2014</option>
                            <option value="2015" id="endyear">2015</option>
                        </select>
                        <br>
                        Time:
                        <select name="endhour" id="endhour" style="width: 50px">
                            <option value="<?=$endhour?>" id="endhour"><?=$endhour?></option>
                            <option value="0" id="endhour">0</option>
                            <option value="1" id="endhour">1</option>
                            <option value="2" id="endhour">2</option>
                            <option value="3" id="endhour">3</option>
                            <option value="4" id="endhour">4</option>
                            <option value="5" id="endhour">5</option>
                            <option value="6" id="endhour">6</option>
                            <option value="7" id="endhour">7</option>
                            <option value="8" id="endhour">8</option>
                            <option value="9" id="endhour">9</option>
                            <option value="10" id="endhour">10</option>
                            <option value="11" id="endhour">11</option>
                            <option value="12" id="endhour">12</option>
                            <option value="13" id="endhour">13</option>
                            <option value="14" id="endhour">14</option>
                            <option value="15" id="endhour">15</option>
                            <option value="16" id="endhour">16</option>
                            <option value="17" id="endhour">17</option>
                            <option value="18" id="endhour">18</option>
                            <option value="19" id="endhour">19</option>
                            <option value="20" id="endhour">20</option>
                            <option value="21" id="endhour">21</option>
                            <option value="22" id="endhour">22</option>
                            <option value="23" id="endhour">23</option>
                        </select>
                        :
                        <select name="endmin" id="endmin" style="width: 50px">
                            <option value="<?=$endmin?>" id="endmin"><?=$endmin?></option>
                            <option value="00" id="endmin">00</option>
                            <option value="10" id="endmin">10</option>
                            <option value="20" id="endmin">20</option>
                            <option value="30" id="endmin">30</option>
                            <option value="40" id="endmin">40</option>
                            <option value="50" id="endmin">50</option>
                        </select></p>
                    <i>All times are in GMT + 1</i><br>
                    <p><b>Channel: </b><input name="channel" id="channel" class="gamersTextbox" value="<?=$eventsRow['channel']?>" type="text" style="width: 275px; height: 30px"></p>
                    <p><b>Image URL (1920x600): </b><input name="img" id="img" class="gamersTextbox" value="<?=$eventsRow['img']?>" type="text" style="width: 275px; height: 30px"></p>
                    <?php
                    if($_SESSION['admin'] == true){
                        echo '
                        <p><b>Front page start:<br></b>
                        <input type="checkbox" name="featured" id="frontpage" value="1"> Featured<br>
                        <input type="checkbox" name="featured" id="frontpage" value="0"> NOT Featured<br>
                        Date: <select name="frontday" id="frontday" style="width: 50px">
                            <option value="'.$frontday.'" id="frontday">'.$frontday.'</option>
                            <option value="1" id="frontday">1</option>
                            <option value="2" id="frontday">2</option>
                            <option value="3" id="frontday">3</option>
                            <option value="4" id="frontday">4</option>
                            <option value="5" id="frontday">5</option>
                            <option value="6" id="frontday">6</option>
                            <option value="7" id="frontday">7</option>
                            <option value="8" id="frontday">8</option>
                            <option value="9" id="frontday">9</option>
                            <option value="10" id="frontday">10</option>
                            <option value="11" id="frontday">11</option>
                            <option value="12" id="frontday">12</option>
                            <option value="13" id="frontday">13</option>
                            <option value="14" id="frontday">14</option>
                            <option value="15" id="frontday">15</option>
                            <option value="16" id="frontday">16</option>
                            <option value="17" id="frontday">17</option>
                            <option value="18" id="frontday">18</option>
                            <option value="19" id="frontday">19</option>
                            <option value="20" id="frontday">20</option>
                            <option value="21" id="frontday">21</option>
                            <option value="22" id="frontday">22</option>
                            <option value="23" id="frontday">23</option>
                            <option value="24" id="frontday">24</option>
                            <option value="25" id="frontday">25</option>
                            <option value="26" id="frontday">26</option>
                            <option value="27" id="frontday">27</option>
                            <option value="28" id="frontday">28</option>
                            <option value="29" id="frontday">29</option>
                            <option value="30" id="frontday">30</option>
                            <option value="31" id="frontday">31</option>

                        </select>
                        /
                        <select name="frontmonth" id="frontmonth" style="width: 50px">
                        <option value="'.$frontmonth.'" id="frontmonth">'.$frontmonth.'</option>
                            <option value="1" id="frontmonth">1</option>
                            <option value="2" id="frontmonth">2</option>
                            <option value="3" id="frontmonth">3</option>
                            <option value="4" id="frontmonth">4</option>
                            <option value="5" id="frontmonth">5</option>
                            <option value="6" id="frontmonth">6</option>
                            <option value="7" id="frontmonth">7</option>
                            <option value="8" id="frontmonth">8</option>
                            <option value="9" id="frontmonth">9</option>
                            <option value="10" id="frontmonth">10</option>
                            <option value="11" id="frontmonth">11</option>
                            <option value="12" id="frontmonth">12</option>

                        </select>
                        -
                        <select name="frontyear" id="frontyear" style="width: 60px">
                        <option value="'.$frontyear.'" id="frontyear">'.$frontyear.'</option>
                            <option value="2013" id="frontyear">2013</option>
                            <option value="2014" id="frontyear">2014</option>
                            <option value="2015" id="frontyear">2015</option>
                        </select>
                        <br>
                        Time:
                        <select name="fronthour" id="fronthour" style="width: 50px">
                        <option value="'.$fronthour.'" id="fronthour">'.$fronthour.'</option>
                            <option value="0" id="fronthour">0</option>
                            <option value="1" id="fronthour">1</option>
                            <option value="2" id="fronthour">2</option>
                            <option value="3" id="fronthour">3</option>
                            <option value="4" id="fronthour">4</option>
                            <option value="5" id="fronthour">5</option>
                            <option value="6" id="fronthour">6</option>
                            <option value="7" id="fronthour">7</option>
                            <option value="8" id="fronthour">8</option>
                            <option value="9" id="fronthour">9</option>
                            <option value="10" id="fronthour">10</option>
                            <option value="11" id="fronthour">11</option>
                            <option value="12" id="fronthour">12</option>
                            <option value="13" id="fronthour">13</option>
                            <option value="14" id="fronthour">14</option>
                            <option value="15" id="fronthour">15</option>
                            <option value="16" id="fronthour">16</option>
                            <option value="17" id="fronthour">17</option>
                            <option value="18" id="fronthour">18</option>
                            <option value="19" id="fronthour">19</option>
                            <option value="20" id="fronthour">20</option>
                            <option value="21" id="fronthour">21</option>
                            <option value="22" id="fronthour">22</option>
                            <option value="23" id="fronthour">23</option>
                        </select>
                        :
                        <select name="frontmin" id="frontmin" style="width: 50px">
                        <option value="'.$frontmin.'" id="frontmin">'.$frontmin.'</option>
                            <option value="00" id="frontmin">00</option>
                            <option value="10" id="frontmin">10</option>
                            <option value="20" id="frontmin">20</option>
                            <option value="30" id="frontmin">30</option>
                            <option value="40" id="frontmin">40</option>
                            <option value="50" id="frontmin">50</option>
                        </select></p>
                    <i>All times are in GMT + 1</i><br>
                        ';
                    }

                    ?>
                    <a href="#" onclick="document.login2.submit()" id="login_but" class="button_link"><span>Save</span></a>

                </form>
            </div>
            <div class="post-share">
                <h5>Other details</h5>
                <b>Event Created:</b> <?=date('d/m-Y G:i', $eventsRow['submitDate'])." GMT +1"?><br>
                <b>Featured:</b> <?php if($eventsRow['featured']== "1"){echo 'Yes';
                echo '<br>';
                echo '<b>Front page start:</b> '.date('d/m-Y G:i', $eventsRow['featuredShow']).' GMT +1';}else{echo 'No';}?><br>
            </div>
            <div class="widget-container widget_text">
                <a href="<?=$conf_site_url?>/events/" class="button_link"><span>Back to events</span></a><br>
                <a href="action.php?delete=1&id=<?=$eventsRow['id']?>" class="button_link btn_red"><span>Delete this event</span></a><br>
            </div>

            <div class="post-share">
                <b>Share this event</b><br>
                <a href="http://twitter.com/share?text=<?=$eventsRow['title']?>&url=<?=$conf_site_url?>/events/view/?id=<?=$id?>" class="btn-share"><img src="<?=$conf_site_url?>/images/share_twitter.png" width="79" height="25" alt="" /></a> <a href="http://www.facebook.com/sharer.php?u=<?=$conf_site_url?>/events/view/?id=<?=$id?>&t=<?=$eventsRow['title']?>" class="btn-share"><img src="<?=$conf_site_url?>/images/share_facebook.png" width="88" height="25" alt="" /></a>
            </div>
        </div>
        <!--/ sidebar -->



        <div class="clear"></div>

    </div>
</div>
<!--/ middle -->

<div class="footer">
    <div class="footer_inner">
        <div class="container_12">

            <div class="grid_8">
                <h3><?=$conf_site_name?></h3>

                <div class="copyright">
                    <?=$conf_site_copy?> <br /><a href="<?=$conf_site_url?>/company/legal/">Terms of Service</a> - <a href="<?=$conf_site_url?>/company/support/">Contact</a> -
                    <a href="<?=$conf_site_url?>/company/legal/">Privacy guidelines</a> - <a href="<?=$conf_site_url?>/company/support/">Advertise with Us</a></p>
                </div>
            </div>

            <div class="grid_4">
                <h3>Follow us</h3>
                <div class="footer_social">
                    <a href="<?=$conf_site_url?>/facebook/" class="icon-facebook">Facebook</a>
                    <a href="<?=$conf_site_url?>/twitter/" class="icon-twitter">Twitter</a>
                    <a href="<?=$conf_site_url?>/rss/" class="icon-rss">RSS</a>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>

</div>
</body>
</html>
