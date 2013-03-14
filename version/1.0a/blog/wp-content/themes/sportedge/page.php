<?php get_header(); ?>

	<div <?php tfuse_middle_class() ?>>
        <div class="container_12">
            <?php $sidebar_position = tfuse_sidebar_position(); ?>
            <?php $top_sidebar_position = tfuse_sidebar_position('top'); ?>

            <?php if ( tfuse_page_options(PREFIX . '_page_featured_tabs') ) { ?>
                <div class="featured_block">

                    <?php if (  $top_sidebar_position == 'left' ) :  ?>

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
 
            <?php $tfuse_param = tfuse_header_parametrs();
 
            if( !is_front_page() && $tfuse_param['header_element'] != 'type1' && !tfuse_page_options(PREFIX . '_page_featured_tabs') )
            {?>
                <div class="back_title">
                    <div class="back_inner">
                    <a href="<?php echo site_url() ?>"><span><?php _e( 'Home', 'tfuse'); ?></span></a>
                    </div>
                </div>
                <div class="divider_space_thin"></div>
             <?php } ?>
            <?php if (tfuse_shortcode_content('before', true)!=''): ?>
            <div class="grid_12 content">
                <?php tfuse_shortcode_content('before'); ?>
            </div><!--/ .content -->
            <?php endif; ?>

            <?php if (  $sidebar_position == 'left' ) : ?>

                <div class="grid_4 sidebar">
                    <?php get_sidebar(); ?>
                </div><!--/ .sidebar -->
            <?php endif; ?>
            <div <?php tfuse_class('content'); ?>>
                    <?php  if (have_posts()) : $count = 0;
                    while (have_posts()) : the_post(); $count++; ?>


                        <?php  if ( !tfuse_page_options(PREFIX . '_page_show_the_title') ) : ?>
                            <div class="page-title">
                                <div class="meta-date">&nbsp;</div>
                                <?php the_title('<h1>','</h1>');?>
                            </div>
                        <?php endif; ?>
                        <div class="entry">
                            <?php the_content();?>
                        </div><!--/ .entry -->

                        <?php if ( tfuse_page_options(PREFIX . '_page_authors_box') ) require_once(THEME_INCLUDES.'/executive_users.php');?>
                        <?php if ( tfuse_page_options(PREFIX . '_page_bottom_boxes') ) :?>
                            <div class="divider_space_thin"></div>
                            <?php tfuse_bottom_posts_boxes(); ?>
                        <?php endif; ?>
                        <div class="clear"></div>
                        <?php  tfuse_comments();

                    endwhile; else: ?>

                        <div class="entry">

                            <?php  _e('Sorry, no posts matched your criteria.', 'tfuse');;?>

                        </div><!--/ .entry -->

                    <?php endif; ?>

                </div><!--/ .content -->

            <?php if ( $sidebar_position == 'right' ) : ?>
                <div class="grid_4 sidebar">

                    <?php get_sidebar(); ?>

                </div><!--/ .sidebar -->
            <?php endif; ?>

            <div class="clear"></div>
            <?php if (tfuse_shortcode_content('after', true)!=''): ?>
            <div class="grid_12 content">
                <?php  tfuse_shortcode_content('after'); ?>
            </div><!--/ .content -->
            <div class="clear"></div>
            <?php endif; ?>


    </div><!--/ .container_12 -->
</div><!--/ .middle -->
<?php  get_footer(); ?>