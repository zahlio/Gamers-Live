<?php

class AdminInterfaceOptions {
    function AdminInterfaceOptions() {
		wp_enqueue_script('postbox');
    }
			

	function new_admin_meta_boxes()
	{	
		global $post, $adminboxes, $tfuse_admin_custom_options;
		
		if(!isset($adminboxes)) $adminboxes = 0;
		//if(empty($adminboxes)) $adminboxes = 0;
		$adminboxes++;
		$count_boxes = 0;
	
		$custom_options = $tfuse_admin_custom_options;
		
		//calls the helping function based on value of 'type'
		foreach ($custom_options as $option)
		{				
			if($option['type']=='heading') { $count_boxes++; }
	
			if ($option['type']=='heading' and $count_boxes==$adminboxes)
			{
				$box_id = sanitize_title($option['name']);
				//security field
				echo '<input type="hidden" name="'.$box_id.'_noncename" id="'.$box_id.'_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__) ).'" />'; 
			}
			
			if ($option['type']<>'heading' and $option['type']<>'tab' and $count_boxes==$adminboxes)
			{	
	
				//if( tfuse_meta_exist($option['id']) ) $option['std'] = (get_post_meta($post->ID, $option['id'], true));
				if( tfuse_option_exist($option['id']) ) $option['std'] = (tfuse_option_exist($option['id']));
				
				
				$optiona[0] = $option;
	
				echo "\n";
				echo tfuse_options_page_content($optiona);
				echo "\n";
			}	
		}
	}  //END new_admin_meta_boxes()		

	
	/* Tfuse Admin Interface Page */
	function tfuse_create_settings_page(){
		global $tfuse, $prefix, $tfuse_admin_custom_options;
		$prefix = $tfuse->prefix;
	 
	    $options     =  get_option("{$prefix}_template");      
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
	    
	    
	    /* Add the meta boxes for admin area */	
	    $taburi = array();
		$tfuse_admin_custom_options = tfuse_custom_options('admin');
		if ( function_exists('add_meta_box') ) 
		{ 
			foreach ($tfuse_admin_custom_options as $box)
			{
				if ($box['type'] == 'tab')  { $taburi[$box['id']] = $box['name']; $curenttab = $box['id']; }
				if ($box['type'] == 'heading') {
					$boxid = sanitize_title($box['name']);
					add_meta_box($boxid,$box['name'],array(&$this, 'new_admin_meta_boxes'),$curenttab,'normal','core'); 
				}
			}
		}
		
	?>
</strong>

		<style>
		 #contextual-help-link-wrap{
			display: none;
			}
		</style>

<div id="tfuse_fields" class="wrap metabox-holder">

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
		
        <?php $action_response = tfuse_save_admin_options(); ?>
        
        <?php if ( $action_response == 'saved' ) { ?><div class="happy"><?php echo $themename; ?>'s Options has been updated!</div><?php } ?>
        <?php if ( $action_response == 'reset' ) { ?><div class="warning"><?php echo $themename; ?>'s Options has been reset!</div><?php } ?>    
                    
        <?php //Errors
        /* Check if no duplicate id options */
		function check_option_ids() {
			global $admin_options, $post_options, $page_options, $category_options, $all_ids, $tfuse;
			
			$options = array_merge($admin_options, $post_options, $page_options, $category_options);
			
			//update_option("{$tfuse->prefix}_template",$options);
			
			tfuse_array_walk_recursive($options, 'all_ids');
			$all_ids = array_count_values($all_ids);
			
			$errors_print = '';
			foreach($all_ids as $id => $count) {
				if($count>1) $errors_print .= "The ID <b>$id</b> is repeating $count times. <br />";
			}
			return $errors_print;
		}
		
		function all_ids($item, $key) { 
			global $all_ids; 
		    if($key === "id") $all_ids[] = $item;
		}    
        
		if (!isset($errors_print)) $errors_print='';
		$errors_print .= check_option_ids();
        
        $error_occurred = false;
        $upload_tracking = get_option('tfuse_upload_tracking');
        if(!empty($upload_tracking)){
        $output = '<div class="errors"><ul>' . "\n";
            $error_shown == false;
            foreach($upload_tracking as $array )
            {
                 if(array_key_exists('error', $array)){
                        $error_occurred = true;
                        $errors_print .= '<li><strong>' . $array['option_name']. '</strong>: ' .  $array['error'] . '</li>' . "\n";
                }
            }
        } 
        
        if($errors_print<>'') {
        	$error_occurred = true;
        }
        	
        if($error_occurred) {
            $output = '<div class="errors"><ul>' . "\n";
            $output .= $errors_print;
            $output .= '</ul></div>' . "\n";
            echo $output;
        }
            
        delete_option('tfuse_upload_tracking');
        ?>

        
        
        <?php 
        //*****************************************************//
        
        if (!isset($_GET['step'])) $_GET['step']=0;
        if($_GET['step'] == 4) update_option("{$prefix}_installed", 'yes');

        $installed_theme = get_option("{$prefix}_installed");

        if ($installed_theme != 'yes' or $_GET['step'] == 3) {
        
        	$tfuse_import = new TFUSE_Import();
			$tfuse_import->dispatch();
        
			echo "</form>\n";
		?>
			
		<script type='text/javascript'>
		jQuery(document).ready(function(){
			jQuery('#install_btn').click(function(){
				jQuery('.demoinstall, .skipinstall').hide();
				jQuery('.install_loading').show();
			});
		});
		</script>
	
		<?php
        } else {
        	echo '<div style="clear:both;height:20px;"></div>';
        	echo '<form action="'.$_SERVER["REQUEST_URI"].'" method="post"  enctype="multipart/form-data">';

        	wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
			wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
        	
        	$draw_tabs_li = $draw_tabs_div = '';
			foreach ($taburi as $boxid => $boxname) {
				$draw_tabs_li  .= '<li><a href="#tab_'.$boxid.'">'.$boxname.'</a></li>'."\n";
			}
			echo '<div id="tabs">'."\n";
			echo "<ul>\n";
			echo $draw_tabs_li;
			echo "</ul>\n<br />";
			foreach ($taburi as $boxid => $boxname) {
				echo '<div id="tab_'.$boxid.'">'."\n";
				if (!isset($data)) $data='';
				do_meta_boxes($boxid, 'normal', $data);
				echo '</div>'."\n";
			}
			echo'</div>'."\n";

	        //Generate the admin page contet, all input custom data
	        //echo tfuse_options_page_content();
        
        //*****************************************************//
        ?>
        
        <div style="clear:both;"></div>
        <?php  wp_nonce_field('reset_options'); echo "\n"; ?>

        <p class="submit submit-footer">
            <input name="save" type="submit" value="Save All Changes" />
            <input type="hidden" name="tfuse_save" value="save" />
        </p>
    </form>
        
    <form action="<?php echo esc_html( $_SERVER['REQUEST_URI'] ) ?>" method="post">
        <p class="submit submit-footer submit-footer-reset">
        <input name="reset" type="submit" value="Reset Options" class="reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
        <input type="hidden" name="tfuse_save" value="reset" />
        </p>
    </form>
    
    <?php } ?>
    
<div style="clear:both;"></div>    
</div>

        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready( function($) {
                // close postboxes that should be closed
            	jQuery('.postbox').removeClass('if-js-closed').addClass('closed');
                // postboxes setup
                postboxes.add_postbox_toggles('general-settings');
            });
            //]]>
        </script>        

 <?php
}
}

?>