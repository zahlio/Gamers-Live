<?php

if ( defined( 'WP_LOAD_IMPORTERS' ) )
	return;

/** Display verbose errors */
define( 'IMPORT_DEBUG', true );

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

// include WXR file parsers
require dirname( __FILE__ ) . '/parsers.php';

/**
 * WordPress Importer class for managing the import process of a WXR file
 *
 * @package WordPress
 * @subpackage Importer
 */
if ( class_exists( 'WP_Importer' ) ) {
class TFUSE_Import extends WP_Importer {
	var $max_wxr_version = 1.1; // max. supported WXR version

	var $id; // WXR attachment ID

	// information to import from WXR file
	var $version;
	var $authors = array();
	var $posts = array();
	var $terms = array();
	var $categories = array();
	var $tags = array();
	var $base_url = '';

	// mappings from old information to new
	var $processed_authors = array();
	var $author_mapping = array();
	var $processed_terms = array();
	var $processed_posts = array();
	var $post_orphans = array();
	var $processed_menu_items = array();
	var $menu_item_orphans = array();
	var $missing_menu_items = array();

	var $fetch_attachments = false;
	var $url_remap = array();
	var $featured_images = array();

	var $tfuse_options_file;
	var $slug_prefix;
	var $dest;
	var $r = 0;

	/**
	 * Registered callback function for the WordPress Importer
	 *
	 * Manages the three separate stages of the WXR import process
	 */
	function dispatch() {
        global $prefix;
		$step = empty( $_GET['step'] ) ? 0 : (int) $_GET['step'];
		switch ( $step ) {
			case 0:
				$this->greet();
				break;
			case 1:
				check_admin_referer( 'import-upload' );
				if ( $this->handle_upload() )
					$this->import_options();
				break;
			case 2:
				echo "<br />\n";
				$this->tfuse_get_uplaod_link();
				$this->fetch_attachments = ( ! empty( $_POST['fetch_attachments'] ) && $this->allow_fetch_attachments() );
				$this->id = (int) $_POST['import_id'];
				$file = get_attached_file( $this->id );
				set_time_limit(0);
				$source = THEME_INSTALL . '/images';
				$upload_dir = wp_upload_dir();
				$this->dest = $upload_dir['basedir'];
				$dest = $upload_dir['basedir'].'/';
				//smartCopy($source, $dest);
                                $copy_media = $this->tf_install_copy($source, $dest);
                                if(is_wp_error($copy_media))
                                {
                                    echo '<div class="error">'; 
                                    echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong></p>';
                                    show_message($copy_media); 
                                    echo '</div>';
                                    break;
                                }
				$this->import( $file );
				update_option(PREFIX.'_installed', 'yes');
				break;
			case 3:
				require ( THEME_FUNCTIONS . '/install/export_options.php' );
				break;
		}

	}

	/**
	 * The main controller for the actual import stage.
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function import( $file ) {
		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

		$this->import_start( $file );

		$this->get_author_mapping();

		wp_suspend_cache_invalidation( true );
		$this->process_categories();
		$this->process_tags();
		$this->process_terms();
		$this->process_posts();
		wp_suspend_cache_invalidation( false );

		// update incorrect/missing information in the DB
		$this->backfill_parents();
		$this->backfill_attachment_urls();
		$this->remap_featured_images();

		$this->tfuse_import_options();

		$this->import_end();
	}

	/**
	 * Parses the WXR file and prepares us for the task of processing parsed data
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function import_start( $file ) {
		if ( ! is_file($file) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			echo __( 'The file does not exist, please try again.', 'wordpress-importer' ) . '</p>';
			//$this->footer();
			die();
		}

		$import_data = $this->parse( $file );

		if ( is_wp_error( $import_data ) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			echo esc_html( $import_data->get_error_message() ) . '</p>';
			//$this->footer();
			die();
		}

		$this->version = $import_data['version'];
		$this->get_authors_from_import( $import_data );
		$this->posts = $import_data['posts'];
		$this->terms = $import_data['terms'];
		$this->categories = $import_data['categories'];
		$this->tags = $import_data['tags'];
		$this->base_url = esc_url( $import_data['base_url'] );

		wp_defer_term_counting( true );
		wp_defer_comment_counting( true );

		do_action( 'import_start' );
	}

	/**
	 * Performs post-import cleanup of files and the cache
	 */
	function import_end() {
		wp_import_cleanup( $this->id );

		wp_cache_flush();
		foreach ( get_taxonomies() as $tax ) {
			delete_option( "{$tax}_children" );
			_get_term_hierarchy( $tax );
		}

		wp_defer_term_counting( false );
		wp_defer_comment_counting( false );

		echo '<iframe src="'.admin_url().'options-permalink.php" style="display:none"></iframe>';

		echo '<p>' . __( 'All done.', 'wordpress-importer' ) . ' <a href="' . admin_url() . '">' . __( 'Have fun!', 'wordpress-importer' ) . '</a>' . '</p>';
		echo '<p>' . __( 'Remember to update the passwords and roles of imported users.', 'wordpress-importer' ) . '</p>';

		do_action( 'import_end' );
	}

	/**
	 * Handles the WXR upload and initial parsing of the file to prepare for
	 * displaying author import options
	 *
	 * @return bool False if error uploading or invalid file, true otherwise
	 */
	function handle_upload() {
		$file = wp_import_handle_upload();

		if ( isset( $file['error'] ) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			echo esc_html( $file['error'] ) . '</p>';
			return false;
		}

		$this->id = (int) $file['id'];
		$import_data = $this->parse( $file['file'] );
		if ( is_wp_error( $import_data ) ) {
			echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
			echo esc_html( $import_data->get_error_message() ) . '</p>';
			return false;
		}

		$this->version = $import_data['version'];
		if ( $this->version > $this->max_wxr_version ) {
			echo '<div class="error"><p><strong>';
			printf( __( 'This WXR file (version %s) may not be supported by this version of the importer. Please consider updating.', 'wordpress-importer' ), esc_html($import_data['version']) );
			echo '</strong></p></div>';
		}

		$this->get_authors_from_import( $import_data );

		return true;
	}

	/**
	 * Retrieve authors from parsed WXR data
	 *
	 * Uses the provided author information from WXR 1.1 files
	 * or extracts info from each post for WXR 1.0 files
	 *
	 * @param array $import_data Data returned by a WXR parser
	 */
	function get_authors_from_import( $import_data ) {
		if ( ! empty( $import_data['authors'] ) ) {
			$this->authors = $import_data['authors'];
		// no author information, grab it from the posts
		} else {
			foreach ( $import_data['posts'] as $post ) {
				$login = sanitize_user( $post['post_author'], true );
				if ( empty( $login ) ) {
					printf( __( 'Failed to import author %s. Their posts will be attributed to the current user.', 'wordpress-importer' ), esc_html( $post['post_author'] ) );
					echo '<br />';
					continue;
				}

				if ( ! isset($this->authors[$login]) )
					$this->authors[$login] = array(
						'author_login' => $login,
						'author_display_name' => $post['post_author']
					);
			}
		}
	}

	/**
	 * Display pre-import options, author importing/mapping and option to
	 * fetch attachments
	 */
	function import_options() {
		$j = 0;
?>
<form action="<?php echo admin_url( 'admin.php?import=wordpress&amp;step=2' ); ?>" method="post">
	<?php wp_nonce_field( 'import-wordpress' ); ?>
	<input type="hidden" name="import_id" value="<?php echo $this->id; ?>" />

<?php if ( ! empty( $this->authors ) ) : ?>
	<h3><?php _e( 'Assign Authors', 'wordpress-importer' ); ?></h3>
	<p><?php _e( 'To make it easier for you to edit and save the imported content, you may want to reassign the author of the imported item to an existing user of this site. For example, you may want to import all the entries as <code>admin</code>s entries.', 'wordpress-importer' ); ?></p>
<?php if ( $this->allow_create_users() ) : ?>
	<p><?php printf( __( 'If a new user is created by WordPress, a new password will be randomly generated and the new user&#8217;s role will be set as %s. Manually changing the new user&#8217;s details will be necessary.', 'wordpress-importer' ), esc_html( get_option('default_role') ) ); ?></p>
<?php endif; ?>
	<ol id="authors">
<?php foreach ( $this->authors as $author ) : ?>
		<li><?php $this->author_select( $j++, $author ); ?></li>
<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php if ( $this->allow_fetch_attachments() ) : ?>
	<h3><?php _e( 'Import Attachments', 'wordpress-importer' ); ?></h3>
	<p>
		<input type="checkbox" value="1" name="fetch_attachments" id="import-attachments" />
		<label for="import-attachments"><?php _e( 'Download and import file attachments', 'wordpress-importer' ); ?></label>
	</p>
<?php endif; ?>

	<p class="submit"><input type="submit" class="button" value="<?php esc_attr_e( 'Submit', 'wordpress-importer' ); ?>" /></p>
</form>
<?php
	}

	/**
	 * Display import options for an individual author. That is, either create
	 * a new user based on import info or map to an existing user
	 *
	 * @param int $n Index for each author in the form
	 * @param array $author Author information, e.g. login, display name, email
	 */
	function author_select( $n, $author ) {
		_e( 'Import author:', 'wordpress-importer' );
		echo ' <strong>' . esc_html( $author['author_display_name'] );
		if ( $this->version != '1.0' ) echo ' (' . esc_html( $author['author_login'] ) . ')';
		echo '</strong><br />';

		if ( $this->version != '1.0' )
			echo '<div style="margin-left:18px">';

		$create_users = $this->allow_create_users();
		if ( $create_users ) {
			if ( $this->version != '1.0' ) {
				_e( 'or create new user with login name:', 'wordpress-importer' );
				$value = '';
			} else {
				_e( 'as a new user:', 'wordpress-importer' );
				$value = esc_attr( sanitize_user( $author['author_login'], true ) );
			}

			echo ' <input type="text" name="user_new['.$n.']" value="'. $value .'" /><br />';
		}

		if ( ! $create_users && $this->version == '1.0' )
			_e( 'assign posts to an existing user:', 'wordpress-importer' );
		else
			_e( 'or assign posts to an existing user:', 'wordpress-importer' );
		wp_dropdown_users( array( 'name' => "user_map[$n]", 'multi' => true, 'show_option_all' => __( '- Select -', 'wordpress-importer' ) ) );
		echo '<input type="hidden" name="imported_authors['.$n.']" value="' . esc_attr( $author['author_login'] ) . '" />';

		if ( $this->version != '1.0' )
			echo '</div>';
	}

	/**
	 * Map old author logins to local user IDs based on decisions made
	 * in import options form. Can map to an existing user, create a new user
	 * or falls back to the current user in case of error with either of the previous
	 */
	function get_author_mapping() {
		if ( ! isset( $_POST['imported_authors'] ) )
			return;

		$create_users = $this->allow_create_users();

		foreach ( (array) $_POST['imported_authors'] as $i => $old_login ) {
			// Multsite adds strtolower to sanitize_user. Need to sanitize here to stop breakage in process_posts.
			$santized_old_login = sanitize_user( $old_login, true );
			$old_id = isset( $this->authors[$old_login]['author_id'] ) ? intval($this->authors[$old_login]['author_id']) : false;

			if ( ! empty( $_POST['user_map'][$i] ) ) {
				$user = get_userdata( intval($_POST['user_map'][$i]) );
				if ( isset( $user->ID ) ) {
					if ( $old_id )
						$this->processed_authors[$old_id] = $user->ID;
					$this->author_mapping[$santized_old_login] = $user->ID;
				}
			} else if ( $create_users ) {
				if ( ! empty($_POST['user_new'][$i]) ) {
					$user_id = wp_create_user( $_POST['user_new'][$i], wp_generate_password() );
				} else if ( $this->version != '1.0' ) {
					$user_data = array(
						'user_login' => $old_login,
						'user_pass' => wp_generate_password(),
						'user_email' => isset( $this->authors[$old_login]['author_email'] ) ? $this->authors[$old_login]['author_email'] : '',
						'display_name' => $this->authors[$old_login]['author_display_name'],
						'first_name' => isset( $this->authors[$old_login]['author_first_name'] ) ? $this->authors[$old_login]['author_first_name'] : '',
						'last_name' => isset( $this->authors[$old_login]['author_last_name'] ) ? $this->authors[$old_login]['author_last_name'] : '',
					);
					$user_id = wp_insert_user( $user_data );
				}

				if ( ! is_wp_error( $user_id ) ) {
					if ( $old_id )
						$this->processed_authors[$old_id] = $user_id;
					$this->author_mapping[$santized_old_login] = $user_id;
				} else {
					printf( __( 'Failed to create new user for %s. Their posts will be attributed to the current user.', 'wordpress-importer' ), esc_html($this->authors[$old_login]['author_display_name']) );
					if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
						echo ' ' . $user_id->get_error_message();
					echo '<br />';
				}
			}

			// failsafe: if the user_id was invalid, default to the current user
			if ( ! isset( $this->author_mapping[$santized_old_login] ) ) {
				if ( $old_id )
					$this->processed_authors[$old_id] = (int) get_current_user_id();
				$this->author_mapping[$santized_old_login] = (int) get_current_user_id();
			}
		}
	}

	/**
	 * Create new categories based on import information
	 *
	 * Doesn't create a new category if its slug already exists
	 */
	function process_categories() {
		if ( empty( $this->categories ) )
			return;

		foreach ( $this->categories as $cat ) {
            //TFuse
            if ( $this->r ) {
                $slug_prefix = $this->slug_prefix;
                $cat['category_nicename'] = "$slug_prefix-".$cat['category_nicename'];
                $cat['category_parent'] = empty( $cat['category_parent'] ) ? 0 : "$slug_prefix-".$cat['category_parent'];
                $cat['cat_name'] = "r".$cat['cat_name'];
            }

			// if the category already exists leave it alone
			$term_id = term_exists( $cat['category_nicename'], 'category' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = (int) $term_id;
				continue;
			}

			$category_parent = empty( $cat['category_parent'] ) ? 0 : category_exists( $cat['category_parent'] );
			$category_description = isset( $cat['category_description'] ) ? $cat['category_description'] : '';
			$catarr = array(
				'category_nicename' => $cat['category_nicename'],
				'category_parent' => $category_parent,
				'cat_name' => $cat['cat_name'],
				'category_description' => $category_description
			);

			$id = wp_insert_category( $catarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = $id;
			} else {
				printf( __( 'Failed to import category %s', 'wordpress-importer' ), esc_html($cat['category_nicename']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}
		}

		unset( $this->categories );
	}

	/**
	 * Create new post tags based on import information
	 *
	 * Doesn't create a tag if its slug already exists
	 */
	function process_tags() {
		if ( empty( $this->tags ) )
			return;

		foreach ( $this->tags as $tag ) {
			// if the tag already exists leave it alone
			$term_id = term_exists( $tag['tag_slug'], 'post_tag' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = (int) $term_id;
				continue;
			}

			$tag_desc = isset( $tag['tag_description'] ) ? $tag['tag_description'] : '';
			$tagarr = array( 'slug' => $tag['tag_slug'], 'description' => $tag_desc );

			$id = wp_insert_term( $tag['tag_name'], 'post_tag', $tagarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import post tag %s', 'wordpress-importer' ), esc_html($tag['tag_name']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}
		}

		unset( $this->tags );
	}

	/**
	 * Create new terms based on import information
	 *
	 * Doesn't create a term its slug already exists
	 */
	function process_terms() {
		if ( empty( $this->terms ) )
			return;

		foreach ( $this->terms as $term ) {
			// if the term already exists in the correct taxonomy leave it alone
			$term_id = term_exists( $term['slug'], $term['term_taxonomy'] );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = (int) $term_id;
				continue;
			}

			if ( empty( $term['term_parent'] ) ) {
				$parent = 0;
			} else {
				$parent = term_exists( $term['term_parent'], $term['term_taxonomy'] );
				if ( is_array( $parent ) ) $parent = $parent['term_id'];
			}
			$description = isset( $term['term_description'] ) ? $term['term_description'] : '';
			$termarr = array( 'slug' => $term['slug'], 'description' => $description, 'parent' => intval($parent) );

			$id = wp_insert_term( $term['term_name'], $term['term_taxonomy'], $termarr );
			if ( ! is_wp_error( $id ) ) {
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import %s %s', 'wordpress-importer' ), esc_html($term['term_taxonomy']), esc_html($term['term_name']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}
		}

		unset( $this->terms );
	}

	/**
	 * Create new posts based on import information
	 *
	 * Posts marked as having a parent which doesn't exist will become top level items.
	 * Doesn't create a new post if: the post type doesn't exist, the given post ID
	 * is already noted as imported or a post with the same title and date already exists.
	 * Note that new/updated terms, comments and meta are imported for the last of the above.
	 */
	function process_posts() {
		foreach ( $this->posts as $post ) {
			if ( ! post_type_exists( $post['post_type'] ) ) {
				printf( __( 'Failed to import &#8220;%s&#8221;: Invalid post type %s', 'wordpress-importer' ),
					esc_html($post['post_title']), esc_html($post['post_type']) );
				echo '<br />';
				continue;
			}

			if ( isset( $this->processed_posts[$post['post_id']] ) && ! empty( $post['post_id'] ) )
				continue;

			if ( $post['status'] == 'auto-draft' )
				continue;

			if ( 'nav_menu_item' == $post['post_type'] ) {
				$this->process_menu_item( $post );
				continue;
			}

			//TFuse
			if ( $this->r ) {
				$slug_prefix = $this->slug_prefix;
				$post['post_title'] = 'r'.$post['post_title'];
				$post['post_name'] = "$slug_prefix-".$post['post_name'];
			}

			// TFuse, reset permalink for posts and pages
			if( 'post' == $post['post_type'] || 'page' == $post['post_type'] || 'attachment' == $post['post_type'] ) $post['guid'] = '';


			$post_type_object = get_post_type_object( $post['post_type'] );

			$post_exists = post_exists( $post['post_title'], '', $post['post_date'] );
			if ( $post_exists ) {
				printf( __('%s &#8220;%s&#8221; already exists.', 'wordpress-importer'), $post_type_object->labels->singular_name, esc_html($post['post_title']) );
				echo '<br />';
				$comment_post_ID = $post_id = $post_exists;
			} else {
				$post_parent = (int) $post['post_parent'];
				if ( $post_parent ) {
					// if we already know the parent, map it to the new local ID
					if ( isset( $this->processed_posts[$post_parent] ) ) {
						$post_parent = $this->processed_posts[$post_parent];
					// otherwise record the parent for later
					} else {
						$this->post_orphans[intval($post['post_id'])] = $post_parent;
						$post_parent = 0;
					}
				}

				// map the post author
				$author = sanitize_user( $post['post_author'], true );
				if ( isset( $this->author_mapping[$author] ) )
					$author = $this->author_mapping[$author];
				else
					$author = (int) get_current_user_id();

				// TFuse
				$post['post_content'] = $this->tfuse_remap_urls($post['post_content']);
				$post['post_excerpt'] = $this->tfuse_remap_urls($post['post_excerpt']);

				$postdata = array(
					'import_id' => $post['post_id'], 'post_author' => $author, 'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'], 'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'], 'post_title' => $post['post_title'],
					'post_status' => $post['status'], 'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'],
					'guid' => $post['guid'], 'post_parent' => $post_parent, 'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'], 'post_password' => $post['post_password']
				);

				if ( 'attachment' == $postdata['post_type'] ) {
					$remote_url = ! empty($post['attachment_url']) ? $post['attachment_url'] : $post['guid'];

					// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
					// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
					$postdata['upload_date'] = $post['post_date'];
					if ( isset( $post['postmeta'] ) ) {
						foreach( $post['postmeta'] as $meta ) {
							if ( $meta['key'] == '_wp_attached_file' ) {
								if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) )
									$postdata['upload_date'] = $matches[0];
								break;
							}
						}
					}

					$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url );
				} else {
					$comment_post_ID = $post_id = wp_insert_post( $postdata, true );
				}

				if ( is_wp_error( $post_id ) ) {
					printf( __( 'Failed to import %s &#8220;%s&#8221;', 'wordpress-importer' ),
						$post_type_object->labels->singular_name, esc_html($post['post_title']) );
					if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
						echo ': ' . $post_id->get_error_message();
					echo '<br />';
					continue;
				}

				if ( $post['is_sticky'] == 1 )
					stick_post( $post_id );
			}

			// map pre-import ID to local ID
			$this->processed_posts[intval($post['post_id'])] = (int) $post_id;

			// add categories, tags and other terms
			if ( ! empty( $post['terms'] ) ) {
				$terms_to_set = array();
				foreach ( $post['terms'] as $term ) {
					// back compat with WXR 1.0 map 'tag' to 'post_tag'
					$taxonomy = ( 'tag' == $term['domain'] ) ? 'post_tag' : $term['domain'];

					//TFuse
					if ( $this->r && 'category' == $term['domain'] ) {
						$slug_prefix  = $this->slug_prefix;
						$term['slug'] = "$slug_prefix-".$term['slug'];
						$term['name'] = 'r'.$term['name'];
					}

					$term_exists = term_exists( $term['slug'], $taxonomy );
					$term_id = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
					if ( ! $term_id ) {
						$t = wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'] ) );
						if ( ! is_wp_error( $t ) ) {
							$term_id = $t['term_id'];
						} else {
							printf( __( 'Failed to import %s %s', 'wordpress-importer' ), esc_html($taxonomy), esc_html($term['name']) );
							if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
								echo ': ' . $t->get_error_message();
							echo '<br />';
							continue;
						}
					}
					$terms_to_set[$taxonomy][] = intval( $term_id );
				}

				foreach ( $terms_to_set as $tax => $ids ) {
					$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
				}
				unset( $post['terms'], $terms_to_set );
			}

			// add/update comments
			if ( ! empty( $post['comments'] ) ) {
				$num_comments = 0;
				$inserted_comments = array();
				foreach ( $post['comments'] as $comment ) {
					$comment_id	= $comment['comment_id'];
					$newcomments[$comment_id]['comment_post_ID']      = $comment_post_ID;
					$newcomments[$comment_id]['comment_author']       = $comment['comment_author'];
					$newcomments[$comment_id]['comment_author_email'] = $comment['comment_author_email'];
					$newcomments[$comment_id]['comment_author_IP']    = $comment['comment_author_IP'];
					$newcomments[$comment_id]['comment_author_url']   = $comment['comment_author_url'];
					$newcomments[$comment_id]['comment_date']         = $comment['comment_date'];
					$newcomments[$comment_id]['comment_date_gmt']     = $comment['comment_date_gmt'];
					$newcomments[$comment_id]['comment_content']      = $comment['comment_content'];
					$newcomments[$comment_id]['comment_approved']     = $comment['comment_approved'];
					$newcomments[$comment_id]['comment_type']         = $comment['comment_type'];
					$newcomments[$comment_id]['comment_parent'] 	  = $comment['comment_parent'];
					$newcomments[$comment_id]['commentmeta']          = isset( $comment['commentmeta'] ) ? $comment['commentmeta'] : array();
					if ( isset( $this->processed_authors[$comment['comment_user_id']] ) )
						$newcomments[$comment_id]['user_id'] = $this->processed_authors[$comment['comment_user_id']];
				}
				ksort( $newcomments );

				foreach ( $newcomments as $key => $comment ) {
					// if this is a new post we can skip the comment_exists() check
					if ( ! $post_exists || ! comment_exists( $comment['comment_author'], $comment['comment_date'] ) ) {
						if ( isset( $inserted_comments[$comment['comment_parent']] ) )
							$comment['comment_parent'] = $inserted_comments[$comment['comment_parent']];
						$comment = wp_filter_comment( $comment );
						$inserted_comments[$key] = wp_insert_comment( $comment );

						foreach( $comment['commentmeta'] as $meta ) {
							$value = maybe_unserialize( $meta['value'] );
							add_comment_meta( $inserted_comments[$key], $meta['key'], $value );
						}

						$num_comments++;
					}
				}
				unset( $newcomments, $inserted_comments, $post['comments'] );
			}

			// add/update post meta
			if ( isset( $post['postmeta'] ) ) {
				foreach ( $post['postmeta'] as $meta ) {
					$key = apply_filters( 'import_post_meta_key', $meta['key'] );
					$value = false;

					if ( '_edit_last' == $key ) {
						if ( isset( $this->processed_authors[intval($meta['value'])] ) )
							$value = $this->processed_authors[intval($meta['value'])];
						else
							$key = false;
					}

					if ( $key ) {
						// export gets meta straight from the DB so could have a serialized string
						if ( ! $value )
							$value = maybe_unserialize( $meta['value'] );

						// TFuse
						$value = $this->tfuse_remap_urls($value);

						add_post_meta( $post_id, $key, $value );
						do_action( 'import_post_meta', $post_id, $key, $value );

						// if the post has a featured image, take note of this in case of remap
						if ( '_thumbnail_id' == $key )
							$this->featured_images[$post_id] = (int) $value;
					}
				}
			}
		}

		unset( $this->posts );
	}

	/**
	 * Attempt to create a new menu item from import data
	 *
	 * Fails for draft, orphaned menu items and those without an associated nav_menu
	 * or an invalid nav_menu term. If the post type or term object which the menu item
	 * represents doesn't exist then the menu item will not be imported (waits until the
	 * end of the import to retry again before discarding).
	 *
	 * @param array $item Menu item details from WXR file
	 */
	function process_menu_item( $item ) {
		// skip draft, orphaned menu items
		if ( 'draft' == $item['status'] )
			return;

		$menu_slug = false;
		if ( isset($item['terms']) ) {
			// loop through terms, assume first nav_menu term is correct menu
			foreach ( $item['terms'] as $term ) {
				if ( 'nav_menu' == $term['domain'] ) {
					$menu_slug = $term['slug'];
					break;
				}
			}
		}

		// no nav_menu term associated with this menu item
		if ( ! $menu_slug ) {
			_e( 'Menu item skipped due to missing menu slug', 'wordpress-importer' );
			echo '<br />';
			return;
		}

		$menu_id = term_exists( $menu_slug, 'nav_menu' );
		if ( ! $menu_id ) {
			printf( __( 'Menu item skipped due to invalid menu slug: %s', 'wordpress-importer' ), esc_html( $menu_slug ) );
			echo '<br />';
			return;
		} else {
			$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
		}

		foreach ( $item['postmeta'] as $meta )
			$$meta['key'] = $meta['value'];

		if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[intval($_menu_item_object_id)] ) ) {
			$_menu_item_object_id = $this->processed_terms[intval($_menu_item_object_id)];
		} else if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[intval($_menu_item_object_id)] ) ) {
			$_menu_item_object_id = $this->processed_posts[intval($_menu_item_object_id)];
		} else if ( 'custom' != $_menu_item_type ) {
			// associated object is missing or not imported yet, we'll retry later
			$this->missing_menu_items[] = $item;
			return;
		}

		if ( isset( $this->processed_menu_items[intval($_menu_item_menu_item_parent)] ) ) {
			$_menu_item_menu_item_parent = $this->processed_menu_items[intval($_menu_item_menu_item_parent)];
		} else if ( $_menu_item_menu_item_parent ) {
			$this->menu_item_orphans[intval($item['post_id'])] = (int) $_menu_item_menu_item_parent;
			$_menu_item_menu_item_parent = 0;
		}

		// wp_update_nav_menu_item expects CSS classes as a space separated string
		$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
		if ( is_array( $_menu_item_classes ) )
			$_menu_item_classes = implode( ' ', $_menu_item_classes );

		$args = array(
			'menu-item-object-id' => $_menu_item_object_id,
			'menu-item-object' => $_menu_item_object,
			'menu-item-parent-id' => $_menu_item_menu_item_parent,
			'menu-item-position' => intval( $item['menu_order'] ),
			'menu-item-type' => $_menu_item_type,
			'menu-item-title' => $item['post_title'],
			'menu-item-url' => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title' => $item['post_excerpt'],
			'menu-item-target' => $_menu_item_target,
			'menu-item-classes' => $_menu_item_classes,
			'menu-item-xfn' => $_menu_item_xfn,
			'menu-item-status' => $item['status']
		);

		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( $id && ! is_wp_error( $id ) )
			$this->processed_menu_items[intval($item['post_id'])] = (int) $id;
	}

	/**
	 * If fetching attachments is enabled then attempt to create a new attachment
	 *
	 * @param array $post Attachment post details from WXR
	 * @param string $url URL to fetch attachment from
	 * @return int|WP_Error Post ID on success, WP_Error otherwise
	 */
	function process_attachment( $post, $url ) {
		if ( ! $this->fetch_attachments )
			return new WP_Error( 'attachment_processing_error',
				__( 'Fetching attachments is not enabled', 'wordpress-importer' ) );

		$giud = $post['guid'];

		// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
		if ( preg_match( '|^/[\w\W]+$|', $url ) )
			$url = rtrim( $this->base_url, '/' ) . $url;

		// TFuse
		$url = str_ireplace($this->upload_link_old,$this->upload_link_new,$url);
		$url = str_ireplace($this->theme_name_old,$this->theme_name_new,$url);
		$url = str_ireplace($this->base_url,get_bloginfo('url'),$url);

		// noi am copiat deja imaginile in upload .. de acea verificam daca imaginea este ...
		// nu ma iapelam functia fetch_remote_file
		if ( is_file( $upload['file'] = str_ireplace($this->upload_link_new,$this->dest,$url) ) )
		{
			$upload['url'] = $url;
		}
		else
		{
			// TFuse
			//$upload = $this->fetch_remote_file( $url, $post );
		}

		if ( is_wp_error( $upload ) )
			return $upload; 

		if ( $info = wp_check_filetype( $upload['file'] ) )
			$post['post_mime_type'] = $info['type'];
		else
			return new WP_Error( 'attachment_processing_error', __('Invalid file type', 'wordpress-importer') );

		$post['guid'] = $upload['url'];

		// as per wp-admin/includes/upload.php
		$post_id = wp_insert_attachment( $post, $upload['file'] );
		wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

		// remap resized image URLs, works by stripping the extension and remapping the URL stub.
		if ( preg_match( '!^image/!', $info['type'] ) ) {
			$parts = pathinfo( $url );
			$name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

			$parts_new = pathinfo( $upload['url'] );
			$name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

			$this->url_remap[$parts['dirname'] . '/' . $name] = $parts_new['dirname'] . '/' . $name_new;
		}

		return $post_id;
	}

	/**
	 * Attempt to download a remote file attachment
	 *
	 * @param string $url URL of item to fetch
	 * @param array $post Attachment details
	 * @return array|WP_Error Local file location details on success, WP_Error otherwise
	 */
	function fetch_remote_file( $url, $post ) {
		// extract the file name and extension from the url
		$file_name = basename( $url );

		// get placeholder file in the upload dir with a unique, sanitized filename
		$upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );
		if ( $upload['error'] )
			return new WP_Error( 'upload_dir_error', $upload['error'] );

		// fetch the remote url and write it to the placeholder file
		$headers = wp_get_http( $url, $upload['file'] );

		// request failed
		if ( ! $headers ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Remote server did not respond', 'wordpress-importer') );
		}

		// make sure the fetch was successful
		if ( $headers['response'] != '200' ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', sprintf( __('Remote server returned error response %1$d %2$s', 'wordpress-importer'), esc_html($headers['response']), get_status_header_desc($headers['response']) ) );
		}

		$filesize = filesize( $upload['file'] );

		if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Remote file is incorrect size', 'wordpress-importer') );
		}

		if ( 0 == $filesize ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', __('Zero size file downloaded', 'wordpress-importer') );
		}

		$max_size = (int) $this->max_attachment_size();
		if ( ! empty( $max_size ) && $filesize > $max_size ) {
			@unlink( $upload['file'] );
			return new WP_Error( 'import_file_error', sprintf(__('Remote file is too large, limit is %s', 'wordpress-importer'), size_format($max_size) ) );
		}

		// keep track of the old and new urls so we can substitute them later
		$this->url_remap[$url] = $upload['url'];
		$this->url_remap[$post['guid']] = $upload['url']; // r13735, really needed?
		// keep track of the destination if the remote url is redirected somewhere else
		if ( isset($headers['x-final-location']) && $headers['x-final-location'] != $url )
			$this->url_remap[$headers['x-final-location']] = $upload['url'];

		return $upload;
	}

	/**
	 * Attempt to associate posts and menu items with previously missing parents
	 *
	 * An imported post's parent may not have been imported when it was first created
	 * so try again. Similarly for child menu items and menu items which were missing
	 * the object (e.g. post) they represent in the menu
	 */
	function backfill_parents() {
		global $wpdb;

		// find parents for post orphans
		foreach ( $this->post_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = false;
			if ( isset( $this->processed_posts[$child_id] ) )
				$local_child_id = $this->processed_posts[$child_id];
			if ( isset( $this->processed_posts[$parent_id] ) )
				$local_parent_id = $this->processed_posts[$parent_id];

			if ( $local_child_id && $local_parent_id )
				$wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
		}

		// all other posts/terms are imported, retry menu items with missing associated object
		$missing_menu_items = $this->missing_menu_items;
		foreach ( $missing_menu_items as $item )
			$this->process_menu_item( $item );

		// find parents for menu item orphans
		foreach ( $this->menu_item_orphans as $child_id => $parent_id ) {
			$local_child_id = $local_parent_id = 0;
			if ( isset( $this->processed_menu_items[$child_id] ) )
				$local_child_id = $this->processed_menu_items[$child_id];
			if ( isset( $this->processed_menu_items[$parent_id] ) )
				$local_parent_id = $this->processed_menu_items[$parent_id];

			if ( $local_child_id && $local_parent_id )
				update_post_meta( $local_child_id, '_menu_item_menu_item_parent', (int) $local_parent_id );
		}
	}

	/**
	 * Use stored mapping information to update old attachment URLs
	 */
	function backfill_attachment_urls() {
		global $wpdb;
		// make sure we do the longest urls first, in case one is a substring of another
		uksort( $this->url_remap, array(&$this, 'cmpr_strlen') );

		foreach ( $this->url_remap as $from_url => $to_url ) {
			// remap urls in post_content
			$wpdb->query( $wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url) );
			// remap enclosure urls
			$result = $wpdb->query( $wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url) );
		}
	}

	/**
	 * Update _thumbnail_id meta to new, imported attachment IDs
	 */
	function remap_featured_images() {
		// cycle through posts that have a featured image
		foreach ( $this->featured_images as $post_id => $value ) {
			if ( isset( $this->processed_posts[$value] ) ) {
				$new_id = $this->processed_posts[$value];
				// only update if there's a difference
				if ( $new_id != $value )
					update_post_meta( $post_id, '_thumbnail_id', $new_id );
			}
		}
	}

	//TFuse import options
	function tfuse_import_options() {

		$slug_prefix = $this->slug_prefix;
		$import_optionsArr = array();
		$file = $this->tfuse_options_file;

		preg_match_all('|<item>(.*?)</item>|is', $file, $imported_entries);

		$k = 0;
		foreach ($imported_entries[1] as $lines) {
			$k++; $line = $lines;

			preg_match('|<name>(.*?)</name>|is', $line, $name);
			if(!isset($name[1])) $name[1] = '';
			$import_optionsArr[$k]['name']		= $name[1];

			preg_match('|<value>(.*?)</value>|is', $line, $value);
			if(!isset($value[1])) $value[1] = '';
			$import_optionsArr[$k]['value']		= $value[1];

			preg_match('|<option>(.*?)</option>|is', $line, $option);
			if(!isset($option[1])) $option[1] = '';
			$import_optionsArr[$k]['option']	= $option[1];

			preg_match('|<slug>(.*?)</slug>|is', $line, $slug);
			if(!isset($slug[1])) $slug[1] = '';
			$import_optionsArr[$k]['slug']    	= $slug[1];

			preg_match('|<type>(.*?)</type>|is', $line, $type);
			if(!isset($type[1])) $type[1] = '';
			$import_optionsArr[$k]['type']    	= $type[1];
		}

		//inseram in BD optiunile importate
		foreach($import_optionsArr as $option) {

			if($option['name'] == 'upload_link') {
				continue;
			} else if($option['type'] == 'multicheck') {

				if($option['option'] == 'cat') {
					$old_cat_id		 = end(explode('_',$option['name']));
					$new_cat_id		 = $this->processed_terms[intval($old_cat_id)];
					$cat_id_name 	 = substr($option['name'],0,strrpos($option['name'], "_"));
					$option['name']  = $cat_id_name.'_'.$new_cat_id;
				}

				if($option['option'] == 'pag') {
					//$post_ID 		 = substr($option['name'],strrpos($option['name'], "_")+1);
					$old_pag_id		 = end(explode('_',$option['name']));
					$new_pag_id		 = $this->processed_posts[intval($old_pag_id)];
					$pag_id_name 	 = substr($option['name'],0,strrpos($option['name'], "_"));
					$option['name']  = $pag_id_name.'_'.$new_pag_id;
				}

			} else if ($option['type'] == 'multi') {

				if($option['option'] == 'cat') {
					$old_cat_id      = substr($option['value'],4);
					$new_cat_id      = $this->processed_terms[intval($old_cat_id)];
					$option['value'] = 'cat_'.$new_cat_id;
				}

				if($option['option'] == 'pag' ) {
					$old_pag_id	 = substr($option['value'],4);
					$new_pag_id     = $this->processed_posts[intval($old_pag_id)];
					$option['value'] = 'pag_'.$new_pag_id;
				}

				if($option['option'] == 'pos') {
					$old_post_id	 = substr($option['value'],4);
					$new_post_id     = $this->processed_posts[intval($old_post_id)];
					$option['value'] = 'pos_'.$new_post_id;
				}

			} else if ($option['type'] == 'slider') {

				if($option['option'] == 'cat') {
					$new_cat_ids = array();
					$old_cat_ids = explode(',',$option['value']);
					foreach ($old_cat_ids as $old_cat_id) {
						$new_cat_ids[]  = $this->processed_terms[intval($old_cat_id)];
					}
					$option['value'] = implode(',',$new_cat_ids);
				}

				if($option['option'] == 'array') {
					$option['value'] = unpk($option['value']);
					if(empty($option['value'])) $option['value'] = array();
					$option['value'] = $this->tfuse_remap_urls($option['value']);
				}

			} else if ($option['type'] == 'category') {

					$old_cat_id		 = end(explode('_',$option['name']));
					$new_cat_id		 = $this->processed_terms[intval($old_cat_id)];
					$cat_id_name 	 = substr($option['name'],0,strrpos($option['name'], "_"));
					$option['name']  = $cat_id_name.'_'.$new_cat_id;

					// If the URL is absolute, but does not contain http, upload it assuming the base_site_url variable
					if (preg_match('/^\/[\w\W]+$/', $option['value']) )
						$option['value'] = rtrim($this->base_url,'/').$option['value'];

					$option['value'] = str_ireplace($this->upload_link_old,$this->upload_link_new,$option['value']);
					$option['value'] = str_ireplace($this->theme_name_old,$this->theme_name_new,$option['value']);
					$option['value'] = str_ireplace($this->base_url,get_bloginfo('url'),$option['value']);


			} else if ($option['type'] == 'category_multicheck') {
					$cat_id_name     = substr($option['name'],0,strrpos($option['name'], "_"));
					$old_cat_id      = end(explode('_',$cat_id_name));
					$new_cat_id      = $this->processed_terms[intval($old_cat_id)];
					$cat_id_name2    = substr($cat_id_name,0,strrpos($cat_id_name, "_"));
					$cat_param       = explode("_",str_replace($cat_id_name."_",'',$option['name']));
					$cat_param       = $cat_param[0];
					$option['name']  = $cat_id_name2.'_'.$new_cat_id.'_'.$cat_param;

			} else if ($option['type'] == 'testimonials') {

					$option['value'] = unpk($option['value']);
					if(empty($option['value'])) $option['value'] = array();
					$option['value'] = $this->tfuse_remap_urls($option['value']);

			} else if ($option['type'] == 'widget') {

					$option['value'] = unpk($option['value']);
					if(empty($option['value'])) $option['value'] = array();
					$option['value'] = $this->tfuse_remap_urls($option['value']);

			} else if ($option['type'] == 'nav_opt') {

					$current_template = get_stylesheet();
					$option['name'] = "theme_mods_{$current_template}";
					$nav_menu_locations = unpk($option['value']);
					foreach($nav_menu_locations['nav_menu_locations'] as $arrid => $key) {
					$menu_id = $this->processed_terms[intval($key)];
						$nav_menu_locations['nav_menu_locations'][$arrid] = $menu_id;
					}
					$option['value'] = $nav_menu_locations;
					if(empty($option['value'])) $option['value'] = array();

			} else {

				if($option['option'] == 'cat') {
					$old_cat_id      = $option['value'];
					$new_cat_id      = $this->processed_terms[intval($old_cat_id)];
					$option['value'] = $new_cat_id;
				}

				if($option['option'] == 'pag' && $option['value']!=0) {
					$old_pag_id      = $option['value'];
					$new_pag_id      = $this->processed_posts[intval($old_pag_id)];
					$option['value'] = $new_pag_id;
				}

				// If the URL is absolute, but does not contain http, upload it assuming the base_site_url variable
				if (preg_match('/^\/[\w\W]+$/', $option['value']) && $option['name']!='permalink_structure')
					$option['value'] = rtrim($this->base_url,'/').$option['value'];

				$option['value'] = str_ireplace($this->upload_link_old,$this->upload_link_new,$option['value']);
				$option['value'] = str_ireplace($this->theme_name_old,$this->theme_name_new,$option['value']);
				$option['value'] = str_ireplace($this->base_url,get_bloginfo('url'),$option['value']);

			}

			update_option($option['name'],$option['value']);
		}
	} // END function


	/**
	 * Parse a WXR file
	 *
	 * @param string $file Path to WXR file for parsing
	 * @return array Information gathered from the WXR file
	 */
	function parse( $file ) {
		$parser = new WXR_Parser();
		return $parser->parse( $file );
	}

	function tfuse_get_uplaod_link() {
		$upload_dir = wp_upload_dir();
		$this->upload_link_new = $upload_dir['baseurl'];
		$this->theme_name_new = 'themes/'.get_template();
		$file = $this->tfuse_options_file;
		preg_match('|<item>(.*?)</item>|is', $file, $imported_entries);
		preg_match('|<value>(.*?)</value>|is', $imported_entries[1], $value);
		$this->upload_link_old = $value[1];
		preg_match('|<option>(.*?)</option>|is', $imported_entries[1], $theme_name);
		$this->theme_name_old = 'themes/'.$theme_name[1];
	}

	function tfuse_remap_urls( $content ) {
	if ( is_array($content) )
	{
		tfuse_array_walk_recursive($content, 'tfuse_change_link', array('old'=>$this->upload_link_old,'new'=>$this->upload_link_new));
		tfuse_array_walk_recursive($content, 'tfuse_change_link', array('old'=>$this->theme_name_old,'new'=>$this->theme_name_new));
		tfuse_array_walk_recursive($content, 'tfuse_change_link', $this->base_url);
	}
	else
	{
		$content = str_ireplace($this->upload_link_old,$this->upload_link_new,$content);
		$content = str_ireplace($this->theme_name_old,$this->theme_name_new,$content);
		$content = str_ireplace($this->base_url,get_bloginfo('url'),$content);
	}
	return $content;
	}


        function request_filesystem_credentials($error = false) {
		$url = admin_url( 'admin.php?page=tfuse' );
		$context = false;
//		if ( !empty($this->options['nonce']) )
//			$url = wp_nonce_url($url, $this->options['nonce']);
		return request_filesystem_credentials($url, '', $error, $context); //Possible to bring inline, Leaving as is for now.
	}
        
        function tf_install_copy( $from, $to, $skip_list = array() )
        {
            global $wp_filesystem, $different_path;

            if(isset($_POST['password']))
                $credentials = $_POST;
            elseif(isset($_POST['tfuse_ftp_cred']))
                $credentials = unpk($_POST['tfuse_ftp_cred']);   
            elseif (false === ($credentials = $this->request_filesystem_credentials()))
                return false;
            
            if (!WP_Filesystem($credentials)) {
                $error = true;
                if (is_object($wp_filesystem) && $wp_filesystem->errors->get_error_code())
                    $error = $wp_filesystem->errors;
                $this->request_filesystem_credentials($error); //Failed to connect, Error and request again
                return false;
            }

            if ( is_file( $from ) )
            {
                if ( ! $wp_filesystem->copy($from, $to, true, FS_CHMOD_FILE) )
                {   
                    /**
                     * incearca sa modifice linkul din
                     * /var/www/vhosts/yoctone.com/subdomains/wp3/httpdocs/wp-content/themes/qlassik/library/install/wordpress.xml
                     * in
                     * /httpdocs/wp-content/themes/qlassik/library/install/wordpress.xml
                     */
                    $from = trailingslashit( str_ireplace( dirname(ABSPATH), '', $from ) );
                    $to = trailingslashit( str_ireplace( dirname(ABSPATH), '', $to ) );
                    $different_path = true;

                    // If copy failed, chmod file to 0644 and try again.
                    $wp_filesystem->chmod($to, 0644);
                    if ( ! $wp_filesystem->copy($from, $to, true, FS_CHMOD_FILE) )
                        return new WP_Error('copy_failed', __('Could not copy file.'), $to);
                }
            }
            elseif ( is_dir( $from ) )
            {
                if ( !empty ($_POST['different_path']) )
                {
                    $from = trailingslashit( str_ireplace( dirname(ABSPATH), '', $from ) );
                    $to = trailingslashit( str_ireplace( dirname(ABSPATH), '', $to ) );
                }
                
                if ( ! $wp_filesystem->dirlist($from) )
                    return new WP_Error('list_source_failed', __('Could not copy source files.'), $from);
                
                return copy_dir( $from, $to, $skip_list );   
            }
            return true;
        }

	/**
	 * Upload a WXR file
	 */
	function tfuse_WXR()
	{
            $source = THEME_INSTALL . '/wordpress.xml';
            if ( is_file( $source ) )
            {
                if ( ! ( ( $upload_dir = wp_upload_dir() ) && false === $upload_dir['error'] ) )
                {
                    echo '<div class="error"><p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
                    echo esc_html( $upload_dir['error'] ) . '</p></div>';
                    echo '<p>Typical WordPress installs only need the <strong>wp-content</strong> directory to have 777 permission rights. For more details about file permissions please read this articles.<br /><br />
                        <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">http://codex.wordpress.org/Changing_File_Permissions</a><br />
                        <a href="http://samdevol.com/wordpress-troubleshooting-permissions-chmod-and-paths-oh-my/" target="_blank">WordPress Troubleshooting: Permissions, CHMOD and paths</a><br />
                        <a href="http://codex.wordpress.org/Hardening_WordPress" target="_blank">Hardening WordPress</a></p>';
                    return false;
                }

                $dest = $upload_dir['path'].'/wordpress.xml_.txt';
                //$result = copy($source, $dest);
                
                $result = $this->tf_install_copy($source, $dest);
                
                if($result === false)
                    return false;
                elseif (is_wp_error($result))
                    return $result;
                 
                //$dest = addslashes($dest);
                $filename = basename( $dest );
                $url = $upload_dir['url'] . "/$filename";

                if ( is_multisite() )
                        delete_transient( 'dirsize_cache' );

                // Construct the object array
                $object = array( 'post_title' => $filename,
                        'post_content' => $url,
                        'post_mime_type' => 'attachment',
                        'guid' => $url,
                        'context' => 'import',
                        'post_status' => 'private'
                );

                // Save the data
                $this->id = $id = wp_insert_attachment( $object, $dest );

                // schedule a cleanup for one day from now in case of failed import or missing wp_import_cleanup() call
                wp_schedule_single_event( time() + 86400, 'importer_scheduled_cleanup', array( $id ) );

                return array( 'file' => $dest, 'id' => $id );
            }
	}

	/**
	 * Display introductory text and file upload form
	 */
	function greet()
        {
            global $different_path;
            echo '<div style="clear:both;height:20px;"></div>';
            
            //Upload a WXR file
            $WXR_file = $this->tfuse_WXR();
            if(is_wp_error($WXR_file))
            {
                echo '<div class="error">'; show_message($WXR_file); echo '</div>';
            }
                    
            if ( is_array($WXR_file) ) {
?>
		<div class="install">

		<div style="clear:both;height:10px;"></div>

            <div class="demoinstall">

                <div class="tfuse_install_submit">
                    <form method="post" action="<?php echo admin_url( 'admin.php?page=tfuse&amp;step=2' ) ?>">
                    <?php wp_nonce_field( 'themefuse-import-wordpress' ); ?>
                        <input type="hidden" name="import_id" value="<?php echo $this->id; ?>" />
                        <input type="hidden" name="fetch_attachments" value="1" />
                        <?php 
                        if(isset($_POST['password']))
                            echo '<input type="hidden" name="tfuse_ftp_cred" value="'.esc_attr( pk($_POST)).'" />';
                        if(!empty ($different_path))
                            echo '<input type="hidden" name="different_path" value="1" />';
                        ?>
                        <p class="submit"><input type="submit" class="button" id="install_btn" value="Install Demo Version &raquo;" /></p>
                    </form>
                </div>

                <img class="tfuse_install_icon" src="<?php echo ADMIN_IMAGES.'/auto_install_icon.png' ?>" width="33" height="33" />

                <h3>Auto Install</h3>
                <p>
                Install is not necessary but will help you to get the core pages, categories,
                and meta setup correctly and let you see how the pages/posts work. <br> <br>
                <span>WARNING: IF YOU ALREADY HAVE POSTS, PAGES, AND CATEGORIES SETUP IN YOUR WORDPRESS DO NOT INSTALL THIS.
                IT WILL MOST CERTAINLY DESTROY YOUR PAST WORK.</span>
                </p>

            </div>

            <div class="skipinstall">

                <div class="tfuse_install_submit">
                    <form method="post" action="<?php echo admin_url( 'admin.php?page=tfuse&amp;step=4' ) ?>">
                        <p class="submit"><input name="skip_installation" type="submit" value="Skip Installation &raquo;" /></p>
                    </form>
                </div>

                <img class="tfuse_install_icon" src="<?php echo ADMIN_IMAGES.'/skip_install_icon.png' ?>" width="33" height="33" />

                <h3>Skip Installation</h3>
                <p>
                Skiping the instalation will not install the core pages and categories. Further more the meta setup and all the settings will be done manually.<br> <br>
                <span>NOTE: WE RECOMMEND SKIPPING THE INSTALL ONLY IF YOU HAVE WORDPRESS SKILLS  AND KNOW HOW TO MANUALLY INSTALL THE TEMPLATE</span>
                </p>

            </div>

            <div class="install_loading">
                <div style="text-align:center">
                    <br />
                    <img src="<?php echo ADMIN_IMAGES.'/loading.gif' ?>" /> <br />
                    <p>Installing ... </p>
                    <br />
                </div>
            </div>

		</div>
<?php
                }}

	/**
	 * Decide if the given meta key maps to information we will want to import
	 *
	 * @param string $key The meta key to check
	 * @return string|bool The key if we do want to import, false if not
	 */
	function is_valid_meta_key( $key ) {
		// skip attachment metadata since we'll regenerate it from scratch
		// skip _edit_lock as not relevant for import
		if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) )
			return false;
		return $key;
	}

	/**
	 * Decide whether or not the importer is allowed to create users.
	 * Default is true, can be filtered via import_allow_create_users
	 *
	 * @return bool True if creating users is allowed
	 */
	function allow_create_users() {
		return apply_filters( 'import_allow_create_users', true );
	}

	/**
	 * Decide whether or not the importer should attempt to download attachment files.
	 * Default is true, can be filtered via import_allow_fetch_attachments. The choice
	 * made at the import options screen must also be true, false here hides that checkbox.
	 *
	 * @return bool True if downloading attachments is allowed
	 */
	function allow_fetch_attachments() {
		return apply_filters( 'import_allow_fetch_attachments', true );
	}

	/**
	 * Decide what the maximum file size for downloaded attachments is.
	 * Default is 0 (unlimited), can be filtered via import_attachment_size_limit
	 *
	 * @return int Maximum attachment file size to import
	 */
	function max_attachment_size() {
		return apply_filters( 'import_attachment_size_limit', 0 );
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 60 seconds during import
	 * @return int 60
	 */
	function bump_request_timeout() {
		return 60;
	}

	// return the difference in length between two strings
	function cmpr_strlen( $a, $b ) {
		return strlen($b) - strlen($a);
	}

	function TFUSE_Import()
	{
		$this->slug_prefix = PREFIX;

		if( isset($_REQUEST['r']) ) $this->r = $_REQUEST['r'];

		if( isset($_REQUEST['step']) && $_REQUEST['step'] == 2 )
		{
			$filename = THEME_INSTALL . '/options.txt';
			$this->tfuse_options_file = file_get_contents($filename);
		}

    }

}

} // class_exists( 'WP_Importer' )