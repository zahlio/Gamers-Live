<?php

function tfuse_get_embed($width, $height, $key, $class = 'video', $id = null) {

	if(empty($id))
	{
		global $post;
		$id = $post->ID;
	} 

	$link = get_post_meta($id, $key, true);
	if(empty($link)) $link = $key;
	
	if ( $link!='' ) {
	
		//$link = "http://www.youtube.com/watch?v=6_KpAf2X5yo&feature=fvhl";
		//$link = "http://www.youtube.com/v/CjBxInEbJjE&hl=en_US&fs=1&";
		//$link = "http://vimeo.com/10142149";
		//$link = "http://rillakhaled.com/V1.swf";
		//$link = "#inline-1";
		//$link = "http://www.adobe.com/products/flashplayer/include/marquee/design.swf&?width=792&amp;height=294";
		//$link = "http://vimeo.com/moogaloop.swf?width=580&height=326&flashvars=clip_id=4321799&server=vimeo.com&show_title=1&show_byline=1&show_portrait=0&color=&fullscreen=1";
		
	
		
		$resurce_type = $output = "";
	
		if ( preg_match('/youtube\.com\/watch/i',$link) ) 
		{
			$resurce_type = "youtube";
		}
		else if ( preg_match('/vimeo\.com/i',$link) ) 
		{
			$resurce_type = "vimeo";
		}
		else if ( strpos($link, ".mov") !== false ) 
		{
			$resurce_type = "quicktime";
		}
		else if ( strpos($link, ".swf") !== false ) 
		{
			$resurce_type = "flash";
		}
		else if ( strpos($link, "iframe") !== false ) 
		{
			$resurce_type = "iframe";
		}
		else if ( substr($link,0,1) == "#" ) 
		{
			$resurce_type = "inline";
		}
		else
		{
			$resurce_type = "image";
		} 
		
	
		$flash_markup 		= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{width}" height="{height}"><param name="wmode" value="opaque" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="{path}" /><embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{width}" height="{height}" wmode="opaque"></embed></object>';
		$quicktime_markup	= '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="{height}" width="{width}"><param name="src" value="{path}"><param name="autoplay" value="false"><param name="type" value="video/quicktime"><embed src="{path}" height="{height}" width="{width}" autoplay="false" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/"></embed></object>';
		$iframe_markup 		= '<iframe src ="{path}" width="{width}" height="{height}" frameborder="no"></iframe>';
		$inline_markup 		= '<div class="pp_inline clearfix">{content}</div>';
		
		
		switch ($resurce_type) 
		{
			case 'youtube':
		
				if(preg_match('/youtube\.com\/(v\/|watch\?v=)([\w\-]+)/', $link, $match)) {; 
					$youtube_id = $match[2]; 
				}
				
				$movie 		= 'http://www.youtube.com/v/'.$youtube_id;
				
				$search		= array("{width}", "{height}", "{path}");
				$replace	= array($width, $height, $movie);
				
				$output 	= str_replace($search, $replace, $flash_markup);
				
			break;
			
			case 'vimeo':
			
				$movie = 'http://vimeo.com/moogaloop.swf?clip_id=' . str_replace('http://vimeo.com/','',$link);
				
				$search		= array("{width}", "{height}", "{path}");
				$replace	= array($width, $height, $movie);
				
				$output 	= str_replace($search, $replace, $flash_markup);
	
			break;
			
			case 'quicktime':
				
				$height += 15;
				
				$search		= array("{width}", "{height}", "{path}");
				$replace	= array($width, $height, $link);
				
				$output 	= str_replace($search, $replace, $quicktime_markup);
				
			break;
			
			case 'flash':
			
				$flash_vars = substr($link,strpos($link, "flashvars") + 10,strlen($link));
	
				$filename = substr($link,0,strpos($link, "?"));
				
				$search		= array("{width}", "{height}", "{path}");
				$replace	= array($width, $height, "$filename?$flash_vars");
				
				$output 	= str_replace($search, $replace, $flash_markup);
	
			break;
			
			case 'iframe':
		
				$frame_url = substr($link,0,strpos($link, "iframe")-1);
				
				$search		= array("{width}", "{height}", "{path}");
				$replace	= array($width, $height, $frame_url);
				
				$output 	= str_replace($search, $replace, $iframe_markup);
	
			break;	
		}	
		return $output;
	}	
}

?>