<?php
// ************************Latest
function tfuse_posts_tabs($atts, $content=null)
{

	//extract short code attr
	extract(shortcode_atts(array('items' => '5', 'title'=>'', 'type'=>'recent', 'category'=>'' ), $atts));
    global  $framedtabsheading;
    $return_html ='';
    $tfuse_param = array();

    if ( $type == 'recent' || $type == '' )
        $tfuse_posts = tfuse_post_tab('recent', $items, 300, 295,'','M j', true, $category);

    elseif ( $type == 'popular' )
        $tfuse_posts = tfuse_post_tab('popular', $items, 300, 295,'','M j', true, $category);

    elseif ( $type == 'most_commented' )
        $tfuse_posts = tfuse_post_tab('most_commented', $items, 300, 295,'','M j', true, $category);

    $k = 0;
	while(isset($framedtabsheading[$k])) { $k++;}

	$framedtabsheading[] = '<li><a href="featured_tab_'.($k+1).'">' . $title . '</a></li>';

         $return_html .='<div id="featured_tab_'.($k+1).'" class="tabcontent">';
         foreach($tfuse_posts as $key=>$val)
         {
             if ($key == 0)
             {
                 $return_html .='<div class="featured_post">
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
    $return_html .='</div><!--/ .tabcontent -->';

    return apply_filters('tfuse_posts_tabs', $return_html);

}
    add_shortcode('posts_tabs', 'tfuse_posts_tabs');
?>