<?php get_header();
error_reporting(0);
 ?>

	<div <?php tfuse_middle_class() ?>>
        <div class="container_12">
            
            <?php $tfuse_param = tfuse_header_parametrs();  
            if ( $tfuse_param['header_element'] == 'type2' || $tfuse_param['header_element']=='' )
            {
             $tfuse_cat_detail = tfuse_back_to_category(); ?>
            <div class="back_title">
                    <div class="back_inner">
                        <a href="<?php echo $tfuse_cat_detail['cat_link']; ?>"><span><?php _e('More News', 'tfuse'); ?></span></a>
                    </div>
                </div>
                <div class="divider_space_thin"></div>
            <?php } ?>
            <?php if (tfuse_shortcode_content('before', true)!=''): ?>
            <div class="grid_12 content">
                <?php tfuse_shortcode_content('before'); ?>
            </div><!--/ .content -->
            <?php endif; ?>



            <?php $sidebar_position = tfuse_sidebar_position();
            
            if (  $sidebar_position == 'left' ) : ?>

                    <div class="grid_4 sidebar">
                        <?php get_sidebar(); ?>
                    </div><!--/ .sidebar -->

                <?php endif; ?>



                <div <?php tfuse_class('content'); ?>>
                        <?php  if (have_posts()) : $count = 0;
                        while (have_posts()) : the_post(); $count++;
                            tfuse_clickPost(); ?>

                                <div class="post-detail">
                                    <div class="page-title">
                                        <?php if ( tfuse_action_post_meta() )
                                        { ?>
                                        <div class="meta-date">
                                            <?php echo get_the_date('M j') . ', '; tfuse_time_ago() ?>
                                        </div>
                                        <?php }

                                         the_title('<h1>', '</h1>'); ?>
                                    </div>
                                     <div class="entry">
                                         <?php 
										 if  ($sidebar_position['top']=='full') tfuse_media('post', 960, 590); else tfuse_media('post', 620, 380);
										  
										 the_content();
                                         tfuse_include(THEME_INCLUDES.'/author_description'); ?>
                                         <div class="clear"></div>
                                     </div><!--/ .entry -->

                                <?php   if ( !tfuse_page_options(PREFIX . '_post_share_button') && get_option( PREFIX . '_disable_social_share_buttons')=='false' )
                                        { ?>
                                            <div class="post-share">
                                                    <p><?php _e('Share "', 'tfuse') ?><strong><?php the_title(); ?></strong><?php _e('" via', 'tfuse') ?></p>

                                                          <?php tfuse_fb_share();
                                                                tfuse_tw_share();
                                                                tfuse_google_share();
                                                          ?>
                                                    <div class="clear"></div>

                                            </div>
                                                

                                      <?php  } ?>
                               <div class="clear"></div>
                                 <?php  tfuse_comments();

                                  endwhile; else:

                                 _e('Sorry, no posts matched your criteria.', 'tfuse') ?>

                                <?php endif; ?>

                         </div><!--/ .post-detail -->

                    </div><!--/ .content -->

            <?php if ( $sidebar_position == 'right') : ?>
                <div class="grid_4 sidebar">

                    <?php get_sidebar(); ?>

                </div><!--/ .sidebar -->
            <?php endif; ?>

            <div class="clear"></div>
            <?php $category = get_the_category();
            if ( tfuse_page_options(PREFIX . '_post_bottom_posts') && $category[0]->category_count > 1) { ?>
                <div class="divider_space_thin"></div>
                <!-- category title more -->
                <div class="cat_title">
                    <?php  require_once(THEME_MODULES .'/searchform.php'); ?>
                    <strong class="title"><span><?php _e('More in', 'tfuse'); echo ' '. $category[0]->cat_name;?></span></strong>
                </div>
                <!--/ category title more -->

                <?php echo tfuse_latest_post_cat($category[0]->cat_name) ; ?>
                <div class="clear"></div>
            <?php } ?>
            <?php if (tfuse_shortcode_content('after', true)!=''): ?>
                <div class="grid_12 content">
                    <?php  tfuse_shortcode_content('after'); ?>
                </div><!--/ .content -->
                <div class="clear"></div>
            <?php endif; ?>

    </div><!--/ .container_12 -->
</div><!--/ .middle -->
<?php get_footer(); ?>