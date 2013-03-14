<?php
// avoid direct calls to this file where wp core files not present
if (!function_exists ('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
// class that reperesent the complete plugin
class TestimonialOptions {
    var $pagehook = 'testimonials';
    function TestimonialOptions() {
        add_action('admin_post_save_option', array(&$this, 'on_save_changes'));
        add_action('admin_menu', array(&$this, 'add_admin_scripts'));
        add_action('admin_menu', array(&$this, 'add_tinymce_scripts'));
    }

    function add_admin_scripts() {
        // ensure, that the needed javascripts been loaded to allow drag/drop, expand/collapse and hide/show of boxes
        wp_enqueue_script('postbox');
    }
    function add_tinymce_scripts() {
        wp_enqueue_script('editor');
        wp_enqueue_script('quicktags');

        // wp_tiny_mce is deprecated since version 3.3! Use wp_editor() instead.
        if(!function_exists('wp_editor'))
        add_action( 'admin_print_footer_scripts', 'wp_tiny_mce', 25 );
    }
    // for WordPress 2.8 we have to tell, that we support 2 columns !
    function on_screen_layout_columns($columns, $screen) {
        if ($screen == $this->pagehook) {
            $columns[$this->pagehook] = 2;
        }
        return $columns;
    }

    function on_testimonials_page() {
    	global $tfuse;
    	$prefix =  $tfuse->prefix;
    	if(!isset($_GET['action'])) $_GET['action']='';

    	add_meta_box('FuseTestimonialPage', 'Testimonial Details', array(&$this, 'createtestimonial'), $this->pagehook, 'normal', 'core');

	if ( !isset($_GET['msg']) ) $_GET['msg'] = '';
    	if ($_GET['action'] == 'edit' && $_GET['msg'] != "Testimonial Edited") {
            $title = 'Edit Testimonial';
        } else {
            $title = 'Add New Testimonial';
        }

        // we need the global screen column value to beable to have a sidebar in WordPress 2.8
        // global $screen_layout_columns;
        $screen_layout_columns = 1;

	    $themeauthor =  get_option("{$prefix}_themeauthor");
	    $themename   =  get_option("{$prefix}_themename");
	    $authorurl1  =  get_option("{$prefix}_authorurl1");
	    $authorurl2  =  get_option("{$prefix}_authorurl2");
	    $authorname1 =  get_option("{$prefix}_authorname1");
	    $authorname2 =  get_option("{$prefix}_authorname2");
	    $forumurl	 =  get_option("{$prefix}_forumurl");
	    $manualurl   =  get_option("{$prefix}_manual");

	    $theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
	    $local_version = $theme_data['Version'];
	    $theme_version = '<span class="version">version '. $local_version .'</span>';

        ?>

		<style>
		 #contextual-help-link-wrap{
			display: none;
			}
		</style>
        <div class="wrap" id="tfuse_fields">

			<div style="height:15px;">&nbsp;</div>
			<div class="tfuse_header">
				<div class="header_icon_bg">
					<a href="http://www.themefuse.com" target="_blank" title="Go to ThemeFuse"><img class="header_icon" src="<?php echo ADMIN_IMAGES;?>/thumb.png" width="70%" height="70%" /></a>
				</div>
				<!-- .header_icon_bg -->

				<div class="header_text">
					<h3><?php echo $themename; ?></h3>
					<a href="http://www.themefuse.com" target="_blank" title="Go to ThemeFuse"><img src="<?php echo ADMIN_IMAGES;?>/by_tfuse.png" /></a>
					<div class="clear"></div>

					<div class="links">
						<a target="_blank" href="<?php echo $manualurl; ?>">Online documentation</a>&nbsp;&nbsp;<span>|</span>&nbsp;&nbsp;<a target="_blank" href="<?php echo $forumurl; ?>">Support Forums</a>
						<?php echo $theme_version; ?>
					</div>
				</div>
				<!-- .header_text -->

				<div class="clear"></div>
			</div>
			<!-- .tfuse_fheader -->



        	<br />
            <h3><?php echo __('Manage Your Testimonials'); ?></h3>
            <div class="bordertitle"></div>
            <?php
            if (isset($_GET['msg']) && $_GET['msg']!='' ) { ?>
                <div class='updated'><p><strong><?php echo $_GET['msg']; ?></strong></p></div>
            <?php
            } ?>
            <form action="admin-post.php" method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('themeOptionPage'); ?>
                <?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>
                <?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false); ?>
                <input type="hidden" name="action" value="save_option" />
                <div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
                    <div id="side-info-column" class="inner-sidebar"></div>
                    <div id="post-body" class="has-sidebar">
                        <div id="post-body-content" class="has-sidebar-content">
                            <?php echo $this->managetestimonial(); ?>
                            <h3 style="padding-left:0px!important; padding-bottom:17px!important"><?php echo __($title); ?></h3>
				            <div class="bordertitle"></div>
				            <?php if(!isset($data)) $data = ''; ?>
                            <?php do_meta_boxes($this->pagehook, 'normal', $data); ?>
                            <br/>
                        </div>
                    </div>
                    <br class="clear"/>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready( function($) {
                // close postboxes that should be closed
            	jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                // postboxes setup
                postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
                jQuery(".checkall").click(function() {

                    var checked_status = this.checked;
                    jQuery(".tobedeleted").each(function() {
                        this.checked = checked_status;
                    });
                });
            });
            //]]>
        </script>
    <?php
    }

    function on_save_changes() {
	if ( !isset($_POST['doaction']) ) $_POST['doaction']='';
        if ($_POST['doaction'] == 'Apply') {
            $data = get_option('testimonials_manager');
            if (!empty($_POST['delete_comments'])) {
                foreach ($_POST['delete_comments'] as $arr) {
                    unset($data['data'][$arr]);
                }

                $data['data'] = array_values($data['data']);
                update_option('testimonials_manager', $data);
            }
        }

        // die();
        if (isset($_POST['CreateTestimonial'])) {
            $data = get_option('testimonials_manager');

            $inputdata['name']      = stripslashes($_POST['name']);
            $inputdata['company']   = stripslashes($_POST['company']);
            $inputdata['url']       = stripslashes($_POST['url']);
            $inputdata['text']      = stripslashes($_POST['text']);
            $inputdata['avatar']    = (isset($_POST['avatar'])) ? stripslashes($_POST['avatar']):'';
            $inputdata['email']     = (isset($_POST['email'])) ? stripslashes($_POST['email']):'';
	    if ( !isset($_FILES['own_avatar']['name']) ) $_FILES['own_avatar']['name'] = '';
            if ($_FILES['own_avatar']['name'] != "") {
                $overrides  = array('test_form' => false);
                $file       = wp_handle_upload($_FILES['own_avatar'], $overrides);

                if (isset($file['error']))
                    die($file['error']);

                $url = $file['url'];
                $type = $file['type'];
                $file = $file['file'];
                $filename = basename($file);

                // Construct the object array
                $object = array(
                        'post_title' => $filename,
                        'post_content' => $url,
                        'post_mime_type' => $type,
                        'guid' => $url);

                // Save the data
                $id = wp_insert_attachment($object, $file);

                list($width, $height, $type, $attr) = getimagesize($file);

                if ($width == $data['imagex'] && $height == $data['imagey']) {
                } elseif ($width > $data['imagex']) {
                    $image = image_resize($file, $data['imagex'], $data['imagey'], true, 't', null, 100);
                    $image = apply_filters('wp_create_file_in_uploads', $image, $id); // For replication
                    $url = str_replace(basename($url), basename($image), $url);
                } else {
                    $oitar = 1;
                }

                $inputdata['own_avatar'] = $url.$filename;
            }

	    if ( !isset($inputdata['own_avatar']) ) $inputdata['own_avatar'] = '';
            if ($inputdata['own_avatar'] == "") {
	    if ( !isset($previous_test_id) ) $previous_test_id = 0;
                $inputdata['own_avatar'] = (isset($data['data'][$previous_test_id]['own_avatar']))?$data['data'][$previous_test_id]['own_avatar']:'';
            }


            $data['data'][] = $inputdata;
	    if ( !isset($_POST['avatar']) ) $_POST['avatar'] = '';
            if ($_POST['avatar']=='own_pic' AND (empty($_FILES['own_avatar']['name']))) {
                $alert  = urlencode('Picture not specified. Press back to try again');
            } elseif ($_POST['avatar']=='gravatar' AND (empty($_POST['email']))) {
                $alert  = urlencode('No personal Gravatar specified. Press back to try again');
            } elseif (empty($inputdata['name'])) {
                $alert  = urlencode('Name not specified. Press back to try again');
            }  elseif (empty($inputdata['text'])) {
                $alert  = urlencode('No testimonial entered. Press back to try again');
            } else {
                update_option('testimonials_manager', $data);
                $alert  = urlencode("New Testimonial Created.");
            }
        }

        if (isset($_POST['EditTestimonial'])) {
            $_POST['_wp_http_referer']  = str_replace('testimonials_add','testimonials_manage',$_POST['_wp_http_referer']);
            $data                       = get_option('testimonials_manager');
            $previous_test_id           = $_POST['previous_test_id'];

			if ( !isset($_POST['name']) )	$_POST['name'] = '';
				$inputdata['name']          = stripslashes($_POST['name']);
			if (!isset($_POST['company']))	$_POST['company'] = '';
				$inputdata['company']       = stripslashes($_POST['company']);
			if ( !isset($_POST['url']) )	$_POST['url'] = '';
				$inputdata['url']           = stripslashes($_POST['url']);
			if ( !isset($_POST['text']) )	$_POST['text'] = '';
				$inputdata['text']          = stripslashes($_POST['text']);
			if ( !isset($_POST['avatar']) ) $_POST['avatar'] = '';
				$inputdata['avatar']        = stripslashes($_POST['avatar']);
			if ( !isset($_POST['email']) ) $_POST['email'] = '';
				$inputdata['email']         = stripslashes($_POST['email']);

	    if ( !isset($_FILES['own_avatar']['name']) ) $_FILES['own_avatar']['name'] = '';
            if ($_FILES['own_avatar']['name'] != "") {
                $overrides  = array('test_form' => false);
                $file       = wp_handle_upload($_FILES['own_avatar'], $overrides);

                if (isset($file['error']))
                    die($file['error']);

                $url        = $file['url'];
                $type       = $file['type'];
                $file       = $file['file'];
                $filename   = basename($file);
                // Construct the object array
                $object = array(
                        'post_title' => $filename,
                        'post_content' => $url,
                        'post_mime_type' => $type,
                        'guid' => $url);

                // Save the data
                $id = wp_insert_attachment($object, $file);

                list($width, $height, $type, $attr) = getimagesize($file);

                if ($width == $data['imagex'] && $height == $data['imagey']) {
                } elseif ($width > $data['imagex']) {
                    $image  = image_resize($file, $data['imagex'], $data['imagey'], true, 't', null, 100);
                    $image  = apply_filters('wp_create_file_in_uploads', $image, $id); // For replication
                    $url    = str_replace(basename($url), basename($image), $url);
                } else {
                    $oitar = 1;
                }

                $inputdata['own_avatar'] = $url.$filename;
            }

	    if ( !isset($inputdata['own_avatar']) ) $inputdata['own_avatar'] = '';
            if ($inputdata['own_avatar'] == "") {
                $inputdata['own_avatar'] = $data['data'][$previous_test_id]['own_avatar'];
            }


            $data['data'][$previous_test_id] = $inputdata;
            if ($_POST['avatar']=='own_pic' AND (empty($_FILES['own_avatar']['name'])) AND ($inputdata['own_avatar']=='')) {
                $alert  = urlencode('Picture not specified. Press back to try again');
            } elseif ($_POST['avatar']=='gravatar' AND (empty($_POST['email']))) {
                $alert  = urlencode('No personal Gravatar specified. Press back to try again');
            } elseif (empty($inputdata['name'])) {
                $alert  = urlencode('Name not specified. Press back to try again');

            } elseif (empty($inputdata['text'])) {
                $alert  = urlencode('No testimonial entered. Press back to try again');
            } else {
                update_option('testimonials_manager', $data);
                $alert  = urlencode("Testimonial Edited");
            }
        }

        if (isset($_POST['btnDeleteTestimonial'])) {
            $id     = array_keys($_POST['btnDeleteTestimonial']);
            $data   = get_option('testimonials_manager');

            unset($data['data'][$id[0]]);
            $data['data'] = array_values($data['data']);

            update_option('testimonials_manager', $data);
            $alert  = urlencode("Testimonial Deleted");
        }

        if (isset($_POST['CreateCustomCSS'])) {
            $data               = get_option('testimonials_manager');
            $data['customcss']  = stripslashes($_POST['css']);
            $data['imagex']     = stripslashes($_POST['imagex']);
            $data['imagey']     = stripslashes($_POST['imagey']);
            $data['dorder']     = stripslashes($_POST['dorder']);
            $data['items']      = stripslashes($_POST['items']);
            update_option('testimonials_manager', $data);
            $alert              = urlencode("Custom CSS Saved");
        }

	if ( !isset($alert) ) $alert = '';
        $params = array('msg' => $alert);
        wp_redirect(add_query_arg($params, $_POST['_wp_http_referer']));
    }

    function managetestimonial() {
        $x = 0;
        if(!isset($_GET['action'])) $_GET['action']='';
        $data = get_option('testimonials_manager');
        if (($_GET['action'] == 'delete')) {
            $id             = ($_GET['testimonial_id']);
            $data           = get_option('testimonials_manager');
            unset($data['data'][$id]);
            $data['data']   = array_values($data['data']);

            update_option('testimonials_manager', $data);
            echo "Testimonial Deleted<br/>";
        }

        $testimonialboxcount = count($data['data']);

        $p = new pagination;

        $p->items($testimonialboxcount);

        $p->limit(25);
        if (empty($_GET['pg'])) {
            $page = 1;
        } else {
            $page = $_GET['pg'];
        }
        $p->currentPage($page);
        $p->target('admin.php?page=tfuse_testimonials');

        ?>
        <div class="tablenav">
            <div class='tablenav-pages'>
                 <?php
                 echo $p->show();
                 // Echo out the list of paging. ?>
            </div>
            <div class = "alignleft actions" > <select name = "act" > <option value = "-1" selected = "selected" > Bulk Actions</option > <option value = "trash" > Delete</option >
                </select > <input type = "submit" name = "doaction" id = "doaction" value = "Apply" class = "button-secondary apply" / >
            </div><br class = "clear" / >
        </div >
        <?php
        // print_r($data);
        if ($testimonialboxcount > 25) {
            $testimonialboxcount = 25;
            // now to make the array smaller
            $newarray = array_slice($data['data'], ($page - 1) * 25, 25);
            $data['data'] = $newarray;
            $testimonialboxcount = count($newarray);
        }
        ?>
        <table class="widefat" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" class="checkall"/></th>
                    <th scope="col" width="250px">Name</th>
                    <th scope="col">Testimonial</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" class="checkall" /></th>
                    <th scope="col">Name</th>
                    <th scope="col">Testimonial</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                if ($testimonialboxcount == 0) {
                ?>
                    <tr style="background:#eeeeee;">
                        <td colspan="3" align="center"><strong>No testimonial yet, add one below.</strong></td>
                    </tr>
                <?php
                } else {
                    while ($x <$testimonialboxcount) {
                    	$av = '';
                        $num = $x;
                        $num = $num + 1 + ($page - 1) * 25;
                        $url = $data['data'][$x]['url'];
                        if (substr($url, 0, 7) != 'http://') {
                            $url = 'http://' . $url;
                        }
                        if ($data['data'][$x]['avatar']) {
                            if ($data['data'][$x]['avatar'] == "gravatar") {
                                $av = get_avatar($data['data'][$x]['email'], 48);
                            } else {
                                $av = '<img src="' . $data['data'][$x]['own_avatar'] . '" class="avatar" alt="avatar" width="48" height="48" />';
                            }
                        }
                        ?>
                        <tr>
                            <td align="center" valign="top"><input type='checkbox' name='delete_comments[]' class="tobedeleted" value='<?php echo($num - 1); ?>' /></td>
                            <td class="author column-author">
                                <strong><?php echo $av ?> <?php echo $data['data'][$x]['name'] ?></strong><br>
                                <?php echo $data['data'][$x]['company']; ?><br/>
                                <a href="<?php echo $url; ?>"><?php echo $data['data'][$x]['url']; ?></a>
                            </td>
                            <td align="" valign="top"><?php echo $data['data'][$x]['text']; ?>
                                <div class="row-actions"><span class='edit'><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=tfuse_testimonials&action=edit&testimonial_id=<?php echo ($num - 1);?>" title="Edit this post">Edit</a> | </span><!-- <span class='inline hide-if-no-js'><a href="#" class="editinline" title="Edit this post inline">Quick&nbsp;Edit</a> | </span> --><span class='trash'><a class='submitdelete' title='Move this post to the Trash' href='<?php echo $_SERVER['PHP_SELF']; ?>?page=testimonials_manage&action=delete&testimonial_id=<?php echo ($num - 1);?>'>Delete</a>  </span></div>
                            </td>
                        </tr>
                        <?php
                        $x++;
                    }
                }?>
            </tbody>
        </table>
        <div class="tablenav">
            <div class='tablenav-pages'>
                <?php echo $p->show(); // Echo out the list of paging. ?>
            </div>
            <div class = "alignleft actions" > <select name = "act" > <option value = "-1" selected = "selected" > Bulk Actions</option > <option value = "trash" > Delete</option >
                </select ><input type = "submit" name = "doaction" id = "doaction" value = "Apply" class = "button-secondary apply" / >
            </div><br class = "clear" / >
        </div>
        <br />
    <?php
    }

    function createTestimonial($title) {
        $data = get_option('testimonials_manager');

    	if ($_GET['action'] == 'edit' && $_GET['msg'] != "Testimonial Edited") {
			$testcount = count($data);
			$test = $data['data'][$_GET['testimonial_id']];
		}

    ?>
        <a name="addnewTestimonial"></a>
        <table border="0" width="100%" cellspacing="20">
            <tr>
                <td width="16%" align="right" valign="top" >
                    <label for="name"><strong>Name:</strong></label>
                </td>
                <td width="84%">
                    <input type="text" name="name" value="<?php if ($_GET['action'] == 'edit') { if ( isset($test['name']) ) echo $test['name']; } ?>" style="width:100%;" />
                </td>
            </tr>
            <tr>
                <td width="16%" align="right" valign="top" >
                    <label for="company"><strong>Website Name:</strong></label>
                </td>
                <td width="84%">
                    <input type="text" name="company" value="<?php if ($_GET['action'] == 'edit') { if ( isset($test['company']) ) echo $test['company'];} ?>" style="width:100%;" />
                </td>
            </tr>
            <tr>
                <td width="16%" align="right" valign="top" >
                    <label for="url"><strong>Website URL:</strong></label>
                </td>
                <td width="84%">
                    <input type="text" name="url" value="<?php if ($_GET['action'] == 'edit') { if ( isset($test['url']) ) echo $test['url'];}?>" style="width:100%;" />
                </td>
            </tr>
            <tr>
                <td width="16%" align="right" valign="top"><label for="text"><strong>Testimonial:</strong></label><br></td>
                <td width="84%">
                    <?php if(!isset($test['text'])) $test['text'] = ''; ?>
                    <?php
                        if(function_exists('wp_editor'))
                            wp_editor($test['text'], 'text', '', false, 4);
                        else
                            the_editor($test['text'], 'text', '', false, 4);
                    ?>
                </td>
            </tr>
        </table>
        <p style="text-align:right;">
            <?php
            if ($_GET['action'] == 'edit') { ?>
                <input type="hidden" name="previous_test_id" value="<?php echo $_GET['testimonial_id'] ?>" />
                <input type="submit" value="Update Testimonial" class="button-primary" name="EditTestimonial"/>
            <?php
            } else { ?>
                <input type="submit" value="Create Testimonial" class="button-primary" name="CreateTestimonial"/>
            <?php
            } ?>
            <br/>
        </p>
        <style>#text {width:100%} </style>
    <?php
    }



    function testimonialcss() {
        $data = get_option('testimonials_manager');
        // print_r($data);
        if (empty($data['imagex'])) {
            $data['imagex'] = 48;
        }
        if (empty($data['imagey'])) {
            $data['imagey'] = 48;
        }
        if (empty($data['dorder'])) {
            $data['dorder'] = 'asc';
        }
        if (empty($data['items'])) {
            $data['items'] = 10;
        }
        ?>

        <table border="0" width="100%" cellspacing="20">
            <tr>
                <td width="16%" align="right" valign="top"><label for="css"><strong>Custom CSS:</strong></label><br></td>
                <td width="84%">
                    <textarea name="css" style="width:100%; height:200px;">
                        <?php
                        if (!isset($data['customcss']) || $data['customcss'] == "") {
                            echo <<<EOF
.testimonial{
    margin: 10px 0;
    padding:10px;
    border: 1px dotted #f4f4f4;
    background: #dddddd;
}

.testimonial .avatar {
    background:#FFFFFF none repeat scroll 0 0;
    border:1px solid #DDDDDD;
    float:right;
    margin-right:-5px;
    margin-top:-5px;
    padding:2px;
    position:relative;
}

div.pagination {
    padding: 3px;
    margin: 3px;
    text-align:center;
}

div.pagination a {
    border: 1px solid #dedfde;
    margin-right:3px;
    padding:2px 6px;

    background-position:bottom;
    text-decoration: none;

    color: #0061de;
}
div.pagination a:hover, div.meneame a:active {
    border: 1px solid #000;
    background-image:none;
    background-color:#0061de;
    color: #fff;
}
div.pagination span.current {
    margin-right:3px;
    padding:2px 6px;

    font-weight: bold;
    color: #ff0084;
}
div.pagination span.disabled {
    margin-right:3px;
    padding:2px 6px;

    color: #adaaad;
}
EOF;
                        } else {
                            echo $data['customcss'];
                        } ?>
                    </textarea>
                    <small>Enter your custom CSS here.</small>
                </td>
            </tr>
            <tr>
                <td width="16%" align="right" valign="top"><label for="imagesize"><strong>Image Size</strong></label><br></td>
                <td width="84%">
                    <input name="imagex"  value="<?php echo $data['imagex'] ?>" size="2"/> x  <input name="imagey"  value="<?php echo $data['imagey'] ?>" size="2"/> pixels
                </td>
            </tr>
            <tr>
                <td width="16%" align="right" valign="top"><label for="dorder"><strong>Display Order</strong></label><br></td>
                <td width="84%">
                    <select name="dorder">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="16%" align="right" valign="top"><label for="items"><strong>Items Per Page</strong></label><br></td>
                <td width="84%">
                    <input name="items"  value="<?php echo $data['items'] ?>" />
                </td>
            </tr>
        </table>
        <p style="text-align:right;">
            <input type="submit" value="Save Settings" class="button-primary" name="CreateCustomCSS"/>
            <br/>
        </p>
        <?php
    }

}

$TestimonialOptions = new TestimonialOptions();

class pagination {
    /*
	   Script Name: *Digg Style Paginator Class
	   Script URI: http://www.mis-algoritmos.com/2007/05/27/digg-style-pagination-class/
	   Description: Class in PHP that allows to use a pagination like a digg or sabrosus style.
	   Script Version: 0.4
	   Author: Victor De la Rocha
	   Author URI: http://www.mis-algoritmos.com
    */
    /*Default values*/
    var $total_pages    = - 1; //items
    var $limit          = null;
    var $target         = "";
    var $page           = 1;
    var $adjacents      = 2;
    var $showCounter    = false;
    var $className      = "pagination";
    var $parameterName  = "pg";
    var $urlF           = false; //urlFriendly
    /*Buttons next and previous*/
    var $nextT          = "Next";
    var $nextI          = "&#187;"; //&#9658;
    var $prevT          = "Previous";
    var $prevI          = "&#171;"; //&#9668;

    var $calculate      = false;
    // Total items
    function items($value) {
        $this->total_pages  = (int) $value;
    }
    // how many items to show per page
    function limit($value) {
        $this->limit        = (int) $value;
    }
    // Page to sent the page value
    function target($value) {
        $this->target       = $value;
    }
    // Current page
    function currentPage($value) {
        $this->page         = (int) $value;
    }
    // How many adjacent pages should be shown on each side of the current page?
    function adjacents($value) {
        $this->adjacents    = (int) $value;
    }
    // show counter?
    function showCounter($value = "") {
        $this->showCounter  = ($value === true)?true:false;
    }
    // to change the class name of the pagination div
    function changeClass($value = "") {
        $this->className    = $value;
    }

