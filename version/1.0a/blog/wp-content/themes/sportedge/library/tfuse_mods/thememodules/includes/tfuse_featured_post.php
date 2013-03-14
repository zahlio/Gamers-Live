<?php
function tfuse_featured_posts_tab()
{
    global $post;
    $cat_ID = get_query_var('cat');
    $return_html = '';
    if ( is_page() )
    {
        $tfuse_rec_pst_titl    = get_post_meta($post->ID,PREFIX.'_page_tab_name_recent',true);
        $tfuse_pop_pst_titl    = get_post_meta($post->ID,PREFIX.'_page_tab_name_popular',true);
        $tfuse_mst_cm_pst_titl = get_post_meta($post->ID,PREFIX.'_page_tab_name_most_commented',true);
        $tfuse_numb_posts      = get_post_meta($post->ID,PREFIX.'_page_tab_number_posts',true);
        $tfuse_cat = '';
    }
    elseif( is_category() )
    {
        $tfuse_rec_pst_titl    = get_option(PREFIX.'_category_tab_name_recent_'.$cat_ID);
        $tfuse_pop_pst_titl    = get_option(PREFIX.'_category_tab_name_popular_'.$cat_ID);
        $tfuse_mst_cm_pst_titl = get_option(PREFIX.'_category_tab_name_most_commented_'.$cat_ID);
        $tfuse_numb_posts      = get_option(PREFIX.'_category_tab_number_posts_'.$cat_ID);
        $category =  get_the_category();
        $tfuse_cat = $category[0]->cat_name;

    }
    $items = (!empty($tfuse_numb_posts)) ? $tfuse_numb_posts : 7;

    $return_html .= '<div class="featured_tabs">
                        <ul class="tabs">';
        $return_html .= (!empty($tfuse_rec_pst_titl)) ? '<li><a href="#featured_tab_1">'.tfuse_qtranslate($tfuse_rec_pst_titl).'</a></li>' : '';
        $return_html .= (!empty($tfuse_pop_pst_titl)) ?'<li><a href="#featured_tab_2">'.tfuse_qtranslate($tfuse_pop_pst_titl).'</a></li>' : '';
        $return_html .= (!empty($tfuse_mst_cm_pst_titl)) ?'<li><a href="#featured_tab_3">'.tfuse_qtranslate($tfuse_mst_cm_pst_titl).'</a></li>' : '';
        $return_html .= '</ul>';



        $return_html .= (!empty($tfuse_rec_pst_titl)) ?'<div id="featured_tab_1" class="tabcontent">'. tfuse_featured_posts('recent',$items,$tfuse_cat).'</div>': '';
        $return_html .= (!empty($tfuse_pop_pst_titl)) ?'<div id="featured_tab_2" class="tabcontent">'.tfuse_featured_posts('popular',$items,$tfuse_cat).'</div>': '';
        $return_html .= (!empty($tfuse_mst_cm_pst_titl)) ?'<div id="featured_tab_3" class="tabcontent">'.tfuse_featured_posts('most_commented',$items,$tfuse_cat).'</div>': '';
    $return_html .= '</div>';

    echo $return_html;
}
function tfuse_featured_posts( $type = 'recent', $items = 5, $category = '')
{
    global $tfuse_rec_post_ID;
    $tfuse_posts = tfuse_post_tab($type, $items, 300, 295,'','M j', true, $category);
    $return_html = '';
    foreach($tfuse_posts as $key=>$val)
         {
             if ($key == 0)
             {  if( $type == 'recent') $tfuse_rec_post_ID = $val['post_ID'];
                 $return_html .= '<div class="featured_post">
                        	        <div class="meta-date"><span class="ico_cat">'.$val['category'].'</span> '.$val['date'].'</div>
                                    <div class="post-name">
                                        <div class="post-image">'.$val['image'].'</div>
                                        <div class="post-title"><a href="'.$val['link'].'">'.$val['title'].'</a></div>
                                    </div>
                                    <div class="post-short">'.$val['excerpt'].'</div>
                                    <div class="meta-bot"><a href="'.$val['link'].'" class="button_link"><span>'.__('Read', 'tfuse').'</span></a> &nbsp; '.$val['comments'].'</div>';
                 $return_html .='</div>';
                 $return_html .='<div class="featured_list">
                        	<ul>';
             }
             else
             {
                $return_html .='<li>
                                <a href="'.$val['link'].'" class="post-title">'.$val['title'].'</a>
                                <div class="meta-date"><span class="ico_cat">'.$val['category'].'</span> '.$val['date'].'</div>';
                $return_html .='</li>';
             }
         }
        $return_html .='</ul>
                       <a href="'.get_year_link('').'" class="link-comments">'.__('Browse Archive','tfuse').'</a>';
        $return_html .='</div><!--/ .featured_list -->
        <div class="clear"></div>';

    return $return_html;

}
?>