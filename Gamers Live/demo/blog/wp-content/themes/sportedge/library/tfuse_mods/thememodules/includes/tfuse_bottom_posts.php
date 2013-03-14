<?php

   function tfuse_bottom_posts_boxes()
   {
       global $post;
       $return_html = '';
       $tfuse_cat_posts       = get_post_meta( $post->ID, PREFIX.'_page_bottom_cat_hidden', true );
       $tfuse_numb_posts      = get_post_meta($post->ID,PREFIX.'_page_btm_number_posts',true);


       $items = (!empty($tfuse_numb_posts)) ? $tfuse_numb_posts : 7;
       for($i = 0; $i < $tfuse_cat_posts; $i++)
       {
           $cat_str = get_post_meta( $post->ID, PREFIX.'_page_bottom_cat_'. $i, true );

           $catArr = explode("_", $cat_str);
           if(!isset($catArr[1])) continue;
           $cat_id = $catArr[1];
           if ( $cat_id > 0 ) $catIDArr[] = $cat_id;
           $category =  get_categories('include='.$cat_id);
           $tfuse_cat = $category[0]->cat_name;
           $return_html = tfuse_bottom_posts_box($items,$tfuse_cat);
       }

       return $return_html;
   }

function tfuse_bottom_posts_box($items = 7,$category ='')
{
    $return_html = '';

    $tfuse_posts = tfuse_post_tab('recent', $items, '', '','nofloat','M j', true, $category);

    foreach($tfuse_posts as $key=>$val)
    {
        if ($key == 0)
        {
            $return_html .='<div class="col col_1_3">
            <div class="featured_post featured_style2">
                       <div class="meta-date"><span class="ico_cat">'.$val['category'].'</span> '.$val['date'].'</div>';
                       if ( !empty($val['image']) || !empty($val['title']))
                       {
                           $return_html .='<div class="post-name">';
                                $return_html .= (!empty($val['image'])) ? '<div class="post-image">'.$val['image'].'</div>' : '';
                                $return_html .= (!empty($val['title'])) ? '<div class="post-title"><a href="'.$val['link'].'">'.$val['title'].'</a></div>' : '';
                           $return_html .='</div>';
                       }
                         $return_html .='<div class="post-short">'.$val['excerpt'].'</div>
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
   $return_html .='</div>
   </div>';

    echo  $return_html;
}

function tfuse_latest_post_cat($category = '')
{
    global $post;
    $tfuse_numb_posts      = get_post_meta($post->ID,PREFIX.'_post_bottom_number',true);
    $items = (!empty($tfuse_numb_posts)) ? $tfuse_numb_posts :3;
    $return_html = '';
    $return_html .='<div class="post-list">';

    $exclude = $post->ID;
    $tfuse_posts = tfuse_post_tab('recent', $items, '120', '100','imgalignleft','M j', true, $category, $exclude);

    foreach($tfuse_posts as $val ) :
    $return_html .='<div class="post-item">
                            <div class="meta-date">'.$val['date'].'</div>
                           <div class="post-descr">';
                               $return_html .=(!empty($val['title'])) ? '<h2><a href="'.$val['link'].'">'.$val['title'].'</a></h2>'  : '';
                                $return_html .='<p class="post-short">';
                                $return_html .= (!empty($val['image'])) ? $val['image'] : '';
                                $return_html .= $val['excerpt'].'</p>
                               <div class="meta-bot"><a href="'.$val['link'].'" class="button_link"><span>'.__('Read', 'tfuse').'</span></a> &nbsp; '.$val['comments'].'</div>
                           </div>
                   </div>';
    endforeach;

   $return_html .='<div class="clear"></div>
       </div>';
   return $return_html;
}
?>