<?php
/*
Template Name: Contact Form
*/

$error = true; if(isset($_POST['email'])) { require_once(THEME_FUNCTIONS . '/sendmail.php'); }

get_header();?>
	<div <?php tfuse_middle_class(); ?>>

    	    <div class="container_12">
                <?php $tfuse_param = tfuse_header_parametrs();

                if( $tfuse_param['header_element'] != 'type1' && !tfuse_page_options(PREFIX . '_page_featured_tabs') )
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
             <?php $sidebar_position = tfuse_sidebar_position();

                if (  $sidebar_position == 'left' ) : ?>
                <div class="grid_4 sidebar">

                    <?php get_sidebar(); ?>

                </div><!--/ .sidebar -->
            <?php endif; ?>

            <div <?php tfuse_class('content'); ?>>
                    <?php  if (have_posts()) : $count = 0;
                    while (have_posts()) : the_post(); $count++; ?>
                    <div class="post-detail">
                        <div class="page-title">
                            <div class="meta-date">&nbsp;</div>
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="entry">
                        <?php  the_content(); ?>

                        <div class="clear"></div>

                        </div><!--/ .entry -->
                    <div class="divider_space_thin"></div>
                    <div class="box2 add-comment" id="addcomments">
                        <h3><?php _e('Get in touch!', 'tfuse') ?></h3>
                        <div class="box2_content comment-form">

                        <form  id="contactForm" action="" method="post" class="ajax_form" name="contactForm">
                            <input type="hidden" name="temp_url" value="<?php bloginfo('template_directory'); ?>" />
                            <input type="hidden" id="tempcode" name="tempcode" value="<?php echo base64_encode(get_option('admin_email')); ?>" />
                            <input type="hidden" id="myblogname" name="myblogname" value="<?php bloginfo('name'); ?>" />
                            <?php if (!isset($error) || $error == true){ ?>

                            <div class="row alignleft <?php if (isset($the_nameclass)) echo $the_nameclass; ?>">

                                <label><strong><?php _e('Name', 'tfuse') ?></strong></label>
                                <input name="name" value="<?php if (isset($the_name)) echo $the_name?>" id="name" class="inputtext input_middle required" size="40" type="text" />

                            </div>
                            <div class="space"></div>

                            <div class="row  alignleft <?php if (isset($the_emailclass)) echo $the_emailclass; ?>">

                                <label><strong><?php _e('Email', 'tfuse') ?></strong> <?php _e('(never published)', 'tfuse') ?></label>
                                <input name="email" value="<?php if (isset($the_email)) echo $the_email ?>" id="email" class="inputtext input_middle required" size="40" type="text" />

                            </div>

                            <div class="clear"></div>

                            <div class="row <?php if (isset($the_emailclass)) echo $the_emailclass; ?>">
                                <label><strong><?php _e('Website', 'tfuse') ?></strong></label>
                                <input name="url" value="" class="inputtext input_full "  type="text" id="url"/>

                            </div>


                            <div class="clear"></div>

                            <div class="row <?php if (isset($the_messageclass)) echo $the_messageclass; ?>">
                                <label><strong><?php _e('Comment', 'tfuse') ?></strong></label>
                                <textarea id="message" name="message" class="textarea textarea_middle required" cols="40" rows="10"><?php  if (isset($the_message)) echo $the_message ?></textarea>
                            </div>

                                <input value="<?php _e('Submit', 'tfuse') ?>" title="Submit" class="btn-submit" id="send"  type="submit" name="Send" />


                            <?php } else { ?>

                                <br>

                                <h2 style="width:100%;"><?php _e('Your message has been sent!', 'tfuse') ?></h2>

                                <div class="confirm">

                                    <p class="textconfirm"><br /><?php _e('Thank you for contacting us,', 'tfuse') ?><br/><?php _e('We will get back to you within 2 business days.', 'tfuse') ?></p>

                                </div>

                            <?php } ?>
                        </form>
                    </div> <!--/ .box2_content -->
                 </div> <!--/ .add-comment -->

            <?php endwhile; else: ?>

                <div class="entry">

                    <?php  _e('Sorry, no posts matched your criteria.', 'tfuse');;?>

                </div><!--/ .entry -->

            <?php endif; ?>

                </div><!--/ .post-item -->


                </div><!--/ .content -->

                    <?php if ( $sidebar_position == 'right' ) : ?>
                <div class="grid_4 sidebar">

                    <?php get_sidebar(); ?>

                </div><!--/ .sidebar -->
            <?php endif; ?>
	                <div class="clear"></div>

            <?php if ( tfuse_page_options(PREFIX . '_page_bottom_boxes') ) :?>
                <div class="divider_space_thin"></div>
                <?php tfuse_bottom_posts_boxes(); ?>
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