<?php
//************************************* Minigallery
function tfuse_minigallery($attr, $content = null)
{
	global $post;
	if ( isset( $attr['orderby'] ) )
    {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );

        if ( !$attr['orderby'] ) unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array('order' => 'ASC', 'orderby' => 'menu_order ID','id' => $post->ID,
                                'include' => '', 'exclude' => '','pretty' => '', 'icon_plus'  => '',
                                'class'      => 'boxed'), $attr));

	if ( !empty($include) )
    {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val )
        {
			$attachments[$val->ID] = $_attachments[$key];
		}
	}
    elseif ( !empty($exclude) )
    {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}
    else
    {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) ) return '';
	

	$tfuse_shortcode_arr = array();
    $tfuse_shortcode_arr['script'] = '';
    $tfuse_shortcode_arr['pretty'] = $pretty;
    $tfuse_shortcode_arr['class'] = $class;
	$tfuse_shortcode_arr['uniq'] = '';

    $tfuse_shortcode_arr['icon_plus'] = $icon_plus;

    $tfuse_shortcode_arr['images'] = '';
     $tfuse_shortcode_arr['attachments'] = $attachments;

    $tfuse_shortcode_arr['uniq'] = rand();
    if ($pretty =='') $tfuse_jQ_auto = ',auto: 3'; else $tfuse_jQ_auto='';

	    $tfuse_shortcode_arr['script'] =
            "<script type=\"text/javascript\">
							 jQuery(document).ready(function($) {
                            $('.mycarouse" .$tfuse_shortcode_arr['uniq']. "').jcarousel({
									easing: 'easeInOutQuint',
                                animation: 600".$tfuse_jQ_auto."
								});
							});
                        </script>";


    return tfuse_minigallery_html($tfuse_shortcode_arr);
}
add_shortcode('minigallery', 'tfuse_minigallery');

function tfuse_minigallery_html($tfuse_shortcode_arr)
{
   $out =  $tfuse_shortcode_arr['script'];

   $out .= '[raw]<div class="minigallery-list minigallery ' . $tfuse_shortcode_arr['class'] . '">
			    <ul id="mycarouse'. $tfuse_shortcode_arr['uniq'].'" class="jcarousel-skin-tango mycarouse'. $tfuse_shortcode_arr['uniq'].'">';

   foreach ( $tfuse_shortcode_arr['attachments'] as $id => $attachment ) :


			$link = wp_get_attachment_image_src($id,'full',true);
			$image_link_attach = $link[0];
			$imgsrc = wp_get_attachment_image_src($id,array(139,90),false);
			$image_src = $imgsrc[0];

		if ( $tfuse_shortcode_arr['pretty'] )
        {
			$out .='<li><a href="'.$image_link_attach.'" rel="prettyPhoto[gallery1]">'.tfuse_get_image(90, 90, 'img',$image_src , '', true, '');

			if ( $tfuse_shortcode_arr['icon_plus'] ) $out .= '<span></span>';

			$out .=' </a></li>';
        }
		else
        {
		    $out .= '<li>'.tfuse_get_image(90, 90, 'img',$image_src , '', true, '').'</li>';
		}

  
   endforeach;
	$out .= '</ul>
		</div>
		<div class="clear"></div>
	[/raw]';

    return apply_filters('tfuse_minigallery', $out,$tfuse_shortcode_arr );
}


?>