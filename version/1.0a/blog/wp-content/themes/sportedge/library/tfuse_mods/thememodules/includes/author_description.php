<?php
if ( !tfuse_page_options(PREFIX . '_post_meta_about_author') && get_option( PREFIX . '_disable_author_info_box')=='false' ) { ?>
    <!-- author description -->
    <div class="author-box">
        <div class="author-description">
            <div class="author-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), '100' ); ?></div>
            <div class="author-text">
                <h4><?php echo get_the_author(); ?></h4>
                <p><?php the_author_meta( 'description' ); ?></p>
                  <div class="author-contact"><label><?php _e('CONTACT THE AUTHOR:', 'tfuse'); ?></label>
                        <?php $tfuse_meta = tfuse_action_user_profile();
                        if ( isset($tfuse_meta['facebook']) || isset($tfuse_meta['twitter']) || isset($tfuse_meta['in']) ) :
                            foreach($tfuse_meta as $key => $item): ?>
                                <?php if ($item ) { ?> <a href="<?php echo $item;?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/social_<?php echo $key; ?>_2.png" alt="social" width="20" height="20" border="0" /></a><?php } ?>
                            <?php endforeach;
                        endif;?>
                  </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <!--/ author description -->
<?php } ?>


