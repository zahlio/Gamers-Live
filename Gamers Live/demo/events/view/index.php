<?php
error_reporting(0);
include_once("../../config.php");
include_once("../../analyticstracking.php");
session_start();

if ($_SESSION['access'] != true) {
    $login_box = ' <div class="top_login_box"><a href="'.$conf_site_url.'/account/login/">Sign in</a><a href="'.$conf_site_url.'/account/register/">Register</a></div>';
}else{
    $login_box = '<div class="top_login_box"><a href="'.$conf_site_url.'/account/logout/">Logout</a><a href="'.$conf_site_url.'/account/">Account</a></div>';
}
$id = $_GET['id'];
$channel_id = $_SESSION['channel_id'];
if($_SESSION['access'] == true){

    // we check if the user is subscribed to this even
    $check = mysql_query("SELECT * FROM event_wanna WHERE event_id='$id' AND viewer='$channel_id'") or die(mysql_error());

    if(mysql_num_rows($check) >= 1){
        $subscribed = true;
    }else{
        $subscribed = false;
    }
}
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
                    <li><a href="<?=$conf_site_url?>/browse/?s=league+of+legends"><span>LoL</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=dota+2"><span>Dota 2</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Heroes+of+Newerth"><span>HoN</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Star+Craft+2"><span>SC 2</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=World+Of+Warcraft"><span>WoW</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Call+Of+Duty"><span>Call Of Duty</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/?s=Minecraft"><span>Minecraft</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/"><span>Other</span></a></li>
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
            <?php
            // we now echo that event wiht that id
            $events = mysql_query("SELECT * FROM events WHERE id='$id'") or die(mysql_error());
            $eventsRow = mysql_fetch_array($events);
            ?>
            <div class="back_title">
                <div class="back_inner">
                    <a href="<?=$conf_site_url?>"><span>Home</span></a>
                </div>
            </div>

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
                ?>
                <h1><?=$eventsRow['title']?></h1>
                <?=$eventsRow['msg']?>

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
                        echo $getRepliesRow['dateSend']; // date
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
                <div class="box2 add-comment" id="addcomments">
                    <h3>Leave a comment</h3>

                    <div class="box2_content comment-form">
                        <form action="comment.php?id=<?=$id?>" method="post">
                            <div class="row">
                                <textarea cols="30" rows="10" name="msg" id="msg" class="textarea textarea_middle required"></textarea>
                            </div>

                            <input type="submit" value="Submit" class="btn-submit">
                        </form>
                    </div>
                </div>
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
                        <b>Game:</b> <?=$eventsRow['game']?><br>
                        <b>Start time:</b> <?=$startTime?><br>
                        <b>Duration:</b> <?=$duration?><br>
                        <b>End time:</b> <?=$endTime?><br>
                        <b>Event holder:</b> <?=$eventsRow['auther']?><br>
                        <b>Channel:</b> <a href="<?=$conf_site_url?>/user/<?=$eventsRow['channel']?>"> <?=$eventsRow['channel']?></a>
                    </div>
                <div class="widget-container widget_text">
                    <a href="<?=$conf_site_url?>/events/" class="button_link"><span>Back to events</span></a><br>
                    <?php
                    if($_SESSION['access'] == true){
                        if($subscribed == true){
                            echo 'You will be noticed when this event goes live!';
                        }else{
                            echo '<a href="'.$conf_site_url.'/events/wanna/?id='.$id.'&sub=1&time='.$start.'" class="button_link"><span>Subscribe to this event</span></a><br>';
                        }
                    }
                    ?>
                    <?php
                    if($_SESSION['admin'] == true || $_SESSION['channel_id'] == $eventsRow['auther']){
                        echo '<a href="'.$conf_site_url.'/events/manage/edit.php?id='.$id.'" class="button_link btn_black"><span>Edit this event</span></a><br>';
                    }
                    ?>
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
