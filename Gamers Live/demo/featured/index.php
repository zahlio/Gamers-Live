<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
error_reporting(0);




session_start();

if ($_SESSION['access'] != true) {
    $login_box = ' <div class="top_login_box"><a href="<?=$conf_site_url?>/account/login/">Sign in</a><a href="<?=$conf_site_url?>/account/register/">Register</a></div>';
}else{
    $login_box = '<div class="top_login_box"><a href="<?=$conf_site_url?>/account/logout/">Logout</a><a href="<?=$conf_site_url?>/account/settings/">Settings</a></div>';
}

include_once("".$conf_ht_docs_gl."/analyticstracking.php");

// we first get data from our mysql database
$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);include_once("".$conf_ht_docs_gl."/files/check.php");

// connect to databases


// select the database we need


$per_page = 5;

$c_page = $_GET['p'];

if($c_page == null){
    // then we should be on page 1
    $c_page = 1;
}

// calc prev
if($c_page = 1){
    $prev_page = 1;
}else{
    $prev_page = $c_page - 1;
}

$total_count_res = mysql_query("SELECT * FROM channels WHERE featured='1' AND online='Online'");
$total_count = mysql_num_rows($total_count_res);

// calc the pages we need
if($total_count > $per_page){
    // then we need more pages
    $pages_needed = ceil($total_count / $per_page); // total pages we need to make this done.
}else{
    $pages_needed = 1;
}

if($total_count > $per_page){
    $start_l = ($c_page * $pages_needed) + 1;
    $end_l = $start_l +  - 1;
}else{
    $start_l = 0;
    $end_l = $per_page;
}

// calc next page
if($total_count > $per_page){
    $next_page = $c_page + 1;

}else{
    $next_page = $c_page;
}

if($end_l >= $total_count){
    // then we need no more next pages
    $next_page = $c_page;
}

$result = mysql_query("SELECT * FROM channels WHERE featured='1' AND online='Online' ORDER BY feature_level DESC LIMIT $start_l, $end_l");

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
                    <li><a href="<?=$conf_site_url?>/browse/lol/?"><span>LoL</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/dota2/?"><span>Dota 2</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/hon/?"><span>HoN</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/sc2/?"><span>SC 2</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/wow/?"><span>WoW</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/callofduty/?"><span>Call Of Duty</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/minecraft/?"><span>Minecraft</span></a></li>
                    <li><a href="<?=$conf_site_url?>/browse/other/?"><span>Others</span></a></li>
                    <li><a href="<?=$conf_blog?>"><span>Blog</span></a></li>
                    <li><a href="#"><span>More</span></a>
                        <ul>
                            
                            <li><a href="<?=$conf_site_url?>/company/support/"><span>Contact</span></a></li>
                            <li><a href="<?=$conf_site_url?>/account/partner/?"><span>Partner</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/ topmenu -->
        </div>
    </div>
    <!--/ header -->



    <!-- middle -->
    <div class="middle full_width">
        <div class="container 12">
            <div class="content">
                <div class="post-details">
                    <br>
                    <h2>Featured Streamers</h2>
                    <p>Currently Online: <?=$total_count?></p>
                        <?php
error_reporting(0);


                            while($row = mysql_fetch_array($result)){
                                echo '
                                    <div class="author-box">
                                        <div class="author-description">
                                            <div class="author-image"><img src="<?=$conf_site_url?>/user/'.$row['channel_id'].'/avatar.png" width="100" height="100" alt=""></div>
                                            <div class="author-text">
                                              <h4>'.$row['channel_id'].'</h4>
                                                <p>'.strip_tags(substr($row['info2'], 0, 100)).'...</p>
                                                <p><b>Viewers:</b> '.$row['viewers'].'</p>
                                                <p><b><a href="<?=$conf_site_url?>/user/'.$row['channel_id'].'/">Watch Live</a></b></p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                ';
                            }
                        ?>
                </div>
                    <div class="tf_pagination">
                        <a class="page_next button_link" href="?p=<?=$next_page?>"><span>Next</span></a>
                        <a class="page_prev button_link" href="?p=<?=$prev_page?>"><span>Previous</span></a>
                    </div>
            </div>
        </div>
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
                    <a href="<?=$conf_site_url?>/company/legal/">Privacy guidelines</a> - <a href="<?=$conf_site_url?>/company/support/">Advertise with Us</a> - <a href="<?=$conf_site_url?>/company/about/">About Us</a></p>
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