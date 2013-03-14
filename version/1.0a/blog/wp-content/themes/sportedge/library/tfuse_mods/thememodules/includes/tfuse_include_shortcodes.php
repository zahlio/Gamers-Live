<?php
// This Function Show the Shortcodes after Page, post or Category
if ( ! function_exists( 'tfuse_shortcode_content' ) ) :
    function tfuse_shortcode_content($position = '', $return = false)
    {
        global $post;

        $page_shortcodes = '';
 
        if ( is_page() )
        {
            $after_shortcodes   = get_post_meta($post->ID, PREFIX . '_page_content_bottom', true);
            $before_shortcodes = get_post_meta($post->ID, PREFIX . '_page_content_top', true);
        }

        elseif ( is_single()	)
        {
            $after_shortcodes   = get_post_meta($post->ID, PREFIX . '_post_content_bottom', true);
            $before_shortcodes  = get_post_meta($post->ID, PREFIX . '_post_content_top', true);;
        }

        elseif ( is_category() )
        {
            $cat_ID             = get_query_var('cat');
            $after_shortcodes   = get_option(PREFIX . '_category_content_bottom_' . $cat_ID);
            $before_shortcodes   = get_option(PREFIX . '_category_content_top_' . $cat_ID);

        }
        else
        {
            $before_shortcodes = $after_shortcodes   = '';
        }

        $after_shortcodes   = tfuse_qtranslate($after_shortcodes);
        $before_shortcodes  = tfuse_qtranslate($before_shortcodes);

        if ( $before_shortcodes != '' && $position == 'before' )
        {
           $page_shortcodes  = apply_filters('themefuse_shortcodes',$before_shortcodes);
        }
        elseif ( $after_shortcodes != '' && $position == 'after' )
        {
           $page_shortcodes  = apply_filters('themefuse_shortcodes',$after_shortcodes);
        }
        if ( $return ) return $page_shortcodes; else echo $page_shortcodes;

    } // End function tfuse_shortcode_content()
endif;
?>