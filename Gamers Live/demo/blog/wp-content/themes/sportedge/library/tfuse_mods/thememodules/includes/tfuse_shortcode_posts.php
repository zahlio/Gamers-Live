<?php 
function tfuse_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;

    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function tfuse_post_tab($type='recent', $items=5, $img_width = 300, $img_height = 295, $img_class = '', $format_date='F jS, Y', $time_ago = true, $tfuse_post_categ ='', $exclude='')
{
    global $wpdb, $post;
    $tfuse_post_param = array();
    if ( $type == 'recent' )
    {
        $tfuse_post_categ = ($tfuse_post_categ !='') ? 'category='.get_cat_ID( $tfuse_post_categ ) : '';
        $tfuse_exclude = (!empty($exclude)) ? 'exclude='.$exclude : '';
        $tfuse_posts   = get_posts('numberposts='.$items.'&'.$tfuse_post_categ.'&order=DESC&orderby=date&post_type=post&post_status=publish&'.$tfuse_exclude);
    }
    elseif( $type == 'most_commented' )
    {
        $tfuse_categ_ID = ($tfuse_post_categ !='') ? get_cat_ID( $tfuse_post_categ ) : '';
        $query = new WP_Query( array ( 'post_type' => 'post',  'orderby' => 'comment_count', 'order '=>'DESC','cat'=> $tfuse_categ_ID, 'posts_per_page'=>$items ) );
        $tfuse_posts  = $query->get_posts();
    }
    elseif( $type == 'popular')
    {
        $tfuse_categ_ID = ($tfuse_post_categ !='') ? get_cat_ID( $tfuse_post_categ ) : '';
        $query = new WP_Query( array ( 'post_type' => 'post', 'orderby' => 'meta_value', 'meta_key' => PREFIX.'_post_viewed', 'order '=>'DESC', 'cat'=> $tfuse_categ_ID, 'posts_per_page'=>$items ) );
        $tfuse_posts  = $query->get_posts();
    }
    else
    {
        $tfuse_posts   = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_type=post&post_status=publish');
    }

    $count = 0;
    if ( empty($img_height)) $img_height = 300;
    if ( empty($img_width)) $img_width = 300;
    foreach( $tfuse_posts as $postArr)
    {
        $post = get_post($postArr->ID);

        setup_postdata($post);

        $tfuse_post_param[$count]['post_ID'] = $postArr->ID;

        $tfuse_post_param[$count]['title'] = get_the_title();
        $tfuse_post_param[$count]['title'] = ( $tfuse_post_param[$count]['title'] == '') ? '' : $tfuse_post_param[$count]['title'];

        $tfuse_post_param[$count]['link'] = get_permalink();

        $tfuse_post_param[$count]['excerpt'] = get_the_excerpt();
        $tfuse_post_param[$count]['excerpt'] = ( $tfuse_post_param[$count]['excerpt'] == '') ? '' : $tfuse_post_param[$count]['excerpt'];

        $category =  get_the_category();
        $tfuse_post_param[$count]['category'] = $category[0]->cat_name;

        $tfuse_post_param[$count]['date']  = get_the_time($format_date, $postArr->ID);
        $tfuse_post_param[$count]['date']  .= ($time_ago) ?  ', ' . tfuse_time_ago($postArr->ID, true) : '';
        $tfuse_post_param[$count]['comments']  = tfuse_get_comments(true,$postArr->ID );

        $tfuse_post_param[$count]['image'] = tfuse_media('fixed',$img_width, $img_height, true, true, $img_class);

        $count++;
    }
    wp_reset_postdata();
    
    return $tfuse_post_param;
}
?>