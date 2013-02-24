<?php
/*---------------------------------------------------------------------------------*/
/* Twitter widget */
/*---------------------------------------------------------------------------------*/
class Tfuse_Twitter extends WP_Widget {

   function Tfuse_Twitter() {
	   $widget_ops = array('description' => 'Add your Twitter feed to your sidebar with this widget.' );
       parent::WP_Widget(false, __('Tfuse - Twitter Stream', 'tfuse'),$widget_ops);
   }
   
   function widget($args, $instance) {  
    extract( $args );
    (isset($instance['title'])) ? $title = $instance['title'] : $title = '';
    (isset($instance['limit'])) ? $limit = $instance['limit'] : $limit = '';
	(isset($instance['username'])) ? $username = $instance['username'] : $username = '';

	$unique_id = $args['widget_id'];
    $before_widget = '<div class="clear"></div><div class="widget-container widget_twitter">';
    $after_widget = '</div>';
    $before_title = '<h3>';
    $after_title = '</h3>';
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) echo $before_title . $title . $after_title; ?>
        <div class="back" id="twitter_update_list_<?php echo $unique_id; ?>"></div>
        <?php $tweet_image = true;
         echo tfuse_twitter_script($unique_id,$username,$limit, $tweet_image); //Javascript output function ?>
        <?php echo $after_widget; ?>
        
   		
	<?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       (isset($instance['title'])) ? $title = esc_attr($instance['title']) : $title = '';
       (isset($instance['username'])) ? $username = esc_attr($instance['username']) : $username = '';
       (isset($instance['limit'])) ? $limit = esc_attr($instance['limit']) : $limit = '';
       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','tfuse'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:','tfuse'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('username'); ?>"  value="<?php echo $username; ?>" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" />
       </p>
       <p>
	   	   <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:','tfuse'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('limit'); ?>"  value="<?php echo $limit; ?>" class="" size="3" id="<?php echo $this->get_field_id('limit'); ?>" />

       </p>
      <?php
   }
   
} 
register_widget('Tfuse_Twitter');
?>