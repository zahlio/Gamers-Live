<?php
    global $post;

    // Multi Page Widget
    if ( is_page() )  {
        
        $pageID = $post->ID;
        $pageIDArr = tfuse_sidebar_add();

        if( count($pageIDArr) > 0 ) {

            if (is_array($pageIDArr))
                if (in_array($pageID, $pageIDArr)) {  dynamic_sidebar("Sidebar Page Top - ".get_the_title($pageID)); }
        }
    }

    // Multi Category Widget
    if ( is_category() )  {
        
        $catID = get_query_var('cat');				
        $catIDArr = tfuse_sidebar_add('cat');

        if( count($catIDArr) > 0 ) {

            if (is_array($catIDArr))
                if (in_array($catID, $catIDArr)) {  dynamic_sidebar("Sidebar Category Top - ".get_cat_name($catID)); }
        }
    }

?>