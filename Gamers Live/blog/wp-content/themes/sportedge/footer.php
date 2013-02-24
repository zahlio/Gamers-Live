<div class="footer">
    <div class="footer_inner">
        <div class="container_12">

        <?php tfuse_footer(); ?>

        <div class="clear"></div>

        </div>
    </div>
</div>
<?php wp_footer();
 if ( get_option(PREFIX."_google_analytics") <> "" ) { echo html_entity_decode(get_option(PREFIX."_google_analytics"),ENT_QUOTES, 'UTF-8'); } 
 include_once("http://www.gamers-live.net/analyticstracking.php");
 ?>
</div>
</body>
</html>