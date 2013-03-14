<?php
// ************************Latest
function tfuse_latest_popular($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array( 'items' => 5	), $atts));
    $tfuse_rec_post      = tfuse_post_tab('recent', $items, 54,54, 'thumbnail', 'M d,Y', false);
    
    $tfuse_mos_com_post  = tfuse_post_tab('most_commented', $items, 54,54, 'thumbnail', 'M d,Y', false);
	$return_html =	'<div class="tf_sidebar_tabs tabs_framed">
						<ul class="tabs">
							<li><a href="#tf_tabs_1">'.__('Recent Posts').'</a></li>
							<li><a href="#tf_tabs_2">'.__('Most Commented').'</a></li>
						</ul> ';
                    
    $return_html .='<div id="tf_tabs_1" class="tabcontent">
                        <ul class="post_list popular_posts">';
	foreach ( $tfuse_rec_post as $rec_post ) :
    $return_html .= '<li><a href="'.$rec_post['link'].'">'.$rec_post['image'].'</a><a href="'.$rec_post['link'].'">'.$rec_post['title'].'</a><div class="date">'.$rec_post['date'].'</div></li>';
    endforeach;

    $return_html .= '</ul></div> ';
	$return_html .=	'<div id="tf_tabs_2" class="tabcontent">
							<ul class="post_list recent_posts">';
    foreach ( $tfuse_mos_com_post as $mos_com_post ) :
    $return_html .= '<li><a href="'.$mos_com_post['link'].'">'.$mos_com_post['image'].'</a><a href="'.$mos_com_post['link'].'">'.$mos_com_post['title'].'</a><div class="date">'.$mos_com_post['date'].'</div></li>';
    endforeach;
	$return_html .= '</ul></div>
	
	</div>';	
	
	return apply_filters('tfuse_latest_popular', $return_html);

}
add_shortcode('latest_popular_posts', 'tfuse_latest_popular');
?>