<?php

/**********************************
 Combined comment counts (and caching)
 **********************************/
function fbComments_getCachedCommentCount($xid, $wpCommentCount) {
	fbComments_log('In ' . __FUNCTION__ . "(xid=$xid, wpCommentCount=$wpCommentCount)");
	global $fbc_options;

	$fbCommentCount = get_option("fbComments_commentCount_$xid");

	return fbComments_getProperCommentCount($fbCommentCount, $wpCommentCount);
}

function fbComments_getProperCommentCount($fbCommentCount=0, $wpCommentCount=0) {
	fbComments_log('In ' . __FUNCTION__ . "(fbCommentCount=$fbCommentCount, wpCommentCount=$wpCommentCount)");
	global $fbc_options, $wp_query, $wpdb;
	$postId = $wp_query->post->ID;
	
	// $comments = $wpdb->get_row("SELECT comment_count as count FROM wp_posts WHERE ID = '$postId'");
	// $commentcount = $comments->count;
	// wp_reset_query();
	# If the WordPress comments are hidden, just return the Facebook comments count
	if ($fbc_options['hideWpComments']) {
		// if (!comments_open()) return $wpCommentCount;
		fbComments_log("    Returning a Facebook comment count of $fbCommentCount");
		return $fbCommentCount;
	# If commenting is closed on this post or we shouldn't be displaying Facebook comments due to settings, just return the WordPress comments count
	} elseif (!comments_open() ||
			  ($fbc_options['displayPagesOrPosts'] == 'pages') && (!is_page()) ||
			  ($fbc_options['displayPagesOrPosts'] == 'posts') && (!is_single())) {
	  return $wpCommentCount;
	} else {
		fbComments_log(sprintf('    Returning a combined comment count of %d', $fbCommentCount+$wpCommentCount));
		return $fbCommentCount + $wpCommentCount;
	}
}

/*
 * Loops through all posts and caches the Facebook comment count
 *
 * Thanks to Almog Baku for help with the Facebook API calls (http://www.almogbaku.com/)
 */
function fbComments_cacheAllCommentCounts() {
	global $fbc_options;
	fbComments_log('In ' . __FUNCTION__ . '()');

	$fb = fbComments_getFbApi();
	$posts = get_posts(array('numberposts' => -1)); // Retrieve all posts

	if ($posts) {
		fbComments_log(sprintf('    Looping through %d posts', count($posts)));
		foreach ($posts as $post) {
			$xid = $fbc_options['xid'] . "_post{$post->ID}";
			$query = array(
				'method' => 'fql.query',
				'query'	 => 'SELECT count FROM comments_info WHERE app_id="' . $fb->getAppId() . '" AND xid="' . $xid . '"'
			);

			try {
				fbComments_log("    Retrieving Facebook comment count for post with xid=$xid");
				$result = $fb->api($query);

				if ($result) {
					update_option("fbComments_commentCount_$xid", $result[0]['count']);
				}
			} catch (FacebookApiException $e) {
				fbComments_log("    FAILED to retrieve Facebook comment count for post with xid=$xid error: $e");
			}
		}
	}
}


function fbComments_combineCommentCounts($value) {
	fbComments_log('In ' . __FUNCTION__ . "(value=$value)");
	global $fbc_options, $wp_query;

	$postId = $wp_query->post->ID;
	$xid = $fbc_options['xid'] . "_post$postId";

	// Return the cached comment count (if it exists)
	if (get_option("fbComments_commentCount_$xid") !== null) {
		return fbComments_getCachedCommentCount($xid, $value);
	}

	$fb = fbComments_getFbApi();

	$query = array(
		'method' => 'fql.query',
		'query'	 => 'SELECT count FROM comments_info WHERE app_id="' . $fb->getAppId() . '" AND xid="' . $xid . '"'
	);

	try {
		fbComments_log("    Comment count wasn't cached. Retrieving Facebook comment count for post with xid=$xid");
		$result = $fb->api($query);
		
		if ($result) {
			// Cache the Facebook comment count
			update_option("fbComments_commentCount_$xid", $result[0]['count']);

			return fbComments_getProperCommentCount($result[0]['count'], $value);
		}
	} catch (FacebookApiException $e) {}

	fbComments_log("    FAILED to retrieve Facebook comment count for post with xid=$xid");
	return fbComments_getProperCommentCount(0, $value);
}

?>