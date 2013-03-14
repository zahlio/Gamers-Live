<?php
// ************************Latest
function tfuse_row_post($atts, $content=null)
{

	//extract short code attr
	extract(shortcode_atts(array('items' => '5',   'category' =>'' ), $atts));

    $return_html ='';

    $tfuse_posts = tfuse_post_tab('recent', $items, 120, 100,'','M j', true, $category);

        $return_html .='<div class="post-list">';
         foreach($tfuse_posts as $val)
         {
                 $return_html .='<div class="imt-pst post-item">
            <div class="meta-date">'.$val['date'].'</div>
            <div class="post-descr">';
                $return_html .= (!empty($val['title'])) ? '<h2><a href="'.$val['link'].'">'.$val['title'].'</a></h2>' : '';
                $return_html .='<p class="post-short">';
                $return_html .=(!empty($val['image'])) ?  $val['image'] : '';
                $return_html .=$val['excerpt'].'</p>
                <div class="meta-bot"><a href="'.$val['link'].'" class="button_link"><span>'.__('Read', 'tfuse').'</span></a> &nbsp; '.$val['comments'].'</div>
            </div>
            </div>';
         }
         $return_html .='<div class="clear"></div>';
    $return_html .='</div>';

    return apply_filters('tfuse_row_post', $return_html);

}
    add_shortcode('row_post', 'tfuse_row_post');
?>