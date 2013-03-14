<?php

// =============================== Ads 300x250 widget ======================================

class TFuse_ads300x250 extends WP_Widget {

	function TFuse_ads300x250() {
		$widget_ops = array('description' => '' );
		parent::WP_Widget(false, __('TFuse - Ads 300x250', 'tfuse'),$widget_ops);      
	}

	function widget($args, $instance) { ?>
		
		<div class="ads_300x250">
		<?php 
		if (get_option(PREFIX.'_ad_300_adsense') <> "") { echo stripslashes (html_entity_decode(get_option(PREFIX.'_ad_300_adsense'),ENT_QUOTES, 'UTF-8')); ?>
		
		<?php } else { ?>
		
			<a href="<?php echo get_option(PREFIX.'_ad_300_url'); ?>" target="_blank"><img src="<?php echo html_entity_decode(get_option(PREFIX.'_ad_300_image'),ENT_QUOTES, 'UTF-8'); ?>" alt="advert" /></a>
			
		<?php } ?>
		</div>
		<?php 		
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
		$settings = get_option("widget_adswidget");
	}
} 
register_widget('TFuse_ads300x250');
 
?>