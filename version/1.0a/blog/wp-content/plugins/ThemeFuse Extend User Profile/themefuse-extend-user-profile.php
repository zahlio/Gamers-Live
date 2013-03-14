<?php
/*
Plugin Name: ThemeFuse Extend User Profile
Plugin URI: http://themefuse.com
Description: Extend user profile.
Version: 1.0.0
Author: ThemeFuse.com
Author URI: http://themefuse.com
*/

class ThemeFuse_Extend_User_Profile
{

   function ThemeFuse_Extend_User_Profile ( )
    {
        add_action( 'show_user_profile', array($this, 'ThemeFuse_Extend_User_Profile_Page') );
        add_action('profile_update', array($this, 'ThemeFuse_Extend_User_Profile_save') );
        add_action('admin_print_scripts', array($this, 'ThemeFuse_Extend_User_Profile_scripts'));
        add_action('admin_footer',  array($this, 'ThemeFuse_Extend_User_Profile_footer') );
        register_deactivation_hook(__FILE__,array($this, 'ThemeFuse_Extend_User_Profile_uninstall') );
    }

    public function ThemeFuse_Extend_User_Profile_scripts ()
    {
        wp_enqueue_script('jquery');
    }

    private function ThemeFuse_Extend_User_Profile_get_Data ( $id = "" )
    {
      $meta =  get_user_meta($id,'theme_fuse_extends_user_options',TRUE);
      return $meta;
    }

    public function ThemeFuse_Extend_User_Profile_footer ()
    {?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
                jQuery('.field').val('');
                jQuery('.value').val('');
                jQuery('.theme_fuse_add_meta').live('click', function(){
                        var source = jQuery(this).attr('src');
                        source = source.replace("add_icon.png","remove_icon.png");
                        jQuery(this).attr('src',source);
                        $(this).removeClass("theme_fuse_add_meta").addClass("theme_fuse_remove_meta");

                    var $content = '<tr ><td width="132"><input type="text" name="theme_fuse_field[]" width="60px" value=""/></td><td width=\"85\">&nbsp;</td><td width="132"><input type="text" name="theme_fuse_value[]" width="60px" value=""/></td><td width="100"><a href="#"><img class="theme_fuse_add_meta" src=" <?php echo WP_PLUGIN_URL; ?>/themefuse-extend-user-profile/images/add_icon.png"></a></td></tr>';
                    jQuery('#theme_fuse_eup_table tr:last').after($content).fadeIn(500);
                    return false;
                    
                });

            jQuery('.theme_fuse_remove_meta').live('click', function(){
                    var y = jQuery(this).parent().parent().parent().fadeOut(500, function()
                    {
                        jQuery(this).remove();
                    });
                    return false;

                });
        });
        </script>   
    <?php
    }

    public function ThemeFuse_Extend_User_Profile_save ()
    {   global $current_user;
        $inf = array();
        $inf ['facebook'] = $_POST['facebook'];
        $inf ['twitter'] = $_POST['twitter'];
        $inf ['in'] = $_POST['in'];
        $fields = $_POST ['theme_fuse_field'];
        $values = $_POST ['theme_fuse_value'];
        foreach ( $values as $key => $value)
        {
            if ( $fields[$key]=='' || $value == '') continue;
            $inf[$fields[$key]] = $value;
        }

	   update_user_meta($current_user->ID, 'theme_fuse_extends_user_options', $inf);
    }

    public function ThemeFuse_Extend_User_Profile_Page()
    {
      global $current_user;
      $meta = $this-> ThemeFuse_Extend_User_Profile_get_Data ( $current_user->ID );
      
	  echo  "<h3>ThemeFuse Profile Extender</h3>";?>
      <table id ="theme_fuse_eup_table" >

              <?php isset ( $meta['facebook']) ? $value = $meta['facebook'] : $value = '' ?>
              <div id= "theme_fuse_extend_user_profile_filed_1">
                <tr>
                    <td width="132"><label >FaceBook</label></td>
					<td width="85">&nbsp;</td>
                    <td width="132"><input type="text" name="facebook" width="60px" value="<?php echo $value; ?>" /></td>
                </tr>
              </div>

              <?php isset ( $meta['twitter']) ? $value = $meta['twitter'] : $value = '' ?>
              <div id= "theme_fuse_extend_user_profile_filed_2">
                <tr>
                    <td width="132"><label >Twitter</label></td>
					<td width="85">&nbsp;</td>
                    <td width="132"><input type="text" name="twitter" width="60px"value="<?php echo $value; ?>" /></td>
                </tr>
              </div>

              <?php isset ( $meta['in']) ? $value = $meta['in'] : $value = '' ?>
              <div id="theme_fuse_extend_user_profile_filed_3">
                <tr>
                    <td width="132"><label >IN</label></td>
					<td width="85">&nbsp;</td>
                    <td width="132"><input type="text" name="in" width="60px" value="<?php echo $value; ?>" /></td>
                </tr>
              </div>
                <?php
                    if (!$meta) $meta = array();
                    foreach ( $meta as $key => $value )
                           {
                             if ( $key == 'facebook' || $key == 'twitter' || $key == 'in' ) continue; ?>

                               <tr >
                                   <td width="132"><input type="text"  name="theme_fuse_field[]" width="60px" value="<?php echo $key; ?>"/></td>
                                   <td width="85">&nbsp;</td>
                                   <td width="132"><input type="text"  name="theme_fuse_value[]" width="60px" value="<?php echo $value; ?>"/></td>
                                   <td width="100"><a href="#"><img class="theme_fuse_remove_meta" src=" <?php echo WP_PLUGIN_URL; ?>/themefuse-extend-user-profile/images/remove_icon.png"></a></td>
                               </tr>

             <?php  } ?>

                               <tr >
                                   <td width="132"><input type="text"  name="theme_fuse_field[]" width="60px" value=""/></td>
								   <td width="85">&nbsp;</td>
                                   <td width="132"><input type="text"  name="theme_fuse_value[]" width="60px" value=""/></td>
                                   <td width="100"><a href="#"><img class="theme_fuse_add_meta" src=" <?php echo WP_PLUGIN_URL; ?>/themefuse-extend-user-profile/images/add_icon.png"></a></td>
                               </tr>
      </table>
    <?php

    }

    public function ThemeFuse_Extend_User_Profile_uninstall ()
    {   global $current_user;

	   delete_user_meta($current_user->ID, 'theme_fuse_extends_user_options');
    }
}

$ThemeFuse_Extend_User_Profile = new ThemeFuse_Extend_User_Profile ();

?>