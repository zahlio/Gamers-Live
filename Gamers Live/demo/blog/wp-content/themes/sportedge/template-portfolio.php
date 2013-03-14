<?php
/*
Template Name: Portfolio Template
*/

get_header();?>
	<div <?php tfuse_middle_class(); ?>>

    	    <div class="container_12">

            <?php $tfuse_param = tfuse_header_parametrs();

             if( !is_home() && $tfuse_param['header_element'] != 'type1' )
             {  ?>
                <div class="back_title">
                    <div class="back_inner">
                    <a href="<?php echo site_url() ?>"><span><?php _e( 'Home', 'tfuse'); ?></span></a>
                    </div>
                </div>
                <div class="divider_space_thin"></div>
             <?php }  ?>

            <?php  if ( have_posts() && !tfuse_page_options(PREFIX . '_page_show_the_title') ) : ?>
                <div class="grid_12">
                    <div class="page-title">
                        <div class="meta-date">&nbsp;</div>
                        <?php the_title('<h1>','</h1>');?>
                    </div>
                </div>
            <?php endif; ?>


           <div class="gallery-list gl_col_3">
           <?php wp_reset_query();

           $cat = get_post_meta($post->ID, PREFIX."_blog_page_cat", true);

           if ( get_query_var('paged') ) $paged = get_query_var('paged');
           elseif ( get_query_var('page') ) $paged = get_query_var('page'); else $paged = 1;

            query_posts("cat=$cat&paged=$paged");
            if (have_posts()) : $count = 0;
            while (have_posts()) : the_post(); $count++;?>

                <div class="gallery-item">
                    <div class="gallery-image">
                    <a href="<?php the_permalink() ?>" class="preload"><?php tfuse_media('fixed', '300', '200', false, true, '');?></a>
                    </div>
                    <div class="gallery-text">
                          <div class="gallery-item-name"><h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2></div>
                        <div class="gallery-description">
                            <span class="ico_cat"><?php $category =  get_the_category(); echo $category[0]->cat_name;  ?></span>
                            <?php echo tfuse_substr(get_the_excerpt(), 15); ?>
                        </div>
                      </div>
                    <div class="clear"></div>
                </div>

            <?php endwhile; else:

                _e('Sorry, no posts matched your criteria.', 'tfuse');

            endif; ?>
           <div class="divider"></div>

            <?php tfuse_pagination(); ?>

            </div><!--/ .post-item -->

            <div class="clear"></div>

    </div><!--/ .container_12 -->
</div><!--/ .middle -->
<div class="middle_bot"></div>
<?php  get_footer(); ?>