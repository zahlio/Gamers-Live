<?php  
 
function tfuse_header_parametrs()
{		
	global $post, $cat_ID;
	
    $tfuse_param = array('header_element' => '',
                         'type_slider' => '',
                         'populated_method_of_slider' => '',
                         'category_post_slide' => '',
                         'number_of_post' => '',
                         'type_page' => ''
    );

	if (is_page())
	{ 
		$tfuse_param['header_element'] = get_post_meta($post->ID, PREFIX . '_page_select_header_element', true);
        $tfuse_param['type_slider']    = get_post_meta($post->ID, PREFIX . '_page_select_type_slider', true);
		$tfuse_param['random_posts']   = get_post_meta($post->ID, PREFIX . '_page_slider_posts_hidden', true);
		$tfuse_param['post_category']  = get_post_meta($post->ID, PREFIX . '_page_slider_cat', true);
		$tfuse_param['number_of_post'] = get_post_meta($post->ID, PREFIX . '_page_number_post',true);
		$tfuse_param['type_page']      = 'page';
	}
	if (is_single()) 		
	{
        $tfuse_param['header_element'] = get_post_meta($post->ID, PREFIX . '_post_select_header_element', true);
        $tfuse_param['type_slider']    = get_post_meta($post->ID, PREFIX . '_post_select_type_slider', true);
        $tfuse_param['random_posts']   = get_post_meta($post->ID, PREFIX . '_post_slider_posts_hidden', true);
        $tfuse_param['post_category']  = get_post_meta($post->ID, PREFIX . '_post_slider_cat', true);
        $tfuse_param['number_of_post'] = get_post_meta($post->ID, PREFIX . '_post_number_post',true);
        $tfuse_param['type_page']      = 'post';
	}
	elseif (is_category())	
	{
		$tfuse_param['header_element'] = get_option( PREFIX . '_category_select_header_element_' . $cat_ID);
		$tfuse_param['type_slider']    = get_option( PREFIX . '_category_type_slider_' . $cat_ID);
        $tfuse_param['random_posts']   = get_option(PREFIX .  '_category_slider_posts_'.$cat_ID.'_hidden');
        $tfuse_param['post_category']  = get_option( PREFIX . '_category_slider_cat_'  . $cat_ID);
		$tfuse_param['number_of_post'] = get_option( PREFIX . '_category_number_post_' . $cat_ID);
        $tfuse_param['type_page']      = ''; 		       		   
	}

	return $tfuse_param;
}

function tfuse_post_options()
{

	$tfuse_slide_post =  array();
	
	$tfuse_param = tfuse_header_parametrs();
    
    if ( $tfuse_param['type_slider'] == 'typeslider1' )
    {
	    $tfuse_args = array( 'numberposts' => $tfuse_param['number_of_post'], 'category' => $tfuse_param['post_category']  );
    }
    elseif ( $tfuse_param['type_slider'] == 'typeslider3' && is_singular() )
    {
        $tfuse_args = array( 'numberposts' => $tfuse_param['number_of_post'] );
    }
    elseif ( $tfuse_param['type_slider'] == 'typeslider2' && is_category() )
    {
        $tfuse_args = array( 'numberposts' => $tfuse_param['number_of_post'] );
    }

    $tfuse_slide_post = ( isset($tfuse_args)) ? get_posts($tfuse_args) : '';
    return $tfuse_slide_post;
}
function tfuse_select_posts_sld()
{
    global $post, $cat_ID;
    $tfuse_param = tfuse_header_parametrs();
    if ( is_singular() )
    {
        for($i = 0; $i < $tfuse_param['random_posts']; $i++)
        {
            $page_str = get_post_meta( $post->ID, PREFIX.'_page_slider_posts_'. $i, true );
            $pageArr = explode("_", $page_str);
            if(!isset($pageArr[1])) continue;
            $page_id = $pageArr[1];
            if ( $page_id > 0 ) $pageIDArr[] = $page_id;
        }
    }
    elseif ( is_category() )
    {
        for($i = 0; $i < $tfuse_param['random_posts']; $i++)
        {
            $page_str = get_option(PREFIX.'_category_slider_posts_'. $cat_ID .'_'.$i );
            $pageArr = explode("_", $page_str);
            if(!isset($pageArr[1])) continue;
            $page_id = $pageArr[1];
            if ( $page_id > 0 ) $pageIDArr[] = $page_id;
        }
    }

    return $pageIDArr;
}

