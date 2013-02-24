<?php function tfuse_twitter($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 5,
		'username' => '',
		'title' => '',
		'post_date' => '',
	), $atts));

	$return_html = '';

	if(!empty($username))
	{
		require_once (THEME_FUNCTIONS.'/twitter.php');

		$obj_twitter = new Twitter($username);
		$tweets = $obj_twitter->get($items);

		$return_html.= '<div class="twitter">';
		
		if ($title != '' ) $return_html.= '<h2>'.$title.'</h2><ul> ';

		$k = 0;

		foreach($tweets as $tweet)
		{

		    $return_html.= '<li>';

		    if(isset($tweet[0]))
		    {
		    	$return_html.= '<p>'.$tweets[$k][2].'</p>';
				$k++;
		    }
		    if ($post_date !='')
			{
			$return_html.='<div class="date">' . $tweet[1] . '</div>';
			}

		    $return_html.= '</li>';
		}

		$return_html.= '</ul></div>';
	}
	
	return apply_filters('tfuse_twitter', $return_html);
}
add_shortcode('twitter', 'tfuse_twitter');
?>