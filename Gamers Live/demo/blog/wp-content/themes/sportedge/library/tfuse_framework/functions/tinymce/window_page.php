<?php

// Bootstrap file for getting the ABSPATH constant to wp-load.php
require_once('config.php');

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here"));
	
	global $tfuse, $prefix;
	$prefix = $tfuse->prefix;
	$themename   =  get_option("{$prefix}_themename");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $themename .' Shortcode'; ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/library/tfuse_framework/functions/tinymce/tinymce.js"></script>
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('style_shortcode').focus();" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="shortcode" action="#">
	<div class="tabs">
		<ul>
			<li id="style_tab" class="current"><span><a href="javascript:mcTabs.displayTab('style_tab','style_panel');" onmousedown="return false;"><?php echo 'Styles Shortcode'; ?></a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="height:142px;">	
		<!-- style_panel -->
		<div id="style_panel" class="panel current">
		<br />
		<fieldset>
			<legend>Select the Style Shortcode you would like to insert.</legend>
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="style_shortcode">Select Custom Shortcode:</label></td>
            <td><select id="style_shortcode" name="style_shortcode" style="width: 200px">
                <option value="0">No Shortcode</option>
				<?php
				if(is_array($shortcode_tags)) {
					foreach ($shortcode_tags as $webtreats_sc_key => $webtreats_sc_value) {
						if($webtreats_sc_key !='tab' &&  preg_match('/tfuse/', $webtreats_sc_value) ) {
							$webtreats_sc_name = str_replace('tfuse_', '' ,$webtreats_sc_value);
							$webtreats_sc_name = str_replace('_', ' ' ,$webtreats_sc_name);
							$webtreats_sc_name = ucwords($webtreats_sc_name);
							echo '<option value="' . $webtreats_sc_key . '" >' . $webtreats_sc_name . '</option>' . "\n";
						}
					}
				}
				?>
            </select></td>
          </tr>
        </table>
		</fieldset>
		</div>
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php echo "Cancel"; ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php echo "Insert"; ?>" onclick="insertWebtreatsLink();" />
		</div>
	</div>
</form>
</body>
</html>
