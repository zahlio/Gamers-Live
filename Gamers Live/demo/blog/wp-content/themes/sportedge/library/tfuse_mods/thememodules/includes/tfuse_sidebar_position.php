<?php 
if ( ! function_exists( 'tfuse_sidebar_position' ) ):
	function tfuse_sidebar_position ($param = '')
    {
		global $post;
        $sidebar_position = '';
		if ( is_page() )
		{
		    $sidebar_position = get_post_meta($post->ID, PREFIX . '_page_sidebar_position', true);
        }
		elseif ( is_single() )
		{
			$sidebar_position = get_post_meta($post->ID, PREFIX.  '_post_sidebar_position', true);
        }
		elseif ( is_category()  )
		{
			$cat_ID = get_query_var('cat');
			$sidebar_position = get_option( PREFIX . '_category_sidebar_position_' . $cat_ID);
		}

        if ( $param == 'top' )
        {

            if ( $sidebar_position == 'default' ||  empty($sidebar_position) || $sidebar_position == 'full' )
            {
               $top_sidebar_position = get_option(PREFIX.'_sidebar_position');
               $sidebar_position = ($top_sidebar_position == 'full') ? 'right' : $top_sidebar_position;
            }

        }
        elseif ( $sidebar_position == 'default' ||  empty($sidebar_position) )
            $sidebar_position = get_option(PREFIX.'_sidebar_position');
        return $sidebar_position;

	}   // End function tfuse_sidebar_position()

endif;


?>