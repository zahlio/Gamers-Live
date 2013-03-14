<?php
class testimonials_manager_widget extends WP_Widget {

  function testimonials_manager_widget()
        {
            $widget_ops = array('classname' => 'ww1231', 'description' => __("Display and rotate your testimonials"));
            $this->WP_Widget(false, __('TFuse - Testimonials'), $widget_ops);

            $this->tfuse_testimonial_details();
        }
        function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);

            $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

            $data = $instance;

            $instanc = get_option('testimonials_manager');

            $uniq = rand(1, 100);
            $data['display'] = 1;


            if ($data['display'] && $data['display'] < count($instanc['data'])) {
                $testimonialboxValue = $data['display'];
            } else {
                $testimonialboxValue = count($instanc['data']);
            }

           $tfuse_test_style = (count($instanc['data']) == 1 )? ' style="display: block"' : '';
           $test_title = (!empty($title)) ? '<h3>' .$title . '</h3>' : '';
           $before_widget ='<div class="widget-container testimonial_widget">

                                <div id="testimonials'.$uniq.'" class="slideshow slideQuotes">
                                    '.$test_title.'
                                    <div class="slides_container" '.$tfuse_test_style.'>';
         if ( count($instanc['data'])  > 1 )
             $after_widget =     '<a href="#" class="prev"></a>
                                  <span href="#" class="link-more">'.__('VIEW MORE TESTIMONIALS', 'tfuse').'</span>
                                  <a href="#" class="next"></a>';
            else $after_widget='';




            if ($testimonialboxValue == 0)
            {
                echo 'There are no testimonial yet';
            } else {
                echo $before_widget;

					foreach ( $instanc as $items)
                    {

                        foreach ( $items as $item)
                        {
								$url = $item['url'];
								if (substr($url, 0, 7) != 'http://') {
									$url = 'http://' . $url;
								}
								echo "<div class='slide'>
								        <div class='quote-text'>";
								$text = stripslashes($item['text']);

								if ($item['avatar'])
                                {
									if ($item['avatar'] == "gravatar")
                                    {
										echo get_avatar($item['email'], $size = '48');
									} else {
										echo '<img src="' . $item['own_avatar'] . '" class="avatar" alt="avatar" width="48" height="48" />';
									}
								}
								echo nl2br($text);
								echo "</div><!--/ .quote-text -->";
								echo '<div class="quote-author"><span>' . stripslashes($item['name']) .'</span>';
								if ($item['url'] && $item['company']) echo ' <a href="' . stripslashes($url) . '">';

								if ($item['company']) echo ', '.stripslashes($item['company']);

								if ($item['url'] && $item['company']) echo '</a>';

								echo '</div><!--/ .quote-author -->
								</div><!--/ .slide -->';

                        }
					}
                echo '</div><!--/ .slides_container -->
                        ' . $after_widget .'
                        <div class="clear"></div>
                </div><!--/ .slideshow slideQuotes -->
            </div><!--/ .testimonial_widget -->';
                if ( count($instanc['data']) > 1)
                {
                    echo '<script language="javascript" type="text/javascript" charset="utf-8">
                                    (function($) {
                                        $(\'#testimonials'.$uniq.'\').slides({
                                            hoverPause: true,
                                            autoHeight: true,
                                            pagination: false,
                                            generatePagination: false,
                                            effect: \'fade\',
                                            fadeSpeed: 150});
                                    })(jQuery);
                    </script>';
                }

            }

        } // End function widget.
        // Updates the settings.
        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
		    $instance['title'] = $new_instance['title'];
            return $instance;
        } // End function update
        // The admin form.
        function form($instance)
        {
            if (empty($instance['display'])) {
                $instance['display'] = "2";
            }


            if (empty($instance['title'])) {
                $instance['title'] = "";
            }
            $title = $instance['title'];
            ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <!---
        <p><label>Full testimonials page:<br />
			<select name="<?php echo $this->get_field_name("page_link") ?>" style="width:100%">
				<?php
            add_filter('posts_where', 'filter_testimonial');
            query_posts($query_string);
            // query_posts("post_content LIKE '%[show_testimonial]%'&post_status=publish&post_type=page");
            if (have_posts()) : while (have_posts()) : the_post();

            ?>
					<option value="<?php the_permalink(); ?>" <?php if ($data['page_link'] == "") {
                if (get_permalink($instance['page_id']) == get_permalink()) {
                    echo "selected";
                }
            } else {
                if ($data['page_link'] == get_permalink()) {
                    echo "selected";
                }
            }

            ?>><?php the_title(); ?></option>
				<?php
            endwhile;
            else:
                ?>
						<option value="no_page">No page with testimonial short code</option>
				<?php
                endif;
            // Reset Query
            wp_reset_query();

            ?>
			</select></label></p>-->	<?php
        } // end function form


        function tfuse_testimonial_details($k = 0) {
	        $option = get_option('testimonials_manager');
			if(!isset($option['data'][$k])) return;
	        $this->testimonials_count = count($option['data']);
	        $this->testimonials_details = $option['data'];
	        $this->testimonials_title = $option['data'][$k]['name'];
	        //$this->testimonials_subtitle = $option['data'][$k]['subtitle'];
	        //$this->testimonials_icon = $option['data'][$k]['icon'];
	        $this->testimonials_company = $option['data'][$k]['company'];
	        $this->testimonials_url = $option['data'][$k]['url'];
	        $this->testimonials_text = $option['data'][$k]['text'];
        }
    } // end class

    // Register the widget.
    register_widget("testimonials_manager_widget");
?>