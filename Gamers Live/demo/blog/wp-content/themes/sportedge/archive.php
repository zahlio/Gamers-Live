<?php

	if ( is_category() ) $cat_ID = get_query_var('cat');
 	
 	if ( is_category() ) {
			if ( get_option(PREFIX.'_category_template_'.$cat_ID)!='' ) require_once( TEMPLATE_CAT.'/'.get_option(PREFIX.'_category_template_'.$cat_ID) );
			else 														require_once( TEMPLATE_CAT.'/default.php');
	} else {
 		require_once( TEMPLATE_CAT.'/default.php' );
	}

?>