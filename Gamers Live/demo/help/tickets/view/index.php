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
$channel_id = $_SESSION['channel_id'];
$id = $_GET['id'];
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

            <div class="divider_space_thin"></div>
            <!-- account menu -->
            <center>
                <a href="<?=$conf_site_url?>/account/?<?=SID; ?>" class="button_link"><span>Account Overview</span></a><a href="<?=$conf_site_url?>/account/channel/?<?=SID; ?>" class="button_link"><span>Channel</span></a><a href="<?=$conf_site_url?>/events/manage/?<?=SID; ?>" class="button_link"><span>Events</span></a><a href="<?=$conf_site_url?>/account/settings/?<?=SID; ?>" class="button_link"><span>Settings</span></a><a href="<?=$conf_site_url?>/account/partner/?<?=SID; ?>" class="button_link"><span>Partner</span></a><a href="<?=$conf_site_url?>/account/help/?<?=SID; ?>" class="button_link btn_black"><span>Support</span></a>
                <?php
                error_reporting(0);

                if($admin == true){
                    echo "<a href='".$conf_site_url."/account/admin/?' class='button_link btn_red'><span>Admin CP</span></a>";
                } ?>
            </center>
            <!-- account menu end -->
            <!-- content -->
            <div class="grid_8 content">
                <?php
                    // we will now get the tickets that are asosiated with this member

                    $getTickets = mysql_query("SELECT * FROM tickets WHERE owner='$channel_id' AND id='$id'") or die(mysql_error());
                    $getTicketsRow = mysql_fetch_array($getTickets);

                    $getReplies = mysql_query("SELECT * FROM tickets WHERE originTicketID='$id' AND isReply='1'") or die(mysql_error());

                    // now we echo them
                    echo '<h3># '.$getTicketsRow['id'].' - '.$getTicketsRow['title'].'</h3>';
                    echo '<li class="comment">';
                    echo '<div class="comment-body">';
                    echo '<div class="comment-text" style="width: 575px">';
                    echo $getTicketsRow['msg'];
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                    echo '<div class="clear"></div>';
                    echo '<br><br><h3>Replies (total: '.mysql_num_rows($getReplies).')</h3>';

                    while($getRepliesRow = mysql_fetch_array($getReplies)){

                        echo '#'.$getRepliesRow['id'];
                        echo '<li class="comment">';
                        echo '<div class="comment-body">';
                        echo '<div class="comment-avatar">';
                        echo '<div class="avatar"><img src="';
                        echo ''.$conf_site_url.'/user/'.$getRepliesRow['replySender'].'/avatar.png'; // img url
                        echo '" width="90" height="90" alt=""></div>';
                        echo '</div>';
                        echo '<div class="comment-text">';
                        echo '<div class="comment-author"> <span class="comment-date">';
                        echo $getRepliesRow['dateSend']; // date
                        echo '</span></div>';
                        if($getRepliesRow['isStaff'] == "1"){
                            echo '<h5>Staff response ('.$getRepliesRow['replySender'].')</h5>';
                        }else{
                            echo '<h5>User response ('.$getRepliesRow['replySender'].')</h5>';
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
                    <h3>Leave a Reply</h3>

                    <div class="box2_content comment-form">
                        <form action="action.php?id=<?=$id?>&reply=1" method="post">
                            <div class="row">
                                <textarea cols="30" rows="10" name="msg" id="msg" class="textarea textarea_middle required"></textarea>
                                <input type="hidden" id="owner" name="owner" value="<?=$getRepliesRow['owner']?>">
                            </div>

                            <input type="submit" value="Submit" class="btn-submit">
                        </form>
                    </div>
                </div>
        </div>
            <!--/ content -->

            <!-- sidebar -->
            <div class="grid_4 sidebar">

                <div class="widget-container widget_text">
                    <br>
                    <?php
                    echo '<b>Status: </b>'.$getTicketsRow['status'].'<br>';
                    echo '<b>Submitted on: </b>'.$getTicketsRow['dateSend'].'<br>';
                    echo '<b>Submitted by: </b>'.$getTicketsRow['owner'].'<br>';
                    echo '<b>Ip address: </b>'.$getTicketsRow['ip'].'<br>';

                    ?>
                    <br><br>
                    <?php
                    if($getTicketsRow['status'] == "open"){
                        echo '<a href="'.$conf_site_url.'/help/tickets/view/action.php?id='.$id.'&close=1" class="button_link btn_red"><span>Close Ticket</span></a>';
                    }
                    if($getTicketsRow['status'] == "closed"){
                        echo '<a href="'.$conf_site_url.'/help/tickets/view/action.php?id='.$id.'&open=1" class="button_link btn_green"><span>Re-open Ticket</span></a>';
                    }
                    ?>
                    <a href="<?=$conf_site_url?>/help/base/" class="button_link"><span>View Knowledge Base</span></a>
                    <a href="<?=$conf_site_url?>/help/tickets/" class="button_link"><span>View All Tickets / Submit new</span></a>
                </div>

                <div class="post-share">
                    <a href="<?=$conf_site_url?>/twitter/" class="btn-share"><img src="<?=$conf_site_url?>/images/share_twitter.png" width="79" height="25" alt="" /></a> <a href="<?=$conf_site_url?>/facebook/" class="btn-share"><img src="<?=$conf_site_url?>/images/share_facebook.png" width="88" height="25" alt="" /></a>
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
