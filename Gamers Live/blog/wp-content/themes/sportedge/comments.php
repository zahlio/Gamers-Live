<?php
	
// Do not delete these lines

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() )
{ ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'tfuse') ?></p>

<?php return;
} ?>

<?php $comments_by_type = &separate_comments($comments); ?>    

<!-- You can start editing here. -->

<div class="comment-list" id="comments">

<?php if ( have_comments() ) : ?>

	<?php if ( ! empty($comments_by_type['comment']) ) : ?>
                            

		<h2 class="comment_h2 alignleft" ><?php comments_number('0', '1', '%');  _e(' Readers Commented', 'tfuse') ?></h2>
        <a href="#addcomments" class="link-addcomment alignright"><?php _e('Add a comment', 'tfuse') ?></a>
		<ol>
			<?php wp_list_comments('avatar_size=90&callback=custom_comment&type=comment'); ?>
		</ol>

		<!--
		<div class="navigation">
			<div class="fl"><?php previous_comments_link() ?></div>
			<div class="fr"><?php next_comments_link() ?></div>
			<div class="fix"></div>
		</div>-->

	<?php endif; ?>
		    
	<?php if ( ! empty($comments_by_type['pings']) ) : ?>
    	
		<!--	
        <h3 id="pings"><?php _e('Trackbacks/Pingbacks', 'tfuse') ?></h3>
    
        <ol class="pinglist">
            <?php wp_list_comments('type=pings&callback=list_pings'); ?>
        </ol>
		-->
    	
	<?php endif; ?>
    	
<?php else : // this is displayed if there are no comments so far ?>

		<?php if ('open' == $post->comment_status) : ?>
			<!-- If comments are open, but there are no comments. -->
			<p class="nocomments"><?php _e('No comments yet.', 'tfuse') ?></p>

		<?php else : // comments are closed ?>
			<!-- If comments are closed. -->
			<p class="nocomments"><?php _e('Comments are closed.', 'tfuse') ?></p>

		<?php endif; ?>

<?php endif; ?>

</div> <!-- /#comments_wrap -->
<?php if ('open' == $post->comment_status) : ?>
<div class="clear"></div>
<div id="respond">
    <div class="clear"></div>

	<div class="box2 add-comment" id="addcomments"><div class="clear"></div>
        <h3 class="leave_comm_rep"><?php _e('Leave a Reply', 'tfuse') ?></h3>

            <div class="clear"></div>
			<?php if ( get_option('comment_registration') && !$user_ID ) : //If registration required & not logged in. ?>
		
				<p><?php _e('You must be', 'tfuse') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in', 'tfuse') ?></a> <?php _e('to post a comment.', 'tfuse') ?></p>
		
			<?php else : //No registration required ?>

				<div class="box2_content comment-form">
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" name="commentform" id="commentform">
		
				<?php if ( $user_ID ) : //If user is logged in ?>
		
					<p><?php _e('Logged in as', 'tfuse') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="<?php _e('Log out of this account', 'tfuse') ?>"><?php _e('Logout', 'tfuse') ?> &raquo;</a></p>
		
				<?php else : //If user is not logged in ?>
					<div class="row alignleft">
						<label for="author"><strong><?php _e('Name', 'tfuse') ?></strong></label>
						<input type="text" name="author" class="inputtext input_middle required" id="author"  value="<?php echo $comment_author; ?>" tabindex="1" />
					</div>

		            <div class="space"></div>

					 <div class="row alignleft">
						<label for="email"><strong><?php _e('Email', 'tfuse') ?></strong><?php _e(' (never published)', 'tfuse') ?></label>
						<input type="text" name="email" class="inputtext input_middle required" id="email"  value="<?php echo $comment_author_email; ?>" tabindex="2" />
					</div>

                    <div class="clear"></div>
					
					<div class="row">
						<label for="url"><strong><?php _e('Website', 'tfuse') ?></strong></label>
						<input type="text" name="url" class="inputtext input_full" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" />
					</div>

				<?php endif; // End if logged in ?>
		
				<!--<p><strong>XHTML:</strong> <?php _e('You can use these tags', 'tfuse'); ?>: <?php echo allowed_tags(); ?></p>-->
		
				<div class="row">
					<label><strong><?php _e('Comment', 'tfuse') ?></strong></label>
					<textarea name="comment" class="textarea textarea_middle required" id="comment" cols="30" rows="10" tabindex="4"></textarea>
				</div>

					<input name="submit" type="submit" id="submit" class="btn-submit" tabindex="5" value="<?php _e('Submit', 'tfuse') ?>" />
					<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
                    <div class="cancel-comment-reply">
                        <small><?php cancel_comment_reply_link(__('Click here to cancel reply', 'tfuse')); ?></small>
                    </div><!-- /.cancel-comment-reply -->
				<?php comment_id_fields(); ?>
				<?php do_action('comment_form', $post->ID); ?>
		
				</form><!-- /#commentform -->
				</div><!-- /.comment-form -->
		
			<?php endif; // If registration required ?>

    </div><!-- /#addcomments -->
</div><!-- /#respond -->
<?php endif; // if you delete this the sky will fall on your head ?>
