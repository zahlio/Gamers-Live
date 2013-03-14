<?php
// =============================== Recent Posts Widget ======================================

class TFuse_Recent_Posts extends WP_Widget {

    function TF_Widget_Recent_Posts() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
        $this->WP_Widget('recent-posts', __('TFuse Recent Posts'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }
    function TFuse_Recent_Posts() {
        $widget_ops = array('description' => '' );
        parent::WP_Widget(false, __('TFuse - Recent Posts', 'tfuse'),$widget_ops);
    }


	function widget($args, $instance) {  
		extract( $args );
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
        $number = esc_attr($instance['number']);

			
        $number = ($number<0) ? 5: $number;
        $tfuse_post_param = tfuse_post_tab('recent',$number);
        $output = '';
        $template = empty( $instance['template'] ) ? '' : $instance['template'];

          $output .='<div class="widget-container widget_recent_entries '.$template.'">';
          $output .=($title!='') ?'<h3 class="widget-title">'. $title .'</h3>' : '';
            $output .='<ul>';
            $count = 0;
            foreach($tfuse_post_param as $val):
             $output .=' <li><a href="'.$val['link'].'" class="post-title">'.$val['title'].'</a></li>';
             $count++;
            if ($count==$number)break;
             endforeach;


        $output .=' </ul>
		    </div>';

	    echo $output;
   }

   function update($new_instance, $old_instance) {                
      $this->flush_widget_cache();
       return $new_instance;
   }

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

   function form($instance) {        
		$instance = wp_parse_args( (array) $instance, array(  'title' => '', 'number' => '', 'template'=>'') );
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = esc_attr($instance['number']);
 		?>

       <p>
           <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e( 'Widget Template:' ); ?></label>
           <select name="<?php echo $this->get_field_name('template'); ?>" id="<?php echo $this->get_field_id('template'); ?>" class="widefat">
               <option value="widget_box_white" <?php selected($instance['template'], 'widget_box_white' ); ?>><?php _e('White Widget Backround'); ?></option>
               <option value="no_background" <?php selected( $instance['template'], 'no_background' ); ?>><?php _e('Transparent Widget Background'); ?></option>
           </select>
       </p>


       <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
       <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts','tfuse'); ?>:</label>
            <input type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number; ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" />
        </p>

		<?php
	}
} 
function TFuse_Unregister_WP_Widget_Recent_Posts() {
	unregister_widget('WP_Widget_Recent_Posts');
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Recent_Posts');

register_widget('TFuse_Recent_Posts');

 
?>