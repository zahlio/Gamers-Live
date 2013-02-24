<?php
function tfuse_isset_media()
{
    global $post;
    $post_video 	= get_post_meta($post->ID, PREFIX . "_post_video", true);
    $large_image 	= get_post_meta($post->ID, PREFIX . "_post_image", true);
    $medium_image 	= get_post_meta($post->ID, PREFIX . "_post_image_medium", true);

    if ($post_video!='' ||$large_image != '' || $medium_image!='') return true; else return false;

}
if ( !function_exists('tfuse_media')):
    function tfuse_media($param, $width='', $height='', $return=false, $tfuse_single = false, $tfuse_image_class = 'frame_box')
    {
        global $post;
        $output ='';
        $tfuse_media = array();
        $tfuse_media['post_video']  	= tfuse_page_options(PREFIX . '_post_video', true);
        $tfuse_media['main_image']    	= tfuse_page_options(PREFIX . '_post_image', true );
        $tfuse_media['single_image'] 	= tfuse_page_options(PREFIX . '_post_image_medium', true);
        $tfuse_media['disablevideo'] 	= tfuse_page_options(PREFIX . '_post_single_video', true);
        $tfuse_media['disableimage'] 	= tfuse_page_options(PREFIX . '_post_single_image', true);
        $tfuse_media['disableprety'] 	= ( $tfuse_single ) ? false : tfuse_options(PREFIX . '_disable_lightbox', true);
	
		if ( $param == 'fixed' ) 
		{
			$tfuse_media['image_width'] =  $width;
			$tfuse_media['image_height']  =  $height;
		}
		else
		{
			if ( !is_singular() )
			{ 
				// Thumbnail Image
				$tfuse_media['image_align'] = tfuse_page_options(PREFIX."_thumbnail_post_position", true);
				if ( empty($tfuse_media['image_align']) ||  $tfuse_media['image_align'] == 'default' ) 
					$tfuse_media['image_align'] = tfuse_options(PREFIX.'_thumbnail_posts_position', true);
				
				$tfuse_media['image_width'] = tfuse_page_options(PREFIX."_thumbnail_post_width", true);
				if ( empty($tfuse_media['image_width']) || !is_numeric($tfuse_media['image_width']) ) 
				{	
					$tfuse_media['image_width']  = tfuse_options(PREFIX.'_thumbnail_posts_width', true);
					if ( empty($tfuse_media['image_width']) || !is_numeric($tfuse_media['image_width']) ) 
					{
						$tfuse_media['image_width']  =  $width;
					}
				}
				
				$tfuse_media['image_height'] = tfuse_page_options(PREFIX."_thumbnail_post_height", true);
				if ( empty($tfuse_media['image_height']) || !is_numeric($tfuse_media['image_height']) ) 
				{	
					$tfuse_media['image_height']  = tfuse_options(PREFIX.'_thumbnail_posts_height', true);
					if ( empty($tfuse_media['image_height']) || !is_numeric($tfuse_media['image_height']) ) 
					{
						$tfuse_media['image_height']  =  $height;
					}
				}
			}
			else 
			{
				// Single Post Image
				$tfuse_media['image_align'] = tfuse_page_options(PREFIX."_post_image_position", true);
				if ( empty($tfuse_media['image_align']) ||  $tfuse_media['image_align'] == 'default'  )  
					$tfuse_media['image_align']  = tfuse_options(PREFIX.'_image_posts_position', true);
				
				$tfuse_media['image_width'] = tfuse_page_options(PREFIX."_post_image_width", true);
				if ( empty($tfuse_media['image_width']) || !is_numeric($tfuse_media['image_width']) ) 
				{
					$tfuse_media['image_width']  = tfuse_options(PREFIX.'_single_posts_width', true);
					if ( empty($tfuse_media['image_width']) || !is_numeric($tfuse_media['image_width']) )
					{
						$tfuse_media['image_width']  = $width;
					}
				}
					
				$tfuse_media['image_height'] = tfuse_page_options(PREFIX."_post_image_height", true);
				if ( empty($tfuse_media['image_height']) || !is_numeric($tfuse_media['image_height']) ) 
				{
					$tfuse_media['image_height']  = tfuse_options(PREFIX.'_single_posts_height', true);
					if ( empty($tfuse_media['image_height']) || !is_numeric($tfuse_media['image_height']) )
					{
						$tfuse_media['image_height']  = $height;
					}
				}
				
				// Single Post Video
				$tfuse_media['media_align'] = tfuse_page_options(PREFIX."_post_video_position", true);
				if ( empty($tfuse_media['media_align']) ||  $tfuse_media['media_align'] == 'default'  )  
					$tfuse_media['media_align']  = tfuse_options(PREFIX.'_video_posts_position', true);
				
				$tfuse_media['media_width'] = tfuse_page_options(PREFIX."_post_video_width", true);
				if ( empty($tfuse_media['media_width']) || !is_numeric($tfuse_media['media_width']) ) 
				{
					$tfuse_media['media_width']  = tfuse_options(PREFIX.'_single_posts_video_width', true);
					if ( empty($tfuse_media['media_width']) || !is_numeric($tfuse_media['media_width']) )
					{
						$tfuse_media['media_width']  = $width;
					}
				}
					
				$tfuse_media['media_height'] = tfuse_page_options(PREFIX."_post_video_height", true);
				if ( empty($tfuse_media['media_height']) || !is_numeric($tfuse_media['media_height']) ) 
				{
					$tfuse_media['media_height']  = tfuse_options(PREFIX.'_single_posts_video_height', true);
					if ( empty($tfuse_media['media_height']) || !is_numeric($tfuse_media['media_height']) )
					{
						$tfuse_media['media_height']  = $height;
					}
				}
			}
		}
				
        if ( $tfuse_media['disablevideo'] == 'false' && $tfuse_media['post_video'] != '' && is_singular() && is_single() )
        {
            $output .= 	'<div class="video_embed '.$tfuse_media['media_align'].'">';

                $output .= tfuse_get_embed($tfuse_media['media_width'], $tfuse_media['media_height'], PREFIX . "_post_video");

			$output .= '<br><br></div><!--/.video_embed  -->';
        }

        if ( $tfuse_media['disableimage'] == 'false' && $param == 'post')
        {
            if (  $tfuse_media['single_image'] != '')   $tfuse_media['image'] = $tfuse_media['single_image'];
            elseif ( $tfuse_media['main_image']  != '') $tfuse_media['image'] = $tfuse_media['main_image'];
            else $tfuse_media['image'] = '';
        }
        elseif( $tfuse_media['disableimage'] == 'false' && ($param == 'cat' || $param == 'fixed') )
        {

            if (  $tfuse_media['main_image'] != '')       $tfuse_media['image'] = $tfuse_media['main_image'];
            elseif ( $tfuse_media['single_image']  != '') $tfuse_media['image'] = $tfuse_media['single_image'];
            else $tfuse_media['image'] = '';
        }
        else $tfuse_media['image'] = '';



        if ( $tfuse_media['image'] !='' ) $tfuse_image = '<img src="' . tfuse_get_image($tfuse_media["image_width"], $tfuse_media["image_height"], 'src', $tfuse_media["image"], '', true) . '" alt="' . get_the_title() . '" class="'.$tfuse_image_class.' '.@$tfuse_media["image_align"].'" width="'.$tfuse_media["image_width"].'" height="'.$tfuse_media["image_height"].'" />';
        else $tfuse_image = '';

        if (  $tfuse_media['disableprety'] == 'false'  )
        {

            $attachments = get_children( array( 'post_parent' => $post->ID,	'numberposts' => -1, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
            $output .= '<span style="display:none">';
            if(!empty( $attachments ))
            {
                foreach ($attachments as $att_id => $attachment)
                {   $size = 'full';
                    $tfuse_src = wp_get_attachment_image_src($att_id, $size, true);
                    $tfuse_image_link_attach = $tfuse_src[0];
                    $output .= '<a href="'. $tfuse_image_link_attach.'" rel="prettyPhoto[gallery'.$post->ID.']">'.  $tfuse_media['image'].'</a>';
                }
            }

            if (  $tfuse_media['post_video'] != '' && is_singular() ) $output .= '<a href="'. $tfuse_media['post_video'].'" rel="prettyPhoto[gallery'.$post->ID.']">'. $tfuse_image.'</a>';
            $output .= '</span>';
            if (  $tfuse_media['image'] != '' && $tfuse_image!='') $output .= '<a href="'. $tfuse_media['image'].'" rel="prettyPhoto[gallery'.$post->ID.']">'. $tfuse_image.'</a>';
        }
        else  $output .= $tfuse_image ;

       if ($tfuse_image!='' || $tfuse_media['post_video'] != '' )
           if($return )return  $output; else echo $output;
       else
           if($return ) echo ''; else echo '';

    }
endif;
?>