<?php
class TF_Widget_Social extends WP_Widget
{

	function TF_Widget_Social()
    {
		$widget_ops = array('classname' => 'widget_social', 'description' => __( 'Add Social Networks in Sidebar ') );
		$this->WP_Widget('social', __('TFuse Social Widgets'), $widget_ops);
	}

	function widget( $args, $instance )
    {
		extract($args);


        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		$before_widget = ' <div class="post-share">';
		$after_widget = '</div>';

		echo $before_widget;

            if ( $instance['skype'] != '')
            {?>
                 <a href="<?php echo $instance['skype']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/social_skype.png" width="79" height="25" alt="" /></a>

            <?php }

            if ( $instance['twitter'] != '')
            {?>
                <a href="<?php echo $instance['twitter']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/share_twitter.png" width="79" height="25" alt="" /></a>
            <?php }

            if ( $instance['dribbble'] != '')
            {?>
                <a href="<?php echo $instance['dribbble']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/dribbble.png" width="79" height="25" alt="" /></a>
            <?php }

            if ( $instance['linkedin'] != '')
            {?>
                   <a href="<?php echo $instance['linkedin']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/linkedin.png" width="79" height="25" alt="" /></a>
            <?php }

            if ( $instance['facebook'] != '')
            {?>
                    <a href="<?php echo $instance['facebook']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/share_facebook.png" width="88" height="25" alt="" /></a>
            <?php }

            if ( $instance['flickr'] != '')
            {?>
                <a href="<?php echo $instance['flickr']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/flickr.png" width="79" height="25" alt="" /></a>
            <?php }

            if ( $instance['deviantart'] != '')
            {?>
                <a href="<?php echo $instance['deviantart']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/deviant.png" width="79" height="25" alt="" /></a>
            <?php }

            if ( $instance['rss'] != '')
            {?>
                <a href="<?php echo $instance['rss']; ?>" class="btn-share"><img src="<?php echo get_template_directory_uri() ?>/images/rss.png" width="79" height="25" alt="" /></a>
            <?php }

		echo $after_widget;
	}

	function update( $new_instance, $old_instance )
    {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'linkedin' => '','linkedin_id' => '','skype' => '','rss' => '','rss_id' => '', 'facebook' => '','facebook_id' => '', 'twitter' => '', 'twitter_id' => '','dribbble' => '','dribbble_id' => '', 'flickr' => '','flickr_id' => '', 'deviantart' => '','deviantart_id' => '', 'title' =>'') );

        $instance['facebook']   = $new_instance['facebook'] ? $new_instance['facebook'] : '';
        $instance['twitter']    = $new_instance['twitter'] ? $new_instance['twitter'] : '';
        $instance['dribbble']   = $new_instance['dribbble'] ? $new_instance['dribbble'] : '';
        $instance['flickr']     = $new_instance['flickr'] ? $new_instance['flickr'] : '';
        $instance['deviantart'] = $new_instance['deviantart'] ? $new_instance['deviantart'] : '';
        $instance['rss']        = $new_instance['rss'] ? $new_instance['rss'] : '';
        $instance['skype']        = $new_instance['skype'] ? $new_instance['skype'] : '';
        $instance['linkedin']        = $new_instance['linkedin'] ? $new_instance['linkedin'] : '';

		return $instance;
	}

	function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 'title'=>'', 'skype' => '','linkedin' => '','linkedin_id' => '','rss' => '','rss_id' => '', 'facebook' => '','facebook_id' => '', 'twitter' => '','twitter_id' => '','dribbble' => '','dribbble_id' => '', 'flickr' => '','flickr_id' => '', 'deviantart' => '','deviantart_id' => '') );
        $title = $instance['title'];
?>
    <style type="text/css">
        .widget_social_name, .widget_social_link {
            width:185px;
        }
        .widget_social_link{
            margin-left: 11px;
        }
        .tfuse_wd_skype{
            width:161px!important;
        }
    </style>

    <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:'); ?></label><br/>
        <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($instance['facebook']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:'); ?></label><br/>
        <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo  esc_attr($instance['twitter']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e('Dribble:'); ?></label><br/>
        <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" type="text" value="<?php echo esc_attr($instance['dribbble']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr:'); ?></label><br/>
       <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo esc_attr($instance['flickr']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php _e('Deviantart:'); ?></label><br/>
        <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('deviantart'); ?>" name="<?php echo $this->get_field_name('deviantart'); ?>" type="text" value="<?php echo esc_attr($instance['deviantart']); ?>"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('Rss:'); ?></label><br/>
        <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo esc_attr($instance['rss']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('Linkedin:'); ?></label><br/>
        <span><?php _e('Link:'); ?></span> <input class="widefat widget_social_link" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($instance['linkedin']); ?>"  />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e('Skype: ID'); ?></label>
        <input class="widefat widget_social_link tfuse_wd_skype" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo esc_attr($instance['skype']); ?>"  />
    </p>

    <?php
	}
}

function TFuse_Unregister_WP_Widget_Social() {
	unregister_widget('WP_Widget_Social');
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Social');

register_widget('TF_Widget_Social');
?>