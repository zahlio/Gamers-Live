<?php

error_reporting(0);
/*
Template Name: Template Blog
*/
get_header(); ?>

	<div <?php tfuse_middle_class(); ?>>
        <div class="container_12">
            <?php $tfuse_param = tfuse_header_parametrs();

            ?>
                <div class="back_title">
                    <div class="back_inner">
                    <a href="<?php echo site_url() ?>"><span><?php _e( 'Home', 'tfuse'); ?></span></a>
                    </div>
                </div>
                <div class="divider_space_thin"></div>
            <?php $sidebar_position = tfuse_sidebar_position(); ?>
            <?php if (  $sidebar_position == 'left' ) : ?>

                <div class="grid_4 sidebar">
                    <?php get_sidebar(); ?>
                </div><!--/ .sidebar -->

            <?php endif; ?>

            <div class="grid_8 content">

                <div class="post-list">

                    <?php $cat = tfuse_page_options(PREFIX."_blog_page_cat", true);

                      if ( get_query_var('paged') ) $paged = get_query_var('paged');
                  elseif ( get_query_var('page') ) $paged = get_query_var('page'); else $paged = 1;

                    query_posts("cat=$cat&paged=$paged");

                if (  $sidebar_position['top'] != 'full' )  $tfuse_num_post_row = 2;
                else                                        $tfuse_num_post_row = 3;

                if (have_posts()) :  $count = 0;  $aux_count = 0;
                while (have_posts()) : the_post(); $count++;

                    $aux_count++;

                        if ( $aux_count <= $tfuse_num_post_row ) $tfuse_post_class = 'post-item post-white';
                    elseif( $aux_count > $tfuse_num_post_row && $aux_count <= 2*$tfuse_num_post_row )
                      $tfuse_post_class='post-item';
                    elseif( $aux_count > 2*$tfuse_num_post_row )
                     $aux_count = 1;  $tfuse_post_class= 'post-item post-white';
                ?>

                    <div class="<?php echo $tfuse_post_class; ?>">
                        <div class="meta-date"><?php echo get_the_time('M j') . ', ' . tfuse_time_ago('', true); ?></div>
                        <div class="post-descr">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="post-short">
                                 <?php if( !has_excerpt() )    tfuse_media('cat', '120','100', false, true, '');
                                 echo get_the_excerpt(); ?>
                            </p>
                            <div class="meta-bot"><a href="<?php the_permalink(); ?>" class="button_link"><span><?php _e('Read', 'tfuse'); ?></span></a> &nbsp;
                                <a href="<?php comments_link(); ?>" class="link-comments"><?php comments_number('0 comments', '1 comment', '% comments') ?></a>
                            </div>
                        </div>
                    </div>
                    <?php echo ($count%$tfuse_num_post_row == 0)? '<div class="clear"></div>':'';
                endwhile; else: ?>

                <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>

                <?php endif; ?>
                </div><!--/ .post-list -->
            </div><!--/ .content -->

            <?php if (  $sidebar_position == 'right') : ?>

                <div class="grid_4 sidebar">
                    <?php get_sidebar(); ?>
                </div><!--/ .sidebar -->

            <?php endif;?>

            <div class="clear"></div>
            <?php tfuse_pagination() ?>
        </div><!--/ .container_12 -->
    </div><!--/ .middle -->
<?php  get_footer(); ?>