function tfuse_post_slider_options()
{
	global $post;
	$tfuse_param = tfuse_header_parametrs();
    $post_arr = $tfuse_sld_prm = array();
    $count = 0;
    if ( $tfuse_param['type_slider'] == 'typeslider4' && is_singular() )
       $post_arr    =  tfuse_select_posts_sld();
    elseif ( $tfuse_param['type_slider'] == 'typeslider3' && is_category() )
        $post_arr    =  tfuse_select_posts_sld();
    elseif ( ($tfuse_param['type_slider'] == 'typeslider1' || $tfuse_param['type_slider'] == 'typeslider3') && is_singular() )
        $post_arr    = tfuse_post_options();
    elseif ( ($tfuse_param['type_slider'] == 'typeslider1' || $tfuse_param['type_slider'] == 'typeslider2') && is_category() )
        $post_arr    = tfuse_post_options();

    foreach( $post_arr as $post_dtl )
    {

        if ( $tfuse_param['type_slider'] == 'typeslider4' && is_singular() )
            $tfuse_sld_post_ID = $post_dtl;
        elseif ( $tfuse_param['type_slider'] == 'typeslider3' && is_category() )
            $tfuse_sld_post_ID = $post_dtl;
        elseif ( ($tfuse_param['type_slider'] == 'typeslider1' || $tfuse_param['type_slider'] == 'typeslider3') && is_singular() )
           $tfuse_sld_post_ID = $post_dtl->ID;
        elseif ( ($tfuse_param['type_slider'] == 'typeslider1' || $tfuse_param['type_slider'] == 'typeslider2') && is_category() )
            $tfuse_sld_post_ID = $post_dtl->ID;

        $post = get_post($tfuse_sld_post_ID);

        setup_postdata($post);

        $tfuse_sld_prm[$count]['image'] = get_post_meta($tfuse_sld_post_ID, PREFIX.'_post_image', true);
        $tfuse_sld_prm[$count]['image'] = ( $tfuse_sld_prm[$count]['image'] == '') ? '' : $tfuse_sld_prm[$count]['image'];

        $tfuse_sld_prm[$count]['title'] = get_the_title();
        $tfuse_sld_prm[$count]['title'] = ( $tfuse_sld_prm[$count]['title'] == '') ? '' : $tfuse_sld_prm[$count]['title'];

        $tfuse_sld_prm[$count]['link']  = get_permalink();
        $tfuse_sld_prm[$count]['date']  = get_the_time('l jS ', $tfuse_sld_post_ID) .__('of ', 'tfuse'). get_the_time('F', $tfuse_sld_post_ID) . ', ' . tfuse_time_ago($tfuse_sld_post_ID, true);

        foreach((get_the_category($tfuse_sld_post_ID)) as $tfuse_cat)
        {
            $tfuse_sld_prm[$count]['category'] = tfuse_qtranslate($tfuse_cat->name);
        }
        $tfuse_sld_prm[$count]['category'] = ( $tfuse_sld_prm[$count]['category'] == '') ? '' : tfuse_qtranslate($tfuse_sld_prm[$count]['category']);

        $tfuse_sld_prm[$count]['type'] = 'post';
        $tfuse_sld_prm[$count]['target'] = '';

        $count++;
    } wp_reset_postdata();

	return $tfuse_sld_prm;
}

function tfuse_image_slider_options()
{
	global $post;
	
	$tfuse_param = tfuse_header_parametrs();
	$image_arr   = array();


    $tfuse_image_upload	    	 = '_' . $tfuse_param['type_page'] . '_slider_data_sliderdata_';
    $img_prefix = 'slider_' . $tfuse_param['type_page'];

	
	$k = 1; 
	while(tfuse_meta_exist(PREFIX .$tfuse_image_upload	. $k, $post->ID))
	{	
		$slideArr = get_post_meta($post->ID, PREFIX.$tfuse_image_upload	.$k, true);
		
		$image_arr[$k-1]['image'] =  $slideArr['img'];
		
		if ( ! empty($slideArr[$img_prefix . '_title']) )
			$image_arr[$k-1]['title']   = tfuse_qtranslate($slideArr[$img_prefix 	. '_title']); else $image_arr[$k-1]['title'] = '';
		
		if ( ! empty($slideArr[$img_prefix 	. '_link']) )  
			$image_arr[$k-1]['link']    =  $slideArr[$img_prefix 	. '_link']; else $image_arr[$k-1]['link']  = '';

        if ( ! empty( $slideArr[$img_prefix . '_category'] ) )
            $image_arr[$k-1]['category']  =  tfuse_qtranslate($slideArr[$img_prefix 	. '_category']); else $image_arr[$k-1]['category'] = '';

        if ( ! empty( $slideArr[$img_prefix . '_target'] ) )
            $image_arr[$k-1]['target']  =  'target ='.$slideArr[$img_prefix. '_target'].'"'; else $image_arr[$k-1]['target'] = '';

        $image_arr[$k-1]['date']  = tfuse_qtranslate(get_the_time('F jS, Y', $post->ID) . ', ' . tfuse_time_ago($post->ID, true));
        $image_arr[$k-1]['type'] = 'upload';
		$k++;
	}
		
	return $image_arr;

}

function tfuse_slides()
{
	$tfuse_param = tfuse_header_parametrs();
	$slides = array();
   
	if ($tfuse_param['type_slider'] != 'typeslider2' || is_category() )
	{ 	
		$slides = tfuse_post_slider_options();
	}
	elseif ($tfuse_param['type_slider'] == 'typeslider2')
	{	
		$slides = tfuse_image_slider_options();
	}
		
	return $slides;
}

?>