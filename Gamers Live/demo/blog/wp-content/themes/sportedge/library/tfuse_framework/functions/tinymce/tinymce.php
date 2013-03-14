<?php

class add_tinymce_buttons {

	var $pluginname = 'tfuse_shortcode';

	function add_tinymce_buttons()  {
		// Set path to editor_plugin.js
		//$this->path = get_template_directory_uri() . '/lib/admin/tinymce/';	
		
		// Modify the version when tinyMCE plugins are changed.
		//add_filter('tiny_mce_version', array (&$this, 'change_tinymce_version') );
	
		// init process for button control
		add_action('init', array (&$this, 'addbuttons') );
	}
	
	function addbuttons() {

		//$post_type = tfuse_get_post_type();
		// Verify if user can edit this page/post
		//if ( !current_user_can("edit_{$post_type}") )  return;

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
				add_filter("mce_external_plugins", array (&$this, 'add_tinymce_plugin' ), 5);
				add_filter('mce_buttons', array (&$this, 'register_button' ), 5);
				add_filter('mce_external_languages', array (&$this, 'add_tinymce_langs_path'));
		}
	}
	
	function register_button($buttons) {
		array_push($buttons, 'separator', $this->pluginname );
		return $buttons;
	}

	// Load the TinyMCE plugin
	function add_tinymce_plugin($plugin_array) {
		$plugin_array[$this->pluginname] = THEME_URI . '/library/tfuse_framework/functions/tinymce/editor_plugin.js';
	    return $plugin_array;
	}
	
	// Load the TinyMCE language file
	function add_tinymce_langs_path($plugin_array) {
		$plugin_array[$this->pluginname] = THEME_FUNCTIONS . '/tinymce/langs.php';
		return $plugin_array;
	}

}

if(is_admin())
{
	//$tinymce_buttons = new add_tinymce_buttons ();
}





function tfuse_add_shortcode() {
	global $shortcode_tags;

	$option_select_shorcode = "";
	if(is_array($shortcode_tags)) {
		foreach ($shortcode_tags as $webtreats_sc_key => $webtreats_sc_value) {
			if($webtreats_sc_key !='tab' && @preg_match('/tfuse/', $webtreats_sc_value) ) {
				$webtreats_sc_name = str_replace('tfuse_', '' ,$webtreats_sc_value);
				$webtreats_sc_name = str_replace('_', ' ' ,$webtreats_sc_name);
				$webtreats_sc_name = ucwords($webtreats_sc_name);
				$option_select_shorcode .= '<option value="' . $webtreats_sc_key . '" >' . $webtreats_sc_name . '</option>';
			}
		}
	}
	
	$select_shorcode = "<select id=\"style_shortcode_html\" name=\"style_shortcode\" style=\"width: 150px\" onchange=\"insertWebtreatsLinkHtml()\"><option value=\"0\">Add Shortcode</option>$option_select_shorcode</select>";

?>		
		<script type="text/javascript">
			jQuery(function() {
				jQuery('#ed_toolbar').append('<?php echo $select_shorcode; ?>');
			});

			jQuery.fn.extend({
				insertAtCaret: function(myValue){
				  this.each(function(i) {
				    if (document.selection) {
				      this.focus();
				      sel = document.selection.createRange();
				      sel.text = myValue;
				      this.focus();
				    }
				    else if (this.selectionStart || this.selectionStart == '0') {
				      var startPos = this.selectionStart;
				      var endPos = this.selectionEnd;
				      var scrollTop = this.scrollTop;
				      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
				      this.focus();
				      this.selectionStart = startPos + myValue.length;
				      this.selectionEnd = startPos + myValue.length;
				      this.scrollTop = scrollTop;
				    } else {
				      this.value += myValue;
				      this.focus();
				    }
				  })
				}
			});

			
			function insertWebtreatsLinkHtml() {
				
				var tagtext;

					var styleid = document.getElementById('style_shortcode_html').value;
					if (styleid != 0 ){
						tagtext = "["+ styleid + "]Insert your text here[/" + styleid + "]";
					}
					
					<?php if( is_file(  THEME_MODULES 	. '/shortcode.php')) require_once( THEME_MODULES 	. '/shortcodejs.php' );?>
					jQuery('#content').insertAtCaret(tagtext); 
			}
			
		</script>
<?php	
}
add_action('admin_print_footer_scripts', 'tfuse_add_shortcode', 100);


?>