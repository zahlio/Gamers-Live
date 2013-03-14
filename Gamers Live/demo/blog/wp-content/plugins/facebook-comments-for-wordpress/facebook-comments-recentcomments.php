<?php

	/**********************************
	 Dashboard recent comments widget
	 **********************************/
	 /**
	 * Display recent comments from facebook in a dashboard widget.
	 *
	 * @since 3.0.0
	 */
	function fbcomments_dashboard_widget_function() {
		global $fbc_options;

		wp_register_style('widgets', FBCOMMENTS_CSS_WIDGETS, array(), FBCOMMENTS_VER);
		wp_enqueue_style('widgets');

		// needed for fb api call? excep 104 without it
		fbComments_storeAccessToken();

		$atoken =  $fbc_options['accessToken'];
		$fb = fbComments_getFbApi();


		$commentsq = "SELECT fromid, text, id, time, username, xid, object_id ".
				  "FROM comment WHERE xid IN (SELECT xid FROM comments_info WHERE app_id={$fbc_options['appId']})".
				  "ORDER BY time desc";
		$usersq = "SELECT id, name, url, pic_square FROM profile ".
				  "WHERE id IN (SELECT fromid FROM #comments)";

		$query = '{
					"comments": "' . $commentsq . '",
					"users": "' . $usersq . '"
				  }';

		$query = array("method"=>"fql.multiquery","queries"=>$query,'access_token'=>$atoken);
		$result = $fb->api($query);

		$comments = $result;
		if (!is_array($comments)) { print_r('No&nbsp;response&nbsp;from&nbsp;facebook.com'); return; }
		$ncomms = sizeof($comments[0]['fql_result_set']);
		$dcomms = $ncomms < $fbc_options['dashNumComments'] ? $ncomms : $fbc_options['dashNumComments'];

		if ($ncomms == 0) { echo "<div style='text-align:right; font-size:.8em'>
					<a href='https://developers.facebook.com/tools/comments?id={$fbc_options['appId']}'>Administer Comments</a></div><hr />"
					.'No Comments!';
		} else {
			// $ncomms  = $ncomms < 10 ? $ncomms : 10;

			$htmlout =
				// using the old api to make calling from js easier
				// the new graph api method is much cleaner, but it causes problems in opera
				// since it returns a value, which opera then prompts the user to open or save
				"<div id=\"fb-root\"></div>
				<script>
				  window.fbAsyncInit = function() {
					FB.init({appId: '{$fbc_options['appId']}', status: true, cookie: true, xfbml: true});
				  };
				  (function() {
					var e = document.createElement('script'); e.async = true;
					e.src = document.location.protocol +
					  '//connect.facebook.net/en_US/all.js';
					document.getElementById('fb-root').appendChild(e);
				  }());
				</script>"
				."<div style='text-align:right; font-size:.8em'>
					<a href='https://developers.facebook.com/tools/comments?id={$fbc_options['appId']}'>Administer Comments</a></div><hr />"
				// should probably change this to class so that it validates
				.'<div id="the-comment-list" class="list:comment" style="margin-top: -1em">';

			$parity = '';
			$users = $comments[1]['fql_result_set'];
			$comments = $comments[0]['fql_result_set'];
			for ($i=0,$par=0;$i<$dcomms;$i++,$par++) {
				// for people who use the same app id for more than one site,
				// only return results unique to this xid
				if ( strncmp($comments[$i]['xid'],$fbc_options['xid'],15) ) { $par--; continue; }

				// find matching user
				for ($j=0;$j<count($users);$j++) {
					if ($comments[$i]['fromid'] == $users[$j]['id']) {
						$index=$j;
						break;
					}
				}

				// Comment username and Link
				$username = $comments[$i]['fromid'];
				if ($username == '1309634065') {	// if anon user
					$username = '<span class="aname">$comments[$i][username]</span>';
				} else {
					$username = '<a target="_blank" href="https://www.facebook.com/profile.php?id='
						. $username
						.'">'. $users[$index]['name'] .'</a>';
				}

				// make pretty
				$commenttext = $comments[$i]['text'];
				$order   = array("\r\n", "\n", "\r");
				$replace = '<br />';

				// Processes \r\n's first so they aren't converted twice.
				$commenttext = str_replace($order, $replace, $commenttext);

				// url of post/page on which comment was made
				$post_id = substr($comments[$i]['xid'],20);
				$commenturl = get_permalink($post_id);

				// make pretty alternations
				$parity = ($par&1)
					? "comment byuser comment-author-admin odd alt thread-odd thread-alt depth-1 comment-item approved":
					"comment byuser comment-author-admin even thread-even depth-1 comment-item approved";

				$imgurl = $users[$index]['pic_square'];

				// what will be written to the dashboard widget
				$htmlout .=
				'<div class="'.$parity.'">'.
					'<img alt="" src="'.$imgurl.'" class="avatar avatar-50 photo" height="50" width="50"/>'.
					'<div class="dashboard-comment-wrap">'.
						'<h4 class="comment-meta"> From '.
							'<cite class="comment-author"><a href="https://www.facebook.com/profile.php?id='.$comments[$i]['fromid'].'">'.$username.'</a></cite> on '.
							'<a href="'.$commenturl.'">'.get_post($post_id)->post_title.'</a>
							<abbr style="font-size:.8em" title="'.date('r',$comments[$i]['time']).'"> '.date('d M Y',$comments[$i]['time']).'</abbr>
							<span class="approve">[Pending]</span>'.
						'</h4>
						<blockquote>
							<p>'.$commenttext.'</p>
						</blockquote>
						<p class="row-actions">
							<span class="trash wallkit_actionset">

							<a id="deletecomm'.$i.'" href="#" class="delete vim-d vim-destructive" title="Delete this comment">
								delete
							</a>

							</span>'.
							"<script>
							jQuery('#deletecomm".$i."').click(function(data) {
								FB.api({
										method: 'comments.remove',"
										.'comment_id: "'.$comments[$i]['id'].'", '
										.'xid: "'.$comments[$i]['xid'].'", '
										.'access_token: "'.$atoken.'", '
									."},
									function(response) {
										if (!response || response.error_code) {
											alert('ERROR: Failed to delete comment.');
										} else {
											alert('Comment Deleted');
											window.location.reload();
										}
									});
							});
							</script>
						</p>
					</div>
				</div>";
			}
			$htmlout .= '</div>';
			print_r($htmlout);
		}
	}

	// Create the function used in the action hook
	function fbcomments_add_dashboard_widgets() {
		global $fbc_options;
		if ($fbc_options['showDBWidget'] == true)
			wp_add_dashboard_widget('dashboard_widget', 'Recent Facebook comments', 'fbcomments_dashboard_widget_function');
	}


	/**********************************
	 Page recent comments widget
	 **********************************/
	/* add styles before wp_head is loaded
	  see: http://bit.ly/igYFYu
	*/
	function conditionally_add_scripts_and_styles($posts){
		if (empty($posts)) return $posts;

		// enqueue here
		wp_enqueue_style('fbc_rc_widgets-style', FBCOMMENTS_CSS_WIDGETS);

		return $posts;
	}

	/**
	 * Recent_Comments widget class
	 *
	 * @since 3.0.0
	 */
	class FBCRC_Widget extends WP_Widget {
		/** constructor */
		function FBCRC_Widget() {
			$widget_ops = array( 'description' => __('The most recent Facebook comments.') );
			parent::WP_Widget(false, $name = 'Recent Facebook Comments', $widget_ops);
		}

		/** @see WP_Widget::widget */
		function widget($args, $instance) {
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);

			global $fbc_options;
			$atoken = $fbc_options['accessToken'];

			$fb = fbComments_getFbApi();
			/*
			select post_id, fromid, time, text, post_fbid 
			from comment 
			where object_id 
			in (select comments_fbid from link_stat where url="http://developers.facebook.com/blog/post/472")'
			*/
			$commentsq = "SELECT fromid, text, id, time, username, xid, object_id ".
					  "FROM comment WHERE xid IN (SELECT xid FROM comments_info WHERE app_id={$fbc_options['appId']})".
					  "ORDER BY time desc";
			// $commurl = urlencode('');
			// $commentsq = "SELECT fromid, text, id, time, username, xid, post_id, post_fbid, object_id ".
						 // "FROM comment ".
						 // "WHERE (xid IN (SELECT xid FROM comments_info WHERE app_id={$fbc_options['appId']})) ".
						 // "OR object_id IN (SELECT comments_fbid FROM link_stat WHERE url='$commurl') ".
						 // "ORDER BY time desc";
			
			// $commentsq = "SELECT post_id, fromid, time, text, post_fbid ".
					  // 'FROM comment'.
					  // "ORDER BY time desc";
			$usersq = "SELECT id, name, url, pic_square FROM profile ".
					  "WHERE id IN (SELECT fromid FROM #comments)";

			$query = '{
						"comments": "' . $commentsq . '",
						"users": "' . $usersq . '"
					  }';


			$query = array("method"=>"fql.multiquery","queries"=>$query,'access_token'=>$atoken);
			
			$comments = $fb->api($query);

			if ( ! $number = (int) $instance['number'] )
				$number = 5;
			else if ( $number < 1 )
				$number = 1;
			$ncomms = sizeof($comments[0]['fql_result_set']);

			// if no comments, display no comments; otherwise display the greater of $ncomms and $number comments
			$ncomms  = $ncomms == 0 ? 0 : ($ncomms < $number ? $ncomms : $number);
			$output = '<ul id="fbc_rc_widget">';

			$parity = '';
			$users = $comments[1]['fql_result_set'];
			$comments = $comments[0]['fql_result_set'];
			
			$show_avatar = isset($instance['show_avatar']) ? $instance['show_avatar'] : true;

			for ($i=0,$par=0;$i<$ncomms;$i++,$par++) {
				if ( strncmp($comments[$i]['xid'],$fbc_options['xid'],15) ) { $par--; continue; }
				// find matching user
				for ($j=0;$j<count($users);$j++) {
					if ($comments[$i]['fromid'] == $users[$j]['id']) {
						$index=$j;
						break;
					}
				}
				

				// Comment meta
				$username = $comments[$i]['fromid'];
				if ($username == '1309634065') {	// if anon user
					$username = $comments[$i]['username'];
				} else {
					$username = '<a target="_blank" href="https://www.facebook.com/profile.php?id='.$username.'">'.$users[$index]['name'].'</a>';
				}

				// print user defined number of words, if there are less than this, don't trim
				$commenttext = trim($comments[$i]['text'], ' ');
				$nwords = count(explode(" ",$commenttext));
				$dwords = $nwords <= $instance['word_count'] ? $nwords : $instance['word_count'];
				if ($nwords > $dwords) {
					preg_match("/^(\S+\s+){0,$dwords}/", $commenttext, $matches); // match spaces (nth space will be at end of nth word)
					$commenttext = trim($matches[0]) . '[...]';
				}

				// print line breaks as such
				$order   = array("\r\n", "\n", "\r"); // Processes \r\n's first so they aren't converted twice.
				$replace = '<br />';
				$commenttext = str_replace($order, $replace, $commenttext);

				// url of post/page on which comment was made
				$post_id = substr($comments[$i]['xid'],20);
				$commenturl = get_permalink($post_id);

				// to allow alternating styles on comments
				$parity = ($par&1) ? "odd": "even";

				// display avatar only if option is checked
				if ($show_avatar) {
					$imgurl = $users[$index]['pic_square'];
					$imgclass = '';
				} else {
					$imgurl = $users[$index]['pic_square'];
					$imgclass = 'style="display:none"';
				}

				// what will be written to the widget
				$output .=
				'<li class="fbc_rc_comment '.$parity.'">
					<div class="fbc_rc_comment-meta">
						<cite class="fbc_rc_comment-author"><a href="https://www.facebook.com/profile.php?id='.$comments[$i]['fromid'].'">'.$username.'</a></cite>
						<abbr class="fbc_rc_date" title="'.date('r',$comments[$i]['time']).'">'.date('d M Y',$comments[$i]['time']).'</abbr>
					</div>
					<img alt="" src="'.$imgurl.'" class="avatar" height="50" width="50" '.$imgclass.' />
					<div class="fbc_rc_text">'.$commenttext.'</div>
					<div class="fbc_rc_permalink"><a href="'.$commenturl.'"> '.get_post($post_id)->post_title.'</a></div>
				</li>';
			}
			$output .= '</ul>';

			// print everything out
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
			echo $output;
			echo $after_widget;
		}

		/** @see WP_Widget::update */
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			$instance['word_count'] = (int) $new_instance['word_count'];
			if ( isset($new_instance['show_avatar']) )
				$instance['show_avatar'] = 1;
			else
				$instance['show_avatar'] = 0;
			return $instance;
		}

		/** @see WP_Widget::form */
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'show_avatar' => true ) );
			$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Comments';
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
			$word_count = isset($instance['word_count']) ? absint($instance['word_count']) : 50;

			?>
			 <p>
			  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Max number of comments to show:'); ?></label>
			  <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('word_count'); ?>"><?php _e('Max number of words per comment to show:'); ?></label>
			  <input id="<?php echo $this->get_field_id('word_count'); ?>" name="<?php echo $this->get_field_name('word_count'); ?>" type="text" value="<?php echo $word_count; ?>" size="3" />
			</p>
			<p>
			  <input class="checkbox" type="checkbox" <?php checked( $instance['show_avatar'], true ); ?> id="<?php echo $this->get_field_id( 'show_avatar' ); ?>" name="<?php echo $this->get_field_name( 'show_avatar' ); ?>" />
			  <label for="<?php echo $this->get_field_id( 'show_avatar' ); ?>">Check to display avatar</label>
			</p>
			<?php
		}

	} // class FBCRC_Widget

function fbComments_dashboard_widget_init() {
	if (is_admin()) {
		wp_enqueue_script('jquery');
	}
}

?>
