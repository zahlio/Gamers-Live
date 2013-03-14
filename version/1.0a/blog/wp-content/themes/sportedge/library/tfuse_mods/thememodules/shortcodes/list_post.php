<?php
// ************************Latest
function tfuse_list_post($atts, $content=null)
{

	//extract short code attr
	extract(shortcode_atts(array('items' => '5',  'type'=>'recent', 'show_cat' =>true ), $atts));

    $return_html ='';

        $tfuse_posts = tfuse_post_tab($type, $items, '', '','nofloat','M j');



         foreach($tfuse_posts as $key=>$val)
         {
             if ($key == 0)
             {
                 $return_html .='<div class="featured_post featured_style2">
                        	<div class="meta-date"><span class="ico_cat">'.$val['category'].'</span> '.$val['date'].'</div>
                        	<div class="post-name">';
                            	 $return_html .=(!empty($val['image'])) ? '<div class="post-image">'.$val['image'].'</div>' : '';
                                 $return_html .=(!empty($val['title'])) ? '<div class="post-title"><a href="'.$val['link'].'">'.$val['title'].'</a></div>' : '';
                          	     $return_html .='</div>
                          	<div class="post-short">'.$val['excerpt'].'</div>
                            <div class="meta-bot"><a href="'.$val['link'].'" class="button_link"><span>'.__('Read', 'tfuse').'</span></a> &nbsp; '.$val['comments'].'</div>';
                 $return_html .='</div>';
                 $return_html .='<div class="featured_list">
                        	<ul>';
             }
             else
             {
                $return_html .='<li>';
                                 $return_html .=(!empty($val['title'])) ? '<a href="'.$val['link'].'" class="post-title">'.$val['title'].'</a>' : '';
                                 $return_html .='<div class="meta-date">';
                                if ( !empty($show_cat)  )   $return_html .=' <span class="ico_cat">'.$val['category'].'</span> ';
                                $return_html .= $val['date'].'</div>';
                $return_html .='</li>';
             }
         }
         $return_html .='</ul>';
    $return_html .='</div>';

    return apply_filters('tfuse_list_post', $return_html);

}
    add_shortcode('list_post', 'tfuse_list_post');
?>