<?php
function tfuse_pagination($query_string){
	global $posts_per_page, $paged;
	
	$my_query = new WP_Query($query_string ."&posts_per_page=-1");
	$total_posts = $my_query->post_count;
	
	if(empty($paged))$paged = 1;
	
	$prev = $paged - 1;							
	$next = $paged + 1;	
	$range = 2; // only edit this if you want to show more page-links
	$showitems = ($range * 2)+1;
	
	if($posts_per_page != 0)
	{
		$pages = ceil($total_posts/$posts_per_page);
	}
	else
	{
		$pages = 1;
	}
	
	if(1 != $pages){
		echo ($paged > 2 && $paged > $range+1 && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>&laquo;</a>":"";
		echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>&lsaquo;</a>":"";
	
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				echo ($paged == $i)? "<a href='".get_pagenum_link($i)."' class='current'>".$i."</a>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>"; 
			}
		}
		
		echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>&rsaquo;</a>" :"";
		echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>&raquo;</a>":"";
	}
}
?>