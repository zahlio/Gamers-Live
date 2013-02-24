<?php
//********************Slide Show
function tfuse_slideshow($atts, $content) {

	extract(shortcode_atts(array('width' => 580,	'height' => 326, 'image' => ''	), $atts));

    $content = trim($content);
	$image_arr = preg_split("/(\r?\n)/", $content);
    $uniq = rand(1, 100);

    $tfuse_shortcode_arr = array();

    $tfuse_shortcode_arr['width']  = $width;
    $tfuse_shortcode_arr['height'] = $height;
    $tfuse_shortcode_arr['uniq'] = $uniq;
    $tfuse_shortcode_arr['images'] = $image_arr;

	return tfuse_slideshow_hmtl($tfuse_shortcode_arr);
}
add_shortcode('slideshow', 'tfuse_slideshow');

function tfuse_slideshow_hmtl($tfuse_shortcode_arr)
{
	$return_html = " 
						<script language=\"javascript\" type=\"text/javascript\" charset=\"utf-8\">
							jQuery(document).ready(function($){
								$('#slides" . $tfuse_shortcode_arr['uniq'] . "').slides({
									play: 4000,
									hoverPause: true,
									autoHeight: true,
									effect: 'fade',
									fadeSpeed: 600,
									crossfade: true,
									preload: true,
									preloadImage: '". get_template_directory_uri() ."/images/loading.gif'});
							});
						</script>
					<!--/ SlideShow -->";


	$return_html .= ' <div id="slides' .  $tfuse_shortcode_arr['uniq'] . '" class="slideshow slideGallery">
                        <div class="slides_container">';

		foreach($tfuse_shortcode_arr['images'] as $image)
		{
            if ( ! empty($image))
            {
				$return_html.= '<div class="slide">';
				$return_html.= tfuse_get_image($tfuse_shortcode_arr['width'],  $tfuse_shortcode_arr['height'], 'img', $image, '', true, '');
				$return_html.= '</div>'. PHP_EOL;
            }
		}


	$return_html.= '</div>
                        </div> ';

	return apply_filters('tfuse_slideshow', $return_html, $tfuse_shortcode_arr);
}
?>