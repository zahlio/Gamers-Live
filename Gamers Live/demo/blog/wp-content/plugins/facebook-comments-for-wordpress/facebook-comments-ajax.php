<?php
	if (FBCOMMENTS_ERRORS) {
		error_reporting(E_ALL); // Ensure all errors and warnings are verbose
	}

	// Load WordPress functions
	require('../../../wp-load.php');

	// Redirect to main page if this file was accessed directly
	if (!$_POST['fn']) {
		header('Location: ' . home_url());

		exit();
	}

	global $fbc_options;

	// Check if we want to update the comment count or send a notification email
	switch ($_POST['fn']) {
		// Update Facebook comment count
    	case "addComment":
    		fbComments_log('In ' . basename(__FILE__) . " with fn={$_POST['fn']}, xid={$_POST['xid']}");
    		$count = get_option("fbComments_commentCount_{$_POST['xid']}");
    	    if (update_option("fbComments_commentCount_{$_POST['xid']}", $count+1)) {
    	    	fbComments_log(sprintf('    Updated Facebook comment count from %d to %d', $count, $count+1));
    	    	echo 'true';
    	    } else {
    	    	fbComments_log(sprintf('    FAILED to update Facebook comment count from %d to %d', $count, $count+1));
    	    	echo 'false';
    	    }

    	    exit();
    	    break;

    	// Email notifications
    	case "sendNotification":
    		fbComments_log('In ' . basename(__FILE__) . " with fn={$_POST['fn']}, xid={$_POST['xid']}, " .
			  			   "postTitle={$_POST['postTitle']}, postUrl={$_POST['postUrl']}, ");

			fbComments_log("    Fetching comments using an access token of {$fbc_options['accessToken']}");
			$comments = fbComments_getUrl("https://api.facebook.com/method/comments.get?xid={$_POST['xid']}&access_token={$fbc_options['accessToken']}&format=json");
			$commentsJson = json_decode($comments);
			$userId = $commentsJson[0]->fromid;
			$comment = $commentsJson[0]->text;

			fbComments_log("    Fetching user info using an access token of {$fbc_options['accessToken']}");
			$user = fbComments_getUrl("https://api.facebook.com/method/users.getInfo?uids=$userId&fields=name&access_token={$fbc_options['accessToken']}&format=json");
			$userJson = json_decode($user);
			$username = $userJson[0]->name;
			fbComments_log("    For latest comment, poster UID=$userId, poster name=$username, comment=$comment");

    	    $to = get_bloginfo('admin_email');
    	    $subject = "[Facebook Comments for WordPress] New comment: \"{$_POST['postTitle']}\"";

    	    $message = "$username has posted a new comment on your post \"{$_POST['postTitle']}\":\n\n" .
    	    		   "$comment\n\n" .
    	    		   "You can see all Facebook comments on this post here: {$_POST['postUrl']}#facebook-comments";

    	    // Wordwrap the message and strip slashes that may have wrapped quotes
			$message = stripslashes(wordwrap($message, 70));

    	    $headers = "From: $username <$to>\r\n" .
          			   "Reply-To: $to\r\n" .
          			   "X-Mailer: PHP" . phpversion();

          	// Send the email notification
          	if (wp_mail($to, $subject, $message, $headers)) {
          		fbComments_log(sprintf('    Sent email notification to %s', $to));
				echo "true";
			} else {
				fbComments_log(sprintf('    FAILED to send email notification to %s', $to));
				echo "false";
			}

          	exit();
    	    break;
	}

?>
