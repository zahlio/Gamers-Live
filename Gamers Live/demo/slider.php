<!-- slider -->

<?php
error_reporting(0);


// last update was on 12/02/2013

$inc_path = $_SERVER['DOCUMENT_ROOT'];
$inc_path .= "/config.php";
include_once($inc_path);
include_once("".$conf_ht_docs_gl."/files/check.php");

$time = time();
// we get all events that are featured and that are are not started
$events = mysql_query("SELECT * FROM events WHERE featured='1' AND featuredShow <= '$time'") or die(mysql_error());
?>
<div class="header_slider">
    
    <ul id="slider1" class="bxSlider">
        <?php
        while($eventsRow = mysql_fetch_array($events))
        {
            echo '<li style="background: url('.$eventsRow['img'].') no-repeat scroll center 0 transparent;">';
            echo '<div class="fakeimg"></div>';
            echo '<div class="slide-text-wrapper">';
            echo '<div class="slide-text-content">';
            echo '<div class="meta-date"><span class="ico_cat"><em>'.$eventsRow['game'].'</em></span> '.date('d/m-Y G:i', $eventsRow['startDate']).' GMT +1</div>';
            echo '<a href="'.$conf_site_url.'/events/view/?id='.$eventsRow['id'].'" class="slide-title"><strong>'.$eventsRow['title'].'</strong></a>';
            echo '<div class="slide-button"><a href="'.$conf_site_url.'/events/view/?id='.$eventsRow['id'].'" class="button_link"><span>Read More</span></a></div>';
            echo '</div>';
            echo '</div>';
            echo '</li>';
        }
        ?>

    </ul>	
</div>
<!--/ slider -->