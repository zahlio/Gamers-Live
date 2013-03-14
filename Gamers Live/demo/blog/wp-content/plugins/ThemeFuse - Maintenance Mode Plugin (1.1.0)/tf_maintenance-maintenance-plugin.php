<?php /*

**************************************************************************

Plugin Name:  ThemeFuse Maintenance Mode
Plugin URI:   http://www.themefuse.com/plugin/?plugin=maintenance-mode
Version:      1.1.0
Description:  Adds a maintenance-page to your site that lets visitors know your site is down for maintenancetime.
Author:       Themefuse
Author URI:   http://themefuse.com/wp-themes-shop/?plugin=maintenance-mode

**************************************************************************/

 if ( ! defined( 'TF_MAINTENANCE_WP_PLUGIN_URL' ) )
       define( 'TF_MAINTENANCE_WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins/themefuse-maintenance-mode' );
 if ( ! defined( 'TF_MAINTENANCE_WP_PLUGIN_URL_JS' ) )
       define( 'TF_MAINTENANCE_WP_PLUGIN_URL_JS', WP_CONTENT_URL. '/plugins/themefuse-maintenance-mode/js' );


class tf_maintenance
{
    protected $_settings;
    protected $_options_pagename = 'tf_maintenance_options';
    protected $_exception_urls = array( 'wp-login.php', 'async-upload.php', '/plugins/', 'wp-admin/', 'upgrade.php', 'trackback/', 'feed/' );
    public $location_folder;
	public $menu_page;

	function __upload()
	{
	
	}
	
    function __construct()
    {
        $this->location_folder = trailingslashit(WP_PLUGIN_URL) . dirname( plugin_basename(__FILE__) );
        $this->server_folder   = trailingslashit(WP_PLUGIN_DIR) . dirname( plugin_basename(__FILE__) );
        $this->_settings = get_option('tf_maintenance_settings') ? get_option('tf_maintenance_settings') : array();
        $this->_set_standart_values();

        add_action( 'admin_menu', array(&$this, 'create_menu_link') );
        add_action( 'init', array(&$this, 'maintenance_active') );
        wp_enqueue_script('jquery');
    }
	
	function add_settings_link($links) {
		$settings = '<a href="'.admin_url('options-general.php?page=tf_maintenance_options').'">' . __('Settings') . '</a>';
		array_unshift( $links, $settings );
		return $links;
	}
	
    function output_activation_warning()
    { ?>
<div id="message" class="error">
  <p>
    <?php _e( "ThemeFuse Maintenance Mode  plugin isn't active. Activate it here." ); ?>
  </p>
</div>
<?php }

    
    function create_menu_link()
    {
        $this->menu_page = add_options_page('ThemeFuse Maintenance Mode Plugin Options', 'ThemeFuse Maintenance Plugin', 'manage_options',$this->_options_pagename, array(&$this, 'build_settings_page'));
        add_action( "admin_print_scripts-{$this->menu_page}", array(&$this, 'plugin_page_js') );
        add_action("admin_head-{$this->menu_page}", array(&$this, 'plugin_page_css'));
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'), 10, 2);
    }

    function build_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }

        if (isset($_REQUEST['saved'])) {
            if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.'ThemeFuse Maintenance'.' settings saved.</strong></p></div>';
	}

	if ( isset($_POST['tf_maintenance_settings_saved']) ) $this->_save_settings_todb($_POST);
?>
<div class="wrap" id="tfuse_fields">
  <div style="height:15px;">&nbsp;</div>
  <div class="tfuse_header">
	<div class="header_icon_bg">
		<a href="https://www.e-junkie.com/ecom/gb.php?ii=882084&c=ib&aff=141051&cl=136641" target="_blank" title="Go to ThemeFuse"><img class="header_icon" src="<?php echo $this->location_folder; ?>/images/maintenance_mode.png" width="70%" height="70%" /></a>
	</div>
	<!-- .header_icon_bg -->
    <div class="header_text">
      <h3>
        <?php _e( "ThemeFuse Maintenance Plugin Options" ); ?>
      </h3>
      <a href="https://www.e-junkie.com/ecom/gb.php?ii=882084&c=ib&aff=141051&cl=136641" target="_blank" title="Go to ThemeFuse"><img src="<?php echo $this->location_folder; ?>/images/by_tfuse.png" /></a>
      <div class="clear"></div>
      <div class="links"> <a target="_blank" href="https://www.e-junkie.com/ecom/gb.php?ii=882084&c=ib&aff=141051&cl=136641">Support Forums</a>&nbsp;&nbsp;<span> version 1.0.0 </span></div>
    </div>
	<!-- .header_text -->
	<div class="clear"></div>
	<a href="https://www.e-junkie.com/ecom/gb.php?ii=882084&c=ib&aff=141051&cl=136641" target="_blank" title="Go to ThemeFuse"><img style="margin-top:10px; margin-left:17px;" src="<?php echo $this->location_folder; ?>/images/banner.jpg" /></a>	
   </div>
   <!-- .tfuse_fheader -->
  <br />
  <form name="tf_maintenance_form" method="post">
	<table class="form-table-tf">
      <tr valign="top">
        <th scope="row"><?php _e( 'Upload Logo' ); ?></th>
        <td><label for="tf_maintenance_logo">
          <input type="text" class="regular-text" name="tf_maintenance_logo" id="tf_maintenance_logo" value="<?php echo($this->_settings['tf_maintenance_logo']); ?>" />
          <input id="upload_image_button" class="tfuse_upload_button" type="button" value="Upload Image" />
		  </label>
            <span id="file-uploader-logo">
            <noscript>
            <p>Please enable JavaScript to use file uploader.</p>
              <!-- or put a simple form for upload here -->
            </noscript>
            </span>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"><?php _e( 'Upload Background' ); ?></th>
        <td><label for="tf_maintenance_bg">
          <input type="text" class="regular-text" name="tf_maintenance_bg" id="tf_maintenance_bg" value="<?php echo($this->_settings['tf_maintenance_bg']); ?>" />
          <input id="upload_image_button1" class="tfuse_upload_button" type="button" value="Upload Image" />
		  </label>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <label for="tf_maintenance_date">
          <?php _e( 'Date' ); ?>
          </label>
        </th>
        <td><input name="tf_maintenance_date" type="text" id="tf_maintenance_date" value="<?php echo($this->_settings['tf_maintenance_date']); ?>" class="regular-text" />
            <span class="description">
            <?php _e( 'Choose a completion date. ex: 03/16/2011 00:00' ); ?>
          </span> </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <label for="tf_maintenance_complete_text">
          <?php _e( 'Text' ); ?>
          </label>
        </th>
        <td><input name="tf_maintenance_complete_text" type="text" id="tf_maintenance_complete_text" value="<?php echo($this->_settings['tf_maintenance_complete_text']); ?>" class="regular-text" />
            <span class="description">
            <?php _e( 'Input the text which would be visible on the loader bar' ); ?>
          </span> </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <label for="tf_maintenance_date">
          <?php _e( 'Completed' ); ?>
          </label>
        </th>
        <td><input name="tf_maintenance_complete_percent" type="text" id="tf_maintenance_complete_percent" value="<?php echo($this->_settings['tf_maintenance_complete_percent']); ?>" class="regular-text" />
            <span class="description">
            <?php _e( 'Input a value in %' ); ?>
          </span> </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <label for="tf_maintenance_content">
          <?php _e( 'Content' ); ?>
          </label>
        </th>
        <td><?php the_editor( trim(($this->_settings['tf_maintenance_content'])), 'tf_maintenance_content'); ?>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <label for="tf_maintenance_twitter_url">
          <?php _e( 'Twitter username' ); ?>
          </label>
        </th>
        <td><input name="tf_maintenance_twitter_url" type="text" id="tf_maintenance_twitter_url" value="<?php echo($this->_settings['tf_maintenance_twitter_url']); ?>" class="regular-text code" />
            <span class="description">
            <?php _e( 'ex. themefuse' ); ?>
          </span> </td>
      </tr>
      <tr valign="top">
        <th scope="row"> <p>
          <?php _e( 'Emails' ); ?>
        </p></th>
        <td><p><?php echo($this->_settings['tf_maintenance_emails']); ?></p>
            <span class="description">
            <?php _e( 'Here are a list of people who have subscribed to your mailing list' ); ?>
          </span> </td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="tf_maintenance_settings_saved" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
    </p>
  </form>
</div>
 
<?php
    }

    public function plugin_page_js()
    {	
        wp_enqueue_script('tf_maintenance-admin-date', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
        wp_enqueue_script('anticipate-admin-date-addon', $this->location_folder . '/js/jquery-ui-timepicker-addon.js');
 		wp_enqueue_script('tf_maintenance-admin-main', $this->location_folder . '/js/admin.js');
    }

    public function plugin_page_css()
    {
		?>
<link rel="stylesheet" href="<?php echo $this->location_folder; ?>/css/style.themefuse.css?v=1" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->location_folder; ?>/css/jquery-ui-1.7.3.custom.css" type="text/css" />
<?php
    }

    public function add_email( $email )
	{
        $emails = explode(", ", $email);
        $valid_emails = array();
        $unique_emails = array();

        foreach($emails as $mail){
            if ( is_email(trim($mail)) ) $valid_emails[] = trim($mail);
        }

        if ( empty($valid_emails) ) return false;

        $valid_emails_string = implode(", ", $valid_emails);
        if ( $this->_settings['tf_maintenance_emails'] <> '' ) $valid_emails_string = ', ' . $valid_emails_string;

        $this->_settings['tf_maintenance_emails'] .= $valid_emails_string;
        $unique_emails = explode(", ", $this->_settings['tf_maintenance_emails']);
        $unique_emails = array_unique($unique_emails);

        $this->_settings['tf_maintenance_emails'] = implode(", ", $unique_emails);
        $this->_save_settings_todb();

        return true;
    }

    protected function _save_settings_todb($form_settings = '')
    {
        if ( $form_settings <> '' ) {
            unset($form_settings['tf_maintenance_settings_saved']);

            $emails = $this->_settings['tf_maintenance_emails'];

			$form_settings['tf_maintenance_complete_text'] = stripslashes($form_settings['tf_maintenance_complete_text']);
			$form_settings['tf_maintenance_content']       = stripslashes($form_settings['tf_maintenance_content']);
			
			$this->_settings = $form_settings;
            $this->_settings['tf_maintenance_emails'] = $emails;

            #set standart values in case we have empty fields
            $this->_set_standart_values();
        }
        
        update_option('tf_maintenance_settings', $this->_settings);
    }

    protected function _set_standart_values()
    {
        $standart_values = array(
            'tf_maintenance_logo' => $this->location_folder . '/images/logo.png',
			'tf_maintenance_bg' => $this->location_folder . '/images/body_bg.jpg',
            'tf_maintenance_date' => date("m/d/Y H:i", time()+30*24*60*60), 
            'tf_maintenance_complete_percent' => '30',
            'tf_maintenance_content' => '',
            'tf_maintenance_twitter_url' => 'themefuse',
		);

        foreach ($standart_values as $key => $value){
            if ( !array_key_exists( $key, $this->_settings ) )

                $this->_settings[$key] = '';
        }

        foreach ($this->_settings as $key => $value) {
            if ( $value == '' ) $this->_settings[$key] = $standart_values[$key];
        }
    }

    public function maintenance_active(){
        if ( !$this->check_user_capability() && !$this->is_page_url_excluded() )
        {
            nocache_headers();
            header("HTTP/1.0 503 Service Unavailable");
            include('tf_maintenance-maintenance-page.php');
            exit();
        }
    }

    public function check_user_capability()
    {
        if ( is_super_admin() || current_user_can('manage_options') ) return true;

        return false;
    }

    public function is_page_url_excluded()
    {
        foreach ( $this->_exception_urls as $url ){
            if ( strstr( $_SERVER['PHP_SELF'], $url) ) return true;
        }
        if ( strstr($_SERVER['QUERY_STRING'], 'feed=') ) return true;
        return false;
    }

    public function get_option($setting)
    {
        return $this->_settings[$setting];
    }
   
} // end tf_maintenance class

add_action( 'init', 'tf_maintenance_Init', 5 );
function tf_maintenance_Init()
{
    global $TF_maintenance;
    $TF_maintenance = new tf_maintenance();
}

add_filter('admin_head','ShowTinyMCE');
function ShowTinyMCE() {
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}

function tfuse_m_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', TF_MAINTENANCE_WP_PLUGIN_URL_JS.'/wp-upload-tfuse.js?v=2', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}

function tfuse_m_styles() {
	wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'tf_maintenance_options') {
	add_action('admin_print_scripts', 'tfuse_m_scripts');
	add_action('admin_print_styles', 'tfuse_m_styles');
}
?>