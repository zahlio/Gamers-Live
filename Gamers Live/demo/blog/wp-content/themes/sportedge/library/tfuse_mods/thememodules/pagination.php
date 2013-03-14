<?php
 
	function tfuse_number_pagination( $args = array(), $query = '' ) {
		global $wp_rewrite, $wp_query;
		
		if ( $query ) {
		
			$wp_query = $query;
		
		} // End IF Statement
		
	
		/* If there's not more than one page, return nothing. */
		if ( 1 >= $wp_query->max_num_pages )
			return;
	
		/* Get the current page. */
		$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
	
		/* Get the max number of pages. */
		$max_num_pages = intval( $wp_query->max_num_pages );

		/* Set up some default arguments for the paginate_links() function. */
		$defaults = array(
			'base' => add_query_arg( 'paged', '%#%' ),
			'format' => '',
			'total' => $max_num_pages,
			'current' => $current,
			'prev_next' => true,
			'prev_text' => '', // Translate in WordPress. This is the default.
			'next_text' => '', // Translate in WordPress. This is the default.
			'show_all' => false,
			'end_size' => 4,
			'mid_size' => 1,
			'add_fragment' => '',
			'type' => 'plain',
			'before' => '',
			'after' => '',
			'echo' => false,
		);
	
		/* Add the $base argument to the array if the user is using permalinks. */
		if( $wp_rewrite->using_permalinks() )
			$defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );
	
		/* If we're on a search results page, we need to change this up a bit. */
		if ( is_search() ) {
			$search_permastruct = $wp_rewrite->get_search_permastruct();
			if ( !empty( $search_permastruct ) )
				$defaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . 'page/%#%' );
		}
	
		/* Merge the arguments input with the defaults. */
		$args = wp_parse_args( $args, $defaults );
	
		/* Don't allow the user to set this to an array. */
		if ( 'array' == $args['type'] )
			$args['type'] = 'plain';
	
		/* Get the paginated links. */
		$page_links = paginate_links( $args );
        //var_dump($page_links);

		/* Remove 'page/1' from the entire output since it's not needed. */
		$page_links = str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_links );
	
		/* Wrap the paginated links with the $before and $after elements. */
		$page_links = $args['before'] . $page_links . $args['after'];
	


        $patterns = array ('/<span class=\'page-numbers current\'>/', '/\d+<\/span>/');
        $replace = array ('<a href="#" class="page_current" ><span>', '$0</a>');
        $tfuse_pages = preg_replace($patterns, $replace, $page_links);


		/* Return the paginated links for use in themes. */
		if ( $args['echo'] )
			echo $tfuse_pages;
		else
			return $tfuse_pages;
			
	} 
 

function tfuse_pagination()
    {

		if ( get_next_posts_link()!='' || get_previous_posts_link()!='' )
        { ?>

			<div class="tf_pagination">
				<span class="page_next button_link"><?php next_posts_link(  __( 'Next page', 'tfuse' )  ); ?></span>
				<span class="page_prev button_link"><?php previous_posts_link(  __( 'Prev page', 'tfuse' ) ); ?></span>
			    <?php echo tfuse_number_pagination(); ?>
            </div>

		<?php }
	}  ?>