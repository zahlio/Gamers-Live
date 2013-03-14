<?php

// Register widgetized areas

function the_widgets_init()
{
	global $tfuse;
	$prefix = $tfuse->prefix;

	if(!function_exists('register_sidebars'))
		return;

	register_sidebar(array('name' => 'General Sidebar', 'id' => 'sidebar-1', 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebar(array('name' => 'Sidebar Page', 'id' => 'sidebar-page', 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebar(array('name' => 'Sidebar Single Post', 'id' => 'sidebar-single-post', 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
	register_sidebar(array('name' => 'Sidebar Category', 'id' => 'sidebar-category', 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));




	// Multi Page Widget
	$multi_widget = "{$prefix}_multi_widget_pages_hidden";
	$count_multi_widget = get_option($multi_widget);

    if($count_multi_widget > 1)
    {

        for ($i = 0; $i < $count_multi_widget; $i++)
        {
            $str_page = get_option("{$prefix}_multi_widget_pages_" . $i);
            $pageArr = explode("_", $str_page);
            if(!isset($pageArr[1])) continue;
            $page_id = $pageArr[1];
            if($page_id > 0) register_sidebar(array('name' => "Sidebar Page - " . get_the_title($page_id), 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
        }
    }

	// Multi Category Widget
	$multi_widget = "{$prefix}_multi_widget_categories_hidden";
	$count_multi_widget = get_option($multi_widget);

	if($count_multi_widget > 1)
	{

		for ($i = 0; $i < $count_multi_widget; $i++)
		{
			$str_cat = get_option("{$prefix}_multi_widget_categories_" . $i);
			$catArr = explode("_", $str_cat);
			if(!isset($catArr[1])) continue;
			$cat_id = $catArr[1];
			if($cat_id > 0) register_sidebar(array('name' => "Sidebar Category - " . get_cat_name($cat_id),'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
		}
	}

	// Multi Post Widget
	$multi_widget = "{$prefix}_multi_widget_posts_hidden";
	$count_multi_widget = get_option($multi_widget);

	if($count_multi_widget > 1)
	{

		for ($i = 0; $i < $count_multi_widget; $i++)
		{
			$str_post = get_option("{$prefix}_multi_widget_posts_" . $i);
			$postArr = explode("_", $str_post);
			if(!isset($postArr[1])) continue;
			$post_id = $postArr[1];
			if($post_id > 0) register_sidebar(array('name' => "Sidebar Post - " . get_the_title($post_id), 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
		}
	}


	register_sidebar(array('name' => 'Testimonials', 'id' => 'testimonials', 'before_widget' => '<div id="testimonials" class="quoteBox-big">', 'after_widget' => '</div>', 'before_title' => '<div class="quote-title"><strong>', 'after_title' => '</strong></div>'));

    $pageIDArr = tfuse_sidebar_add();

    if( count($pageIDArr) > 0 ) {
        for ($i = 0; $i < count($pageIDArr); $i++)
        {
            $page_id = $pageIDArr[$i];
            if($page_id > 0) register_sidebar(array('name' => "Sidebar Page Top - " . get_the_title($page_id),'id' => 'page-top-'.$page_id, 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
        }
    }

    $catIDArr = tfuse_sidebar_add('cat');
   

    if( count($catIDArr) > 0 ) {
        for ($i = 0; $i < count($catIDArr); $i++)
        {
            $cat_id = $catIDArr[$i];
            if($cat_id > 0) register_sidebar(array('name' => "Sidebar Category Top - " . get_cat_name($cat_id), 'id' => 'page-top-'.$cat_id, 'before_widget' => '<div id="%1$s" class="box box-white %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
        }
    }

	register_sidebar(array('name' => 'Right Footer', 'id' => 'footer-2', 'before_widget' => '<div id="%1$s" class="box %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>'));
}

add_action('init', 'the_widgets_init');

?>