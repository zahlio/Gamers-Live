<?php

// =============================== Tabs widget ======================================

class TFuse_tabs extends WP_Widget {

	function TFuse_tabs() {
		$widget_ops = array('description' => '' );
		parent::WP_Widget(false, __('TFuse - Tabs', 'tfuse'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$number = esc_attr($instance['number']);
		if ($number>0) {} else $number = 4;
		$tfuse_posts_rec = tfuse_post_tab('recent', $number, 54, 54,'thumbnail','M j, Y', false);
		$tfuse_posts_pop = tfuse_post_tab('popular', $number, 54, 54,'thumbnail','M j, Y', false);
        ?>

        <div class="tabs_framed tf_sidebar_tabs">
			<ul class="tabs">
				<li><a href="#tf_tabs_1"><?php _e('Recent','tfuse'); ?></a></li>
				<li><a href="#tf_tabs_2"><?php _e('Popular','tfuse'); ?></a></li>
			</ul>
            <div id="tf_tabs_1" class="tabcontent">
                <ul class="post_list recent_posts">
                    <?php foreach($tfuse_posts_rec as $val) : ?>
                    <?php echo '<li><a href="'.$val['link'].'">'.$val['image'].'</a><a href="'.$val['link'].'">'.$val['title'].' </a><div class="date">'.$val['date'].'</div> </li>'; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="tf_tabs_2" class="tabcontent">
                <ul class="post_list popular_posts">
                    <?php foreach($tfuse_posts_pop as $val) : ?>
                    <?php echo '<li><a href="'.$val['link'].'">'.$val['image'].'</a><a href="'.$val['link'].'">'.$val['title'].' </a><div class="date">'.$val['date'].'</div> </li>'; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
		</div>
				
	   <?php			
   }
   
	function TF_Widget_Recent_Comments() {
		$widget_ops = array('classname' => 'widget_recent_comments', 'description' => __( 'The most recent comments' ) );
		$this->WP_Widget('recent-comments', __('TFuse Recent Comments'), $widget_ops);
		$this->alt_option_name = 'widget_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array(&$this, 'recent_comments_style') );

		add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

   
	function recent_comments_style() { ?>
	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
	<?php
	}

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_comments', 'widget');
	}

   function form($instance) {        
		$instance = wp_parse_args( (array) $instance, array(  'number' => '') );
		$number = esc_attr($instance['number']);
 		?>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts','tfuse'); ?>:</label>
            <input type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" />
        </p>
		<?php
	}
} 
register_widget('TFuse_tabs');
 
?>