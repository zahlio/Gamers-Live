<?php get_header();?>

	<div <?php tfuse_middle_class(); ?>>

    	    <div class="container_12" <?php echo (!is_category())? 'style="margin-top:0px;"' : ''; ?>>
                 <?php $sidebar_position = tfuse_sidebar_position(); ?>
                <?php $top_sidebar_position = tfuse_sidebar_position('top');
                $tfuse_param = tfuse_header_parametrs();?>
                <?php if ( get_query_var('paged') ) $paged = get_query_var('paged');
                elseif ( get_query_var('page') ) $paged = get_query_var('page'); else $paged = 1;

                if ( is_category() && $paged == 1 ) : ?>
                    <?php if ( tfuse_options(PREFIX . '_category_featured_tabs_','','','cat') ) { ?>

                    <div class="featured_block">

                        <?php  if (  $top_sidebar_position == 'left' ) : ?>

                            <div class="grid_4 featured_sidebar sidebar">
                                    <?php get_sidebar('top'); ?>
                            </div><!--/ .sidebar -->

                        <?php endif; ?>

                            <div class="grid_8 content">
                               <?php tfuse_featured_posts_tab(); ?>
                            </div><!--/ .content -->

                        <?php if (  $top_sidebar_position == 'right' ) : ?>

                            <div class="grid_4 featured_sidebar sidebar">
                                <?php get_sidebar('top'); ?>
                            </div><!--/ .sidebar -->

                        <?php endif; ?>
                    <div class="clear"></div>
                </div><!--/ .featured_block -->
                <?php } ?>

                <?php  elseif ( !is_archive() ) :
                    $category = get_the_category();?>
                   <div class="tfuse_divider_space_thin"></div>
                    <div class="cat_title">
                        <?php if ( tfuse_options(PREFIX . '_category_title_searchform_','','','cat') ) { ?>
                            <?php  require_once(THEME_MODULES .'/searchform.php');?>
                        <?php } ?>
                        <strong class="title">
                            <span><?php _e('More in', 'tfuse'); echo ' '. get_cat_name(get_query_var('cat'));?></span>
                        </strong>
                    </div>
                <?php endif; ?>
                <?php if (tfuse_shortcode_content('before', true)!=''): ?>
                <div class="grid_12 content">
                    <?php tfuse_shortcode_content('before'); ?>
                </div><!--/ .content -->
                <?php endif; ?>

                <?php if ( ( !is_year() && $paged > 1 && $tfuse_param['header_element'] != 'type1' && tfuse_shortcode_content('before', true) == '' ) || ( !is_year() && !tfuse_options(PREFIX . '_category_featured_tabs_','','','cat')) ) { ?>
                <div class="tfuse_divider_space_thin"></div>
                <?php } ?>
                <?php if ( $paged == 1  || is_archive() ) { ?>
                <!-- category title more -->
                <div class="cat_title">
                    <?php if ( tfuse_options(PREFIX . '_category_title_searchform_','','','cat') ) { ?>
                        <?php  require_once(THEME_MODULES .'/searchform.php');?>
                    <?php } ?>
                    <strong class="title"><span>
                        <?php echo ( is_category() ) ?  __('More in', 'tfuse'). ' '. get_cat_name(get_query_var('cat')) : '';?>
                        <?php echo ( is_year() ) ?  __('Archive', 'tfuse'). ' '. get_the_time('Y') : '';?>

                    </span></strong>
                </div>
                <!--/ category title more -->
                <?php } ?>
                <?php if (   $sidebar_position == 'left' && !is_year() ) : ?>
                  <div class="grid_4 sidebar">

                       <?php get_sidebar(); ?>

                   </div><!--/ .sidebar -->
               <?php endif;?>

                <div <?php tfuse_class('content'); ?>>
                <div class="post-list">
				
                <?php if ( $sidebar_position != 'full' && !is_year() )
                     {
                         $tfuse_num_post_row = 2;
                     }
                    else $tfuse_num_post_row = 3;
                    global $tfuse_rec_post_ID;
                    if ( tfuse_options(PREFIX . '_category_featured_tabs_','','','cat') ) {
                        $cat_ID = get_query_var('cat');
                        query_posts( array( 'cat' => $cat_ID, 'paged' => get_query_var('paged'), 'post__not_in' => array( $tfuse_rec_post_ID) ) );
                    }

                    if (have_posts()) : $count = 0; $aux_count = 0;
                    while (have_posts()) : the_post(); $count++;
                    $aux_count++;

                    if ( $aux_count <= $tfuse_num_post_row )
                    {
                        $tfuse_post_class = 'post-item post-white';
                    }

                     elseif( $aux_count > $tfuse_num_post_row && $aux_count <= 2*$tfuse_num_post_row )
                     {
                          $tfuse_post_class='post-item';
                     }
                     elseif( $aux_count > 2*$tfuse_num_post_row )
                     {
                         $aux_count = 1;  $tfuse_post_class= 'post-item post-white';
                     } ?>

                    <div class="<?php echo $tfuse_post_class; ?>">
                        <div class="meta-date"><?php echo get_the_time('M j') . ', ' . tfuse_time_ago('', true); ?></div>
                        <div class="post-descr">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="post-short">
                                 <?php if( !has_excerpt() ) tfuse_media('cat', 120,100, '', '', false, true, '');
                                global $more; $more = 0;
                                the_content(''); ?>
                            </p>
                            <div class="meta-bot"><a href="<?php the_permalink(); ?>" class="button_link"><span><?php _e('Read', 'tfuse'); ?></span></a> &nbsp;
                                <a href="<?php comments_link(); ?>" class="link-comments"><?php comments_number('0 comments', '1 comment', '% comments') ?></a>
                            </div>
                        </div>
                         <div class="clear"></div>
                    </div>

			<?php echo ($count%$tfuse_num_post_row == 0)? '<div class="clear"></div>':'';
                 endwhile;

		      else: ?>
			 
				<h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>
			
			<?php endif; ?>
            <?php if ( tfuse_options(PREFIX . '_category_featured_tabs_','','','cat') ) {
                        wp_reset_query();
                   } ?>
                    <div class="clear"></div>
            </div><!--/ .post-list -->
            </div><!--/ .content -->

            <?php if (  $sidebar_position == 'right' && !is_year()) : ?>
                <div class="grid_4 sidebar">

                    <?php get_sidebar(); ?>

                </div><!--/ .sidebar -->
            <?php endif;?>

	        <div class="clear"></div>
            <?php tfuse_pagination() ?>
            <?php if (tfuse_shortcode_content('after', true)!=''): ?>
            <div class="grid_12 content">
                <?php  tfuse_shortcode_content('after'); ?>
            </div><!--/ .content -->
            <div class="clear"></div>
            <?php endif; ?>

    </div><!--/ .container_12 -->
</div><!--/ .middle -->
<?php  get_footer(); ?>