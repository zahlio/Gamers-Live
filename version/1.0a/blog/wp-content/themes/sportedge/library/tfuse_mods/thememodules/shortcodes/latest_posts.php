<?php
// ************************Latest
function tfuse_latest_post($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 2, 'title' => 'Recent Posts'), $atts));
     $tfuse_posts = tfuse_post_tab('recent', $items, 75,75, 'thumbnail');
    $return_html = '';
    $return_html .= ( $title ) ? '<h3>'.__($title).'</h3>' : __('Recent Posts');
    $return_html .= '<div class="widget_recent_posts">
                            <ul>';
         foreach($tfuse_posts as $val)
         {
             $return_html .= '<li>';
             $return_html .= (!empty($val['title']) ) ? '<a href="'.$val['link'].'" class="post-title">'.$val['title'].'</a>' : '';
               $return_html .= ' <div class="post-meta">'.$val['comments'].'</div>
               <div class="extras">';
               $return_html .= (!empty($val['image']) ) ? '<a href="'.$val['link'].'">'.$val['image'].'</a>' : '';
               $return_html .= $val['excerpt'].'</div>
               <a href="'.$val['link'].'" class="button_link"><span>'.__('Read', 'tfuse').'</span></a>
               </li>';
         }


   $return_html .= '</ul>
                        </div>';


   return apply_filters('tfuse_latest_post', $return_html);

}
add_shortcode('latest_posts', 'tfuse_latest_post');
?>