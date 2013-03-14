<?php

function tfuse_popular_post($atts, $content) {

    extract(shortcode_atts(array('items' => 2, 'title' => 'Popular Posts'), $atts));
     $tfuse_posts = tfuse_post_tab('popular', $items,75,75, 'thumbnail');

    $return_html = '';
    $return_html .= ( $title ) ? '<h3>'.__($title).'</h3>' : '<h3>'.__('Popular Posts').'</h3>';
    $return_html .= '<div class="widget_recent_posts">
                            <ul>';
         foreach($tfuse_posts as $val)
         {
             $return_html .= '<li>';
             $return_html .= (!empty($val['title'])) ? '<a href="'.$val['link'].'" class="post-title">'.$val['title'].'</a>' : '';
             $return_html .='<div class="post-meta">'.$val['comments'].'</div>
               <div class="extras">';
             $return_html .=(!empty($val['image'])) ? '<a href="'.$val['link'].'">'.$val['image'].'</a>' : '';
             $return_html .= $val['excerpt'].'</div>
               <a href="'.$val['link'].'" class="button_link"><span>'.__('Read', 'tfuse').'</span></a>
               </li>';
         }


   $return_html .= '</ul>
                        </div>';
	return apply_filters('tfuse_popular_post', $return_html);
}
add_shortcode('popular_posts', 'tfuse_popular_post');
?>