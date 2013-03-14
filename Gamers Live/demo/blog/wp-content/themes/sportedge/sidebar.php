<?php 	
    global $post;
    $is_widget = false;
    
    // Multi Page Widget
    if ( is_page() )  {
        
        $pageID = $post->ID;				
        $multi_widget = PREFIX.'_multi_widget_pages_hidden';
        $count_multi_widget = get_option( $multi_widget );
        
        if( $count_multi_widget > 1 ) {
        
            for($i = 0; $i < $count_multi_widget; $i++)
            {
                $page_str = get_option( PREFIX.'_multi_widget_pages_'. $i );			
				$pageArr = explode("_", $page_str);
				if(!isset($pageArr[1])) continue;
				$page_id = $pageArr[1];
                if ( $page_id > 0 ) $pageIDArr[] = $page_id; 					
            }
            if (is_array($pageIDArr))
                if (in_array($pageID, $pageIDArr)) { $is_widget = true; dynamic_sidebar("Sidebar Page - ".get_the_title($pageID)); }
        }
    }

    // Multi Post Widget
    if ( is_single() )  {
 
        $postID = $post->ID;				
        $multi_widget = PREFIX.'_multi_widget_posts_hidden';
        $count_multi_widget = get_option( $multi_widget );
        
        if( $count_multi_widget > 1 ) {
        
            for($i = 0; $i < $count_multi_widget; $i++)
            {
                $post_str = get_option( PREFIX.'_multi_widget_posts_'. $i );			
				$postArr = explode("_", $post_str);
				if(!isset($postArr[1])) continue;
				$post_id = $postArr[1];
                if ( $post_id > 0 ) $postIDArr[] = $post_id; 					
            }
            if (is_array($postIDArr))
                if (in_array($postID, $postIDArr)) { $is_widget = true; dynamic_sidebar("Sidebar Post - ".get_the_title($postID)); }
        }
    }
    
    
    // Multi Category Widget
    if ( is_category() )  {
        
        $catID = get_query_var('cat');				
        $multi_widget = PREFIX.'_multi_widget_categories_hidden';
        $count_multi_widget = get_option( $multi_widget );
        
        if( $count_multi_widget > 1 ) {
    
            for($i = 0; $i < $count_multi_widget; $i++)
            {
                $cat_str = get_option( PREFIX.'_multi_widget_categories_'. $i );			
				$catArr = explode("_", $cat_str);
				if(!isset($catArr[1])) continue;
				$cat_id = $catArr[1];
                if ( $cat_id > 0 ) $catIDArr[] = $cat_id; 					
            }
            if (is_array($catIDArr))
                if (in_array($catID, $catIDArr)) { $is_widget = true; dynamic_sidebar("Sidebar Category - ".get_cat_name($catID)); }
        }
    }
 

if (!$is_widget) {  
	if ( !is_home() && !is_page() && !is_single() && !is_category()) dynamic_sidebar('General Sidebar');
	
	if ( is_page() ) is_active_sidebar('sidebar-page') ? dynamic_sidebar('Sidebar Page') : dynamic_sidebar('General Sidebar');
	if ( is_single() ) is_active_sidebar('sidebar-single-post') ? dynamic_sidebar('Sidebar Single Post') : dynamic_sidebar('General Sidebar');
	if ( is_category() ) is_active_sidebar('sidebar-category') ? dynamic_sidebar('Sidebar Category ') : dynamic_sidebar('General Sidebar');
}


?>  
