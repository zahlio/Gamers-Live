<?php get_header(); ?>

	<div <?php tfuse_class('middle'); ?>>

    	    <div class="container_12" <?php echo (is_search())? 'style="margin-top:0px;"' : ''; ?>>
              <div class="cat_title">
                  <strong class="title"><span><?php tfuse_action_title(); ?></span></strong>
              </div>


			   
                 <?php $sidebar_position = tfuse_sidebar_position(); ?>

                <div class="content">
 
                <div class="post-list">

                <?php  $tfuse_num_post_row = 6;
                   query_posts( $query_string . '&paged='.get_query_var('paged').'&posts_per_page=9' );
                    
                    if (have_posts()) :  $count = 0;  $aux_count = 0;
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
                                 <?php if( !has_excerpt() )    tfuse_media('cat', '120','100', false, true, '');
                                 echo get_the_excerpt(); ?>
                            </p>
                            <div class="meta-bot"><a href="<?php the_permalink(); ?>" class="button_link"><span><?php _e('Read', 'tfuse'); ?></span></a> &nbsp;
                                <a href="<?php comments_link(); ?>" class="link-comments"><?php comments_number('0 comments', '1 comment', '% comments') ?></a>
                            </div>
                        </div>
                    </div>
            <?php echo ($count%3 == 0)? '<div class="clear"></div>':'';
			 endwhile;

		      else: ?>

				<h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>

			<?php endif; ?>
            <div class="clear"></div>
            <?php  tfuse_pagination(); ?>
            <div class="divider_space_thin"></div>
            </div><!--/ .post-list -->
            </div><!--/ .content -->

	<div class="clear"></div>
    </div><!--/ .container_12 -->
</div><!--/ .middle -->
<?php  get_footer(); ?>