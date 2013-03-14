<?php
// Fist full of comments
function custom_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment; ?>
            
	<li <?php comment_class(); ?>>
    
    	<a name="comment-<?php comment_ID() ?>"></a>

		<div id="li-comment-<?php comment_ID() ?>" class="comment-container comment-body">

		<?php if(get_comment_type() == "comment")
		{ ?>
                <div class="comment-avatar">
                    <div class="avatar"><?php the_commenter_avatar($args) ?></div>
                    <div class="link-author"><?php the_commenter_link() ?></div>
                </div>
			<?php } ?>

			<div class="comment-text">

				<div class="comment-date"><?php echo get_comment_date() ?></div>
				<div class="comment-entry"><?php echo get_comment_text() ?> <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>

			<?php if($comment->comment_approved == '0')
			{ ?>
					<p class='unapproved'><?php _e('Your comment is awaiting moderation.', 'tfuse'); ?></p>
				<?php } ?>

			</div>
			<!-- /.comment-head -->
			<div id="comment-<?php comment_ID(); ?>"></div>
			<div class="clear"></div>

		</div><!-- /.comment-container -->

	<?php
}


// PINGBACK / TRACKBACK OUTPUT
if (!function_exists("list_pings")) {
	function list_pings($comment, $args, $depth) {
	
		$GLOBALS['comment'] = $comment; ?>
		
		<li id="comment-<?php comment_ID(); ?>">
			<span class="author"><?php comment_author_link(); ?></span> - 
			<span class="date"><?php echo get_comment_date(get_option( 'date_format' )) ?></span>
			<span class="pingcontent"><?php comment_text() ?></span>
	
	<?php 
	} 
}

function the_commenter_link()
{
	$commenter = get_comment_author_link();
	if(ereg(']* class=[^>]+>', $commenter))
	{
		$commenter = ereg_replace('(]* class=[\'"]?)', '\\1url ', $commenter);
	}
	else
	{
		$commenter = ereg_replace('(<a )/', '\\1class="url "', $commenter);
	}
	echo $commenter;
}

function the_commenter_avatar($args)
{
	$email = get_comment_author_email();
	$avatar = str_replace("class='avatar", "class='photo", get_avatar("$email", $args['avatar_size']));
	echo $avatar;
}

?>