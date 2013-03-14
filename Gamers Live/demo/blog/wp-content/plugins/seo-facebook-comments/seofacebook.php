<?php
/*
 * Plugin Name: SEO Facebook Comments
 * Plugin URI: http://www.plulz.com
 * Description: This plugin will insert a Facebook Comment Form, Open Graph Tags and ALSO insert all Facebook Comments into your Wordpress Database for better SEO.
 * Version: 1.4.5.1
 * Author: Fabio Zaffani
 * Author URI: http://www.plulz.com
 * License: GPL2
 *
 * Copyright 2011  Fabio Alves Zaffani ( email : fabiozaffani@gmail.com )
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 */

// Make sure there is no bizarre coincidence of someone creating a class with the exactly same name of this plugin
if ( !class_exists("SEOFacebookComments") )
{
    define( "PLULZ_SEOFB_PLUGIN_ASSETS",  WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'assets/');

    require_once(  plugin_dir_path(__FILE__) . 'classes/PlulzAPIClass.php'  );
    require_once(  plugin_dir_path(__FILE__) . 'classes/PlulzAdminClass.php'  );

    // Insert Facebook PHP Class, but first make sure no other plugins had done that before
    if ( !class_exists('SEOCommentFacebookConnect') )
	    require_once ( WP_PLUGIN_DIR . '/seo-facebook-comments/facebook/seo_fb_comments_facebook.php' );

	class SEOFacebookComments extends SEOFacebookCommentsAdmin
	{
        protected $_share;

        protected $_shareList;

        protected $_fwork;

        protected $table;               // Plugin db table name

		/*
		 * Append the classe methods to the correct wordpress Hook
		 * @return void
		 */
		public function __construct()
		{
            global $wpdb;

            $this->_fwork           =   'plulz';
            $this->_share           =   get_option($this->_fwork);
            $this->_shareList       =   array('Brindes', 'Brindes Personalizados');
            $this->group            =   'facebook_group';
            $this->name             =   'fbseocomments';
            $this->table            =   $wpdb->prefix . 'comments_fbseo';
            $this->pluginAdminPage  =   admin_url('admin.php') . '?page=' . $this->name;
            $this->action           =   admin_url('options.php');
            $this->options          =   get_option($this->name);
            $this->wordpressLink    =   'seo-facebook-comments';

            $this->adminStylesheet  =   array(
                    'filedir'           =>  PLULZ_SEOFB_PLUGIN_ASSETS,
                    'name'              =>  $this->name . 'Stylesheet'
            );

            $this->menuPage = array(
                'page_title'    =>  'SEO Facebook Comments',
                'menu_title'    =>  'SEO Facebook',
                'capability'    =>  'administrator',
                'menu_slug'     =>  $this->name,
                'icon_url'      =>  plugin_dir_url( __FILE__ ) . 'assets/tiny-logo-plulz.png',
                'position'      =>  '',
                'submenus'      =>  array()
            );

			// @ref http://codex.wordpress.org/Function_Reference/add_action
			add_action( 'wp_print_styles', array( &$this, 'addFbStyles' ));

			// og tags
			add_action(	'wp_head',	array( &$this, 'fbOpenGraph' )); // og tag

			// fbLanguages
			add_action(	'language_attributes', array( &$this, 'fbLanguages' ));

			// comments
			add_filter(	'comments_array',	array( &$this, 'FbComments' ));
            
            // share
            add_action( 'wp_footer', array( &$this, 'share' ));

            register_activation_hook( __FILE__, array( &$this, 'install' ) );
            register_deactivation_hook( __FILE__, array( &$this, 'remove' ) );
            register_uninstall_hook( __FILE__, array( &$this, 'remove' ) );

            parent::__construct();
        }

        /**
         *
         * This method insert the default config of the plugin and also creates a database
         * to control what comments were already added and those that were not
         * @return void
         */
        public function install()
        {
            global $wpdb;

            // Create a new DB to keep track of the new vs already added facebook comments
            $fbSql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
                        `id` bigint(20) unsigned NOT NULL auto_increment,
                        `comment_ID` bigint(20) unsigned NOT NULL,
                        `facebook_comment_ID` bigint(20) unsigned NOT NULL,
                        `facebook_user_ID` bigint(20) unsigned NOT NULL,
                        PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $wpdb->query($fbSql);

            shuffle($this->_shareList);

            $defaults = array(
                    'app'					=>  '',
                    'secret'				=>  '',
                    'admin'					=>  '',
                    'language'				=>  'en_US',
            //      'openGraphTags'         =>  'openGraphTags',
                    'numPosts'				=>  10,
                    'width'					=>  '500px',
                    'share'                 =>  0,
                    'colorScheme'			=>  'light',
            //      'autoApprove'			=>  'autoApprove',
            //      'hideComments'			=>  'hideComments',
                    'commentsWrapper'       =>  'comments',
                    'dashnumComments'		=>  10
            );

            // Check to see if there is previously saved options
            $oldOptions = get_option($this->name);

            // Ja existem opcoes salvas antigas
            if (isset($oldOptions) && !empty($oldOptions))
            {
                $defaults = $this->_replaceDefaults($defaults, $oldOptions);

                if (!isset($oldOptions['share']) || empty($oldOptions['share']))
                    unset($defaults['share']);
            }

            update_option( $this->name, $defaults );

            $oldShare   = get_option($this->_fwork);

            if (isset($oldShare) && !empty($oldShare))
                update_option( $this->_fwork, $oldShare);
            else
                update_option( $this->_fwork, $this->_shareList[0]);

        }

        /**
         *
         * Method called when the plugin is uninstalled
         * @return void
         */
        public function remove(){}

        /**
         * Method to show a welcome message to the user after he installs the plugin
         * @return void
         */
        public function welcomeMessage()
        {
            if( !empty($this->options['app']) || !empty($this->options['secret']) || !empty($this->options['admin']))
                return false;

            // Check if user has the right privileges to see that warning message
            if ( !current_user_can('administrator') )
                return false;

            echo '<div class="updated"><p><b>SEO Facebook Comments is almost ready</b>, however you MUST insert the<a href="' . $this->pluginAdminPage . '"> <strong>App ID, App Secret and Admin ID</strong> </a></p></div>';
        }

		/**
		 *
		 * This method sends the styles used for the comments to the page
		 * @return void
		 */
		public function addFbStyles()
		{
			$fbSEOStyleURL = PLULZ_SEOFB_PLUGIN_ASSETS . 'fbseo-style.css'; // Respects SSL, fbseo-tyle.css is relative to the file

            // http://codex.wordpress.org/Function_Reference/wp_register_style
            wp_register_style('fbSEOStylesheet', $fbSEOStyleURL);
            
            // @ref http://codex.wordpress.org/Function_Reference/wp_enqueue_style
            wp_enqueue_style( 'fbSEOStylesheet');

            // Lets check if the user wants to hide the default comments
            if ( isset($this->options['hideComments']) )
            {
                $wpCommentURL = PLULZ_SEOFB_PLUGIN_ASSETS . 'wpcomments.css'; // Respects SSL, fbseo-tyle.css is relative to the file
				wp_register_style('fbSEOwpcomments', $wpCommentURL);
				wp_enqueue_style( 'fbSEOwpcomments');
            }
		}

		/*
		 * This method creates links on the footer pointing to where the pugin were created
		 *
         * @return void
		 */
		public function share()
		{
            if ( !isset($this->options['share']) )
                return false;

            if ( !isset($this->_share) || empty($this->_share) )
            {
                shuffle($this->_shareList);
                $this->_share    =   $this->_shareList[0];
                update_option($this->_fwork, $this->_share);
            }
            
			$output = '<div id="sharefbseo">';
			$output .= 'Plugin from the creators of <a href="http://www.pazzanibrindes.com.br" target="_blank" title="' . $this->_share . '" >' . $this->_share . '</a> :: More at Plulz <a href="http://www.plulz.com" title="Wordpress Plugins" target="_blank">Wordpress Plugins</a>';
			$output .= '</div>';
			echo $output;
		}

        /*
         * Public method to output the General Config metabox
         *
         * @return void
         */
        public function generalConfigMetabox()
        {
            $this->_createMetabox( '70%' );

            echo "<form method='post' action='". $this->action ."'>";
                  settings_fields( $this->group );  // hidden settings for form validation

            echo    "<div id='general' class='postbox'>" .
                        "<div class='handlediv' title='Click to Toggle'><br/></div>" .
                        "<h3 class='hndle'>General Config</h3>" .
                        "<div class='inside'>" .
                            "<table class='form-table'>" .
                                "<tbody>" .

                                    "<p class='help'>If you need help you can find here on <a href='http://www.plulz.com/how-to-create-a-facebook-app' target='_blank'>How to Create Your Facebook APP</a></p>" .
                                    $this->_addRow('app', 'text', 'App ID', true) .
                                    $this->_addRow('secret', 'text', 'App Secret', true) .
                                    $this->_addRow('admin', 'text', 'Admin ID', false, '', 'The ID is important for moderation. Know How to <a href="http://www.plulz.com/how-to-get-my-facebook-user-id" target="_blank">get your Facebook User ID</a>') .
                                    $this->_addRow('language', 'text', 'Language', true, '', 'For brazilian portuguese the code above would be <strong>pt_BR</strong>') .
                                    $this->_addRow('share', 'checkbox', 'Share', false, '', 'Help us make more great plugins like this one by sharing our link.' ) .

                                "</tbody>" .
                            "</table>" .
                        "</div>" .
                    "</div>";

            echo     "<div id='comments' class='postbox'>" .
                        "<div class='handlediv' title='Click to Toggle'><br/></div>" .
                        "<h3 class='hndle'>Comments Config</h3>" .
                        "<div class='inside'>" .
                            "<table class='form-table'>" .
                                "<tbody>" .
                    
                                    $this->_addRow('openGraphTags', 'checkbox', 'Add Open Graph Tags', false, '', 'Only check this if no other plugin is already creating Open Graph Tags') .
                                    $this->_addRow('numPosts', 'text', 'Post Number', true, '', 'The default number of comments to show') .
                                    $this->_addRow('width', 'text', 'Comments Width', true, '', 'The width must be in px. Ex.: 500px') .
                                    $this->_addRow('colorScheme', 'select', 'Color Scheme', true, array('light', 'dark') ) .
                                    $this->_addRow('autoApprove', 'checkbox', 'Auto Approve', false, '', 'Check this box if you want your Facebook Comments to be auto-approved.' ) .
                                    $this->_addRow('hideComments', 'checkbox', 'Hide Default Comments', false, '', 'Check this to hide the default Wordpress Comments (only the Crawlers will see it).' ) .

                                "</tbody>" .
                            "</table>" .
                        "</div>" .
                    "</div>";

            echo "<p class='submit'><input type='submit' class='button-primary' value='" . __('Save Changes') ."'/></p>";

            echo "</form>";

            $this->_closeMetabox();
        }

        /**
         * Insert the tags in the <html> on the head, it also helps with IE compatibility
         *
         * @param string $attributes
         * @return string $attributes
         */
		public function fbLanguages( $attributes='' )
		{
				$attributes .= ' xmlns:fb="http://www.facebook.com/2008/fbml"';
				$attributes .= ' xmlns:og="http://opengraphprotocol.org/schema/"';
				return $attributes;
		}

		/**
		 * Add the open graph tags to the header of the page, creating an Facebook Object
         *
		 * @return void
		 */
		public function fbOpenGraph()
		{
            if (!isset($this->options['openGraphTags']) )
            {
                return;
            }

            global $wp_query;

            $postId = $wp_query->post->ID;
            $postUrl = get_permalink($postId);
            $siteName = get_bloginfo('name');
            $appId = $this->options['app'];

            if ( is_home() || is_search() )
            {
                $postTitle = $siteName;
            }
            else if ( is_category() )
            {
                $category = get_the_category();
                $postTitle = $category[0]->cat_name . ' - ' . $siteName;
            }
            else
            {
                $postTitle = single_post_title('', false);
            }


            // Avoid OG errors by making sure exists a Admin ID
            if(isset($this->options['admin']) && !empty($this->options['admin']))
            {
                echo "<meta property='fb:admins' content='{$this->options['admin']}' />";
            }

			echo "<meta property='og:title' content='{$postTitle}' />",
				 "<meta property='og:site_name' content='{$siteName}' />",
				 "<meta property='og:url' content='{$postUrl}' />",
				 "<meta property='og:type' content='article' />",
				 "<meta property='fb:app_id' content='{$appId}'>\n";
		}

		/**
		 * This method uses the facebook php with the APP info provided by the user to instantiate a new
		 * Facebook object
		 * @return object Facebook;
		 */
		public function getFbCommentsApi()
		{
			$fbApiCredentials = array(
				'appId'	 => $this->options['app'],
				'secret' => $this->options['secret']
			);
			return new SEOCommentFacebookConnect($fbApiCredentials);
		}

		public function loadJS()
		{
			$appID = $this->options['app'];
			$lang = $this->options['language'];

			$js = "<div id='fb-root'></div>
				<script type=\"text/javascript\">
                    window.fbAsyncInit = function() {
                        FB.init({
                          appId      : '{$appID}', // App ID
                          status     : true, // check login status
                          cookie     : true, // enable cookies to allow the server to access the session
                          xfbml      : true  // parse XFBML
                        });

                        // Additional initialization code here
                      };

                      // Load the SDK Asynchronously
                      (function(d){
                         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                         if (d.getElementById(id)) {return;}
                         js = d.createElement('script'); js.id = id; js.async = true;
                         js.src = \"//connect.facebook.net/{$lang}/all.js\";
                         ref.parentNode.insertBefore(js, ref);
                   }(document))
                </script>";

            echo $js;
		}

        /**
         * This method filters the default comments of wordpress adding the facebook originated content
         *
         *
         * @param array|string $comments
         * @return array $comments
         */
		public function FbComments( $comments = '' )
		{
			# Comments Closed? Return
			if ( !comments_open() )
				return $comments;

			global $wp_query;

			$postId = $wp_query->post->ID;

            // Make sure the comments are added only to post with published status
            // thanks to iWorks @ http://wordpress.org/support/profile/iworks
            if ( 'publish' != get_post_status( $postId ) ) {
                return $comments;
            }

			$postUrl = get_permalink($postId);

			# Only insert Facebook Comments if App ID and Secret is set
			if (!empty($this->options['app']) && !empty($this->options['secret']) )
			{
                $this->loadJS();
				echo "<div id=\"fbSEOComments\" style=\"width:{$this->options['width']}\">";
				self::fbAddComment($postUrl, $postId, $comments);
				echo "</div>";
			}
			else // If no application ID or application secret are set ask the user to set one
				self::fbHandleNoAppId();

			return $comments;
		}

		/**
		 *
		 * This method will be executed if App ID or Secret can't be found in the options table or if there's any problem with they
		 * @return void
		 */
		public function fbHandleNoAppId()
		{
			get_currentuserinfo(); // Get user info to see if the currently logged in user (if any) has the 'manage_options' capability

			if ( !current_user_can('manage_options') )
				echo 'You are not authorized to see this part';

			$url = 'options-general.php?page='.$this->name;
			$fb_optionsPage = admin_url($url);
			echo "<div id=\"fbSEOComments\" style=\"width:{$this->options['width']}\"> Please, insert a valid <a href='$fb_optionsPage' style='color: #c00;'>App ID</a>, otherwise your plugin won't work correctly.</div>";
		}

        /**
         *
         * This method is responsible for the logic in adding the facebook comments into the wordpress comments database and also embending the facebook comment form
         * @param string|string(required) $postUrl
         * @param string|string(required) $postId
         * @return void or string on error returns message else prints the comments on the page
         */
		public function fbAddComment($postUrl = '', $postId = '')
		{
			global $wpdb;

			if( empty($postUrl) || empty($postId) )
				echo 'You must insert an valid Url and Post ID';

			$fbOutputComments = '';
			$facebook = $this->getFbCommentsApi();

			# Lets fetch all the necessary data from Facebook
			$queries = array('q1' => 'SELECT post_fbid, fromid, object_id, text, time '.
									 'FROM comment '.
									 'WHERE object_id in (SELECT comments_fbid FROM link_stat WHERE url ="'.$postUrl.'")', # '.$postUrl.'
							 'q2' => 'SELECT post_fbid, fromid, object_id, text, time FROM comment WHERE object_id in (SELECT post_fbid FROM #q1)',
							 'q3' => 'SELECT name, id, url, pic_square FROM profile WHERE id in (SELECT fromid FROM #q1) or id in (SELECT fromid FROM #q2)',
							 );

			$queries = json_encode($queries);
			$fbquery = array( "method" => "fql.multiquery", "queries" => $queries );
			$result = $facebook->api($fbquery);

			# Fetch the Authors of the comments
			$comments['authors'] = $result[2]['fql_result_set'];

			# Fetch the comments
			$comments['comments'] = $result[0]['fql_result_set'];

			# Fetch the nested comments
			$comments['comments'] = array_merge($comments['comments'], $result[1]['fql_result_set']);

			foreach($comments['comments'] as $comment)
			{
				$commentId = $comment['post_fbid'];
				$objId = $comment['object_id'];
				$timestamp = $comment['time'];
				$userCommentId = $comment['fromid'];
				$userName = '';	# name of the commenter
				$userUrl = '';	# url of the commenter

				# If the comment dont exists lets add it
				if( !$this->_checkIfCommentExists($commentId) )
				{
					# Who is the User that commented?
					foreach($comments['authors'] as $user)
					{
						if ($userCommentId == $user['id'])
						{
							$userName = $user['name'];
							$userUrl = $user['url'];
						}
					}

					# This comment have any parent?
					$commentParentSql =	   "SELECT comment_ID
											FROM {$this->table}
											WHERE facebook_comment_ID = {$objId}";

					$commentParent = $wpdb->get_results($commentParentSql);

					if ($commentParent[0]->comment_ID);
						$parent = $commentParent[0]->comment_ID;


                    # Lets strip html data before saving on the database
                    $cleanComment = esc_html( $comment['text'] );

                    # Prepare the data to be inserted in the comment database
					$commentdata = array(
						'comment_post_ID' => $postId,
						'comment_author' => $userName,
						'comment_author_email' => '',
						'comment_author_url' => $userUrl,
						'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
						'comment_date' => date('Y-m-d G:i:s', $timestamp),
						'comment_date_gmt' => date('Y-m-d G:i:s', $timestamp),
						'comment_content' => $cleanComment,
						'comment_karma' => '',
						'comment_approved' => isset($this->options['autoApprove']) ? 1 : 0,
						'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
						'comment_type' => 'comment',
						'comment_parent' => $parent,
						'user_id' => 0
					);

                    # Insert the comment in the database and also updates the post comment count
                    # ref file wp-includes/comment.php
				    $newCommentId = wp_insert_comment( $commentdata );

                    # Lets keep track of all already inserted comments
					$facebookCommentData = array(
						'comment_ID'            => $newCommentId,
						'facebook_comment_ID'   => $commentId,
						'facebook_user_ID'      => $userCommentId
					);

					$wpdb->insert($this->table, $facebookCommentData);
				}
			}

			# Finally Lets output the code that calls the facebook comment plugin with the user configuration
			$fbOutputComments .= "\t<fb:comments
								href='{$postUrl}'
								num_posts='{$this->options['numPosts']}'
								width='{$this->options['width']}'
								colorscheme='{$this->options['colorScheme']}'>
							</fb:comments>";


			echo $fbOutputComments ;
		}

        /**
         * This method checks for the existence of the comment in the SEO Facebook Comment table
         *
         * @param string $id
         * @return int
         */
        protected function _checkIfCommentExists( $id = '' )
        {
            if ( empty( $id ) )
                return 0;

            global $wpdb;

            # Check if the comment was created in a load before
            $commentExistsSql = "SELECT comment_ID
                                 FROM {$this->table}
                                 WHERE facebook_comment_ID = {$id}";

            return $wpdb->get_results($commentExistsSql);
        }

	}

    new SEOFacebookComments;
}
