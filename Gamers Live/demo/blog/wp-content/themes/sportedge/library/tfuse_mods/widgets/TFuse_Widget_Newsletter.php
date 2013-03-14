<?php

// =============================== Newsletetr widget ======================================

class TFuse_newsletter extends WP_Widget {

	function TFuse_newsletter() {
		$widget_ops = array('description' => '' );
		parent::WP_Widget(false, __('TFuse - Newsletter', 'tfuse'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$newsletter_title = empty( $instance['newsletter_title'] ) ? 'Newsletter' : esc_attr($instance['newsletter_title']);
		$rss = empty( $instance['rss'] ) ? '' : esc_attr($instance['rss']);
		?>

		<div class="widget-container newsletterBox">
			<div class="inner">
                <?php if ($newsletter_title!='') { ?><h3 class="widget-title"><?php echo $newsletter_title; ?></h3><?php } ?>
				<?php if ( !isset($_POST['newsletter'])  ) { ?>
				
                <form action="#" method="post" id="subscribe">
						<input type="text" value="<?php _e('ENTER YOUR EMAIL ADDRESS','tfuse'); ?>" onfocus="if (this.value == '<?php _e('ENTER YOUR EMAIL ADDRESS','tfuse'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('ENTER YOUR EMAIL ADDRESS','tfuse'); ?>';}"  name="newsletter" class="inputField" />
						<input type="submit" value="Send" class="btn-arrow" />
					    <div class="clear"></div>
                    </form>
					<?php if ( $rss!='') { ?><div class="newsletter_text"><a href="<?php if ( get_option(PREFIX.'_feedburner_url') <> "" ) { echo get_option(PREFIX.'_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="link-news-rss"><?php _e('You can also','tfuse'); ?> <span><?php _e('Subscribe to our RSS','tfuse'); ?></span> <?php _e('feed','tfuse'); ?></a></div><?php } ?>
					
				<?php } else { ?>
					
					<div class="before-text"><?php _e('Thank you for your subscription.','tfuse'); ?></div>
				<?php } ?>
			</div>
		</div>
	<?php 
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
		$instance = wp_parse_args( (array) $instance, array(  'newsletter_title' => '', 'rss' => '') );
		$newsletter_title = esc_attr($instance['newsletter_title']);
		$rss = esc_attr($instance['rss']);
 		?>
        <p>
            <label for="<?php echo $this->get_field_id('newsletter_title'); ?>"><?php _e('Title:','tfuse'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('newsletter_title'); ?>" value="<?php echo $newsletter_title; ?>" class="widefat" id="<?php echo $this->get_field_id('newsletter_title'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('Activate RSS','tfuse'); ?>:</label>
			<?php if ( isset($rss['rss']) ) $checked = ' checked="checked" '; else $checked = ''; ?>
            <input  <?php echo $checked; ?>  type="checkbox" name="<?php echo $this->get_field_name('rss'); ?>" class="checkbox" id="<?php echo $this->get_field_id('rss'); ?>" />
        </p>
		<?php
	}
} 
register_widget('TFuse_newsletter');
 
?>