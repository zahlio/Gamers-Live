<?php
/*
 Plugin Name: ThemeFuse Subscribers
 Plugin URI: http://themefuse.com
 Description: ThemeFuse Subscribers
 Version: 1.0.0
*/
    $baseSubscribersDir = WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__), "" ,plugin_basename(__FILE__));
    $baseSubscribersURL = WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__), "" ,plugin_basename(__FILE__));
    define( 'THEMEFUSE_SUBSCRIBERS_DIR',  $baseSubscribersDir);
    define( 'THEMEFUSE_SUBSCRIBERS_URL',  $baseSubscribersURL);


class ThemeFuse_Subscribers extends WP_Widget {

		var $defaults = array('title' => 'Follow us',
                              'facebook'=> '',
							  'twitter' => '',
							  //'stumbleupon' => '',
							  'in' => '',
							  'rss' => '',
							  'vimeo' => '',
							  'youtube' => '',
                              'show_counter' => false,
                              'show_total_counter' => true,
                              'style' => 'v1',
                              );

	function ThemeFuse_Subscribers() {

		$widget_ops = array('description' => 'ThemeFuse Subscribers' );
		parent::WP_Widget(false, __('ThemeFuse - Subscribers', 'themefuse'),$widget_ops);

        add_action( 'wp_print_scripts', array($this, 'themefuse_subscribers_scripts') );
        add_action( 'wp_print_styles', array($this, 'themefuse_subscribers_styles') );
	}

    function themefuse_subscribers_scripts()
    {
        wp_enqueue_script('jquery');
    }
    function themefuse_subscribers_styles()
    {
        wp_register_style('themefuse_subscribers_style', THEMEFUSE_SUBSCRIBERS_URL  . 'css/themefuse_subscribers.css');
        wp_enqueue_style( 'themefuse_subscribers_style');
    }

    private  function getYTid($youtubeUrl)
    {
        $link = parse_url($youtubeUrl);
        parse_str($link['query'], $qs);
        if (isset ($qs['v']) && $qs['v'] != '') $youtubeId = $qs['v']; else  $youtubeId = '';
        return $youtubeId;
    }

    private function vimeoIdExtract ($vimeURL)
    {
        $pos = strpos($vimeURL, 'vimeo.com/');
        if ($pos !== false)
            return substr($vimeURL, $pos+10);
        else
            return '';
    }

	function widget($args, $instance) {

		$title  = esc_attr($instance['title']);
		$facebook  = esc_attr($instance['facebook']);
		$twitter  = esc_attr($instance['twitter']);
		//$stumbleupon  = esc_attr($instance['stumbleupon']);
		$in  = esc_attr($instance['in']);
		$rss  = esc_attr($instance['rss']);
		$style  = esc_attr($instance['style']);

		$vimeo_url  = esc_attr($instance['vimeo']);
        if ($vimeo_url) $vimeo = $this->vimeoIdExtract($vimeo_url); else $vimeo = '';

        $youtube_url = esc_attr($instance['youtube']);
        if ($youtube_url) $youtube = $this->getYTid($youtube_url); else $youtube = '';

        echo '<script type="text/javascript">
              jQuery.noConflict();
              jQuery.ajax({
                      type: "GET",
                      data: "title=' . $title . '&facebook=' . $facebook . '&twitter=' . $twitter . '&in=' . $in .'&vimeo=' . $vimeo .'&youtube=' . $youtube . '&rss=' . $rss  . '&style=' . $style .'",
                      url: "' . THEMEFUSE_SUBSCRIBERS_URL . 'request.php",
                      success: function(response){
                        jQuery(\'#themefuse_subscribers_widget_div\').hide().html(response).fadeIn(500);
                        //alert(response);
                      }
                    });
        </script>';
        
        echo '<div id="themefuse_subscribers_widget_div"></div>';
        }
    
     /*
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = isset( $new_instance['title'] )? strip_tags( $new_instance['title'] ) :  $this->defaults[ 'title' ];
		$instance['facebook'] = isset( $new_instance['facebook'] )? strip_tags( $new_instance['facebook'] ) :  $this->defaults[ 'facebook' ];
		$instance['twitter'] = isset( $new_instance['twitter'] )? strip_tags( $new_instance['twitter'] ) :  $this->defaults[ 'twitter' ];
		//$instance['stumbleupon'] = isset( $new_instance['stumbleupon'] )? strip_tags( $new_instance['stumbleupon'] ) :  $this->defaults[ 'stumbleupon' ];
		$instance['in'] = isset( $new_instance['in'] )? strip_tags( $new_instance['in'] ) :  $this->defaults[ 'in' ];
		$instance['rss'] = isset( $new_instance['rss'] )? strip_tags( $new_instance['rss'] ) :  $this->defaults[ 'rss' ];
		$instance['vimeo'] = isset( $new_instance['vimeo'] )? strip_tags( $new_instance['vimeo'] ) :  $this->defaults[ 'vimeo' ];
		$instance['youtube'] = isset( $new_instance['youtube'] )? strip_tags( $new_instance['youtube'] ) :  $this->defaults[ 'youtube' ];
		$instance['style'] = isset($new_instance['style']['select_value']) ? $new_instance['style']['select_value'] : $this->defaults[ 'style' ];

		return $instance;
		}

    function form( $instance  ) {

			$instance = wp_parse_args( $instance, $this->defaults );
			extract( $instance, EXTR_SKIP );

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'FaceBook ID(page):')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter ID:')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
			</p>

             <p>
				<label for="<?php echo $this->get_field_id( 'in' ); ?>"><?php _e( 'Your site URL (for Linke IN) :')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'in' ); ?>" name="<?php echo $this->get_field_name( 'in' ); ?>" type="text" value="<?php echo esc_attr( $in ); ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e( 'RSS ID:')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" type="text" value="<?php echo esc_attr( $rss ); ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e( 'Vimeo URL:')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" type="text" value="<?php echo esc_attr( $vimeo ); ?>" />
			</p>

            <p>
				<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Youtube URL:')?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>" />
			</p>


			<p>
			    <label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e('Style:', 'style'); ?></label>
                <select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>[select_value]">
                    <option value="v1" <?php if ($instance['style'] == 'v1') echo 'selected'; ?>>For Sportage</option>
                </select>
			</p>
    <?php

	}
}
add_action('widgets_init', create_function('', 'return register_widget("ThemeFuse_Subscribers");'));


?>
