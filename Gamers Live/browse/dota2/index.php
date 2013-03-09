<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="ThemeFuse" />
<meta name="Description" content="A short description of your company" />
<meta name="Keywords" content="Some keywords that best describe your business" />
<title>GAMERS LIVE - Dota 2</title>
<link href="http://www.gamers-live.net/style.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://www.gamers-live.net/js/jquery.min.js"></script>
<script type="text/javascript" src="http://www.gamers-live.net/js/preloadCssImages.js"></script>
<script type="text/javascript" src="http://www.gamers-live.net/js/jquery.color.js"></script>

<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/general.js"></script>
<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/jquery.tools.min.js"></script>
<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" language="JavaScript" src="http://www.gamers-live.net/js/slides.jquery.js"></script>

<link rel="stylesheet" href="http://www.gamers-live.net/css/prettyPhoto.css" type="text/css" media="screen" />
<script src="http://www.gamers-live.net/js/jquery.prettyPhoto.js" type="text/javascript"></script>

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]-->
</head>
			<?php 
			error_reporting(0);
			session_start();

if ($_SESSION['access'] != true) {
 $login_box = ' <div class="top_login_box"><a href="http://www.gamers-live.net/account/login/">Sign in</a><a href="http://www.gamers-live.net/account/register/">Register</a></div>';
}else{
$login_box = '<div class="top_login_box"><a href="http://www.gamers-live.net/account/logout/">Logout</a><a href="http://www.gamers-live.net/account/settings/">Settings</a></div>';
}
			include_once("http://www.gamers-live.net/analyticstracking.php");					
			$database_url = "127.0.0.1";
			$database_user = "root";
			$database_pw = "";
			
			// connect to database
			$connect = mysql_connect($database_url, $database_user, $database_pw) or die(mysql_error());
			
			// select thje database we need
			$select_db = mysql_select_db("live", $connect) or die(mysql_error());

            // select features streamer who is online / active
            $per_page = 25;

            $page = $_GET['p'];

            if($page == null){
                $page = "1";
            }

            // prev page
            if($page == 1){
                // then no prevs
                $prev_page = 1;
            }else{
                $prev_page = $page - 1;
            }

            // end and start count
            if($page == 1){
                $start_c = 0;
                $end_c = $per_page;
            }else{
                $end_c = $page * $per_page;
                $start_c = $end_c - $per_page + 1;
            }

            $result = mysql_query("SELECT * FROM channels WHERE game='Dota 2' AND online='Online' ORDER BY viewers DESC LIMIT $start_c, $end_c");
            $total_res = mysql_query("SELECT * FROM channels WHERE game='Dota 2' AND online='Online'");
            $total_count = mysql_num_rows($total_res);

            if($total_count > $per_page){
                // then we need more pages
                $pages_needed = ceil($total_count / $per_page); // total pages we need to make this done.
            }else{
                $pages_needed = 1;
            }

            // next page
            if($pages_needed > 1){
                $next_page = $page + 1;
            }else{
                $next_page = 1;
            }

            // calc when we need no more next pages
            if($page >= $pages_needed){
                $next_page = $page;
            }
            ?>

<body>
<div class="body_wrap thinpage">

<div class="header_image" style="background-image:url(http://www.gamers-live.net/images/header_dota2.png)">&nbsp;</div>

<div class="header_menu">
	<div class="container">
		<div class="logo"><a href="http://www.gamers-live.net/"><img src="http://www.gamers-live.net/images/logo.png" alt="" /></a></div>
        <?=$login_box?>
        <div class="top_search">
        	<form id="searchForm" action="http://www.gamers-live.net/browse/" method="get">
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
                        <li><a href="http://www.gamers-live.net/browse/lol/"><span>LoL</span></a></li>
                        <li class="current-menu-item" /><a href="http://www.gamers-live.net/browse/dota2/"><span>Dota 2</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/hon/"><span>HoN</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/sc2/"><span>SC 2</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/wow/"><span>WoW</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/callofduty/"><span>Call Of Duty</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/minecraft/"><span>Minecraft</span></a></li>
                        <li><a href="http://www.gamers-live.net/browse/other/"><span>Others</span></a></li>
                        <li><a href="http://www.gamers-live.net/blog/"><span>Blog</span></a></li>
                        <li><a href="#"><span>More</span></a>                        
                        	<ul>
                                <li><a href="http://www.gamers-live.net/company/about/"><span>About</span></a></li>
                                <li><a href="http://www.gamers-live.net/company/support/"><span>Contact</span></a></li>
                                <li><a href="http://www.gamers-live.net/account/partner/"><span>Partner</span></a></li>
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
<div class="container_12">

	<div class="back_title">
    	<div class="back_inner">
		<a href="http://www.gamers-live.net/"><span>Home</span></a>
        </div>
    </div> 	 
   
    
    <!-- content -->
    <div class="content">
    
    <div class="styled_table table_white"/>
    
                        <?php
					echo "<table width='100%' cellpadding='0' cellspacing='0'>
					<tbody>
					<thead>
					<tr>
						<th></th>
						<th>Title</th>
						<th>Streamer</th>
						<th>Game</th>
						<th>Viewers</th>
						<th>Channel Link</th>
					</tr>
					</thead>";

					while($row = mysql_fetch_array($result))
					{
						echo "<tr>";
						echo "<td><center><img src='http://www.gamers-live.net/user/" . $row['channel_id'] . "/avatar.png' height='50' width='50'></center></td>";
						echo "<td>" . $row['title'] . "</td>";
						echo "<td>" . $row['channel_id'] . "</td>";
						echo "<td>" . $row['game'] . "</td>";
						echo "<td>" . $row['viewers'] . "</td>";
						echo "<td><a class='colorButton' href='http://www.gamers-live.net/user/" . $row['channel_id'] . "/'<span class='pointer'>Watch Live</span></a></td>";
						echo "</tr>";
					}
						echo "<tbody>
						</table>";
					?>
</div>
    <div class="tf_pagination">
        <a class="page_next button_link" href="?p=<?=$next_page?>"><span>Next</span></a>
        <a class="page_prev button_link" href="?p=<?=$prev_page?>"><span>Previous</span></a>
    </div>
    </div>
    <!--/ content --> 
    
   
    <div class="clear"></div>
    
</div>
</div>
<!--/ middle -->
<!--/ middle -->

<div class="footer">
<div class="footer_inner">
<div class="container_12">
	
    <div class="grid_8">
    	<h3>Gamers Live</h3>   
		
        <div class="copyright">
		&copy; 2013 GAMERS LIVE. An Gamers Live production. All Rights Reserved. <br /><a href="http://www.gamers-live.net/company/legal/">Terms of Service</a> - <a href="http://www.gamers-live.net/company/support/">Contact</a> -
		<a href="http://www.gamers-live.net/company/legal/">Privacy guidelines</a> - <a href="http://www.gamers-live.net/company/support/">Advertise with Us</a> - <a href="http://www.gamers-live.net/company/about/">About Us</a></p>
		</div>          
    </div>
    
    <div class="grid_4">
    	<h3>Follow us</h3>
        <div class="footer_social">
        	<a href="http://www.gamers-live.net/facebook/" class="icon-facebook">Facebook</a> 
            <a href="http://www.gamers-live.net/twitter/" class="icon-twitter">Twitter</a>
            <a href="http://www.gamers-live.net/rss/" class="icon-rss">RSS</a>
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