    function nextLabel($value) {
        $this->nextT        = $value;
    }
    function nextIcon($value) {
        $this->nextI        = $value;
    }
    function prevLabel($value) {
        $this->prevT        = $value;
    }
    function prevIcon($value) {
        $this->prevI        = $value;
    }
    // to change the class name of the pagination div
    function parameterName($value = "") {
        $this->parameterName = $value;
    }
    // to change urlFriendly
    function urlFriendly($value = "%") {
        if (eregi('^ *$', $value)) {
            $this->urlF = false;
            return false;
        }
        $this->urlF = $value;
    }

    var $pagination;
    function pagination() {
    }
    function show() {
        if (!$this->calculate) {
            if ($this->calculate()) {
                echo "<div class=\"$this->className\">$this->pagination</div>\n";
            }
        }
    }
    function getOutput() {
        if (!$this->calculate) {
            if ($this->calculate()) {
                return "<div class=\"$this->className\">$this->pagination</div>\n";
            }
        }
    }
    function get_pagenum_link($id) {
        if (strpos($this->target, '?') === false)
            if ($this->urlF)
                return str_replace($this->urlF, $id, $this->target);
            else
                return "$this->target?$this->parameterName=$id";
        else
            return "$this->target&$this->parameterName=$id";
    }

    function calculate() {
        $this->pagination = "";
        $this->calculate == true;
        $error = false;
        if ($this->urlF and $this->urlF != '%' and strpos($this->target, $this->urlF) === false) {
            // Es necesario especificar el comodin para sustituir
            echo "Especificaste un wildcard para sustituir, pero no existe en el target<br />";
            $error = true;
        } elseif ($this->urlF and $this->urlF == '%' and strpos($this->target, $this->urlF) === false) {
            echo "Es necesario especificar en el target el comodin % para sustituir el n?mero de p?gina<br />";
            $error = true;
        }

        if ($this->total_pages <0) {
            echo "It is necessary to specify the <strong>number of pages</strong> (\$class->items(1000))<br />";
            $error = true;
        }
        if ($this->limit == null) {
            echo "It is necessary to specify the <strong>limit of items</strong> to show per page (\$class->limit(10))<br />";
            $error = true;
        }
        if ($error)return false;

        $n = trim($this->nextT . ' ' . $this->nextI);
        $p = trim($this->prevI . ' ' . $this->prevT);

        /* Setup vars for query. */
        if ($this->page)
            $start = ($this->page - 1) * $this->limit; //first item to display on this page
        else
            $start = 0; //if no page var is given, set start to 0
        /* Setup page vars for display. */
        $prev = $this->page - 1; //previous page is page - 1
        $next = $this->page + 1; //next page is page + 1
        $lastpage = ceil($this->total_pages / $this->limit); //lastpage is = total pages / items per page, rounded up.
        $lpm1 = $lastpage - 1; //last page minus 1
        /*
		   Now we apply our rules and draw the pagination object.
		   We're actually saving the code to a variable in case we want to draw it more than once.
        */

        if ($lastpage > 1) {
            if ($this->page) {
                // anterior button
                if ($this->page > 1)
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link($prev) . "\" class=\"prev\">$p</a>";
                else
                    $this->pagination .= "<span class=\"disabled\">$p</span>";
            }
            // pages
            if ($lastpage <7 + ($this->adjacents * 2)) { // not enough pages to bother breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $this->page)
                        $this->pagination .= "<span class=\"current\">$counter</span>";
                    else
                        $this->pagination .= "<a href=\"" . $this->get_pagenum_link($counter) . "\">$counter</a>";
                }
            } elseif ($lastpage > 5 + ($this->adjacents * 2)) { // enough pages to hide some
                // close to beginning; only hide later pages
                if ($this->page <1 + ($this->adjacents * 2)) {
                    for ($counter = 1; $counter <4 + ($this->adjacents * 2); $counter++) {
                        if ($counter == $this->page)
                            $this->pagination .= "<span class=\"current\">$counter</span>";
                        else
                            $this->pagination .= "<a href=\"" . $this->get_pagenum_link($counter) . "\">$counter</a>";
                    }
                    $this->pagination .= "...";
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link($lpm1) . "\">$lpm1</a>";
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link($lastpage) . "\">$lastpage</a>";
                }
                // in middle; hide some front and some back
                elseif ($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)) {
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link(1) . "\">1</a>";
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link(2) . "\">2</a>";
                    $this->pagination .= "...";
                    for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
                        if ($counter == $this->page)
                            $this->pagination .= "<span class=\"current\">$counter</span>";
                        else
                            $this->pagination .= "<a href=\"" . $this->get_pagenum_link($counter) . "\">$counter</a>";
                    $this->pagination .= "...";
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link($lpm1) . "\">$lpm1</a>";
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link($lastpage) . "\">$lastpage</a>";
                }
                // close to end; only hide early pages
                else {
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link(1) . "\">1</a>";
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link(2) . "\">2</a>";
                    $this->pagination .= "...";
                    for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
                        if ($counter == $this->page)
                            $this->pagination .= "<span class=\"current\">$counter</span>";
                        else
                            $this->pagination .= "<a href=\"" . $this->get_pagenum_link($counter) . "\">$counter</a>";
                }
            }
            if ($this->page) {
                // siguiente button
                if ($this->page <$counter - 1)
                    $this->pagination .= "<a href=\"" . $this->get_pagenum_link($next) . "\" class=\"next\">$n</a>";
                else
                    $this->pagination .= "<span class=\"disabled\">$n</span>";
                if ($this->showCounter)$this->pagination .= "<div class=\"pagination_data\">($this->total_pages Pages)</div>";
            }
        }

        return true;
    }
}

?>
