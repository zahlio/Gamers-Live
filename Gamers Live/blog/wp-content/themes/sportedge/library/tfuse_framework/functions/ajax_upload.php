<?php

add_action('admin_head', 'tfuse_ajaxuploader');
function tfuse_ajaxuploader() {
	global $post;
?>
	<script type="text/javascript">
jQuery(document).ready(function(){

	jQuery('.upload_button').each(function(){
		var clickedObject = jQuery(this);
		var clickedID = jQuery(this).attr('id');
		new AjaxUpload(clickedID, {
			  action: '<?php echo admin_url("admin-ajax.php"); ?>',
			  name: clickedID, // File upload name
			  data: { // Additional data to send
					action: 'tfuse_ajax_post_action',
					type: 'upload',
					data: clickedID
					<?php if(isset($post->ID)) { echo ", referer:" . $post->ID; } ?>
					<?php $post_type = tfuse_get_post_type(); if(empty($post_type)) $post_type = basename($_SERVER['PHP_SELF']); ?>
					<?php if(basename($_SERVER['PHP_SELF'])) { echo ", page: '" . $post_type ."'"; } ?> },
			  autoSubmit: true, // Submit file after selection
			  responseType: 'json',
			  onChange: function(file, extension){},
			  onSubmit: function(file, extension){
				  if (! (extension && /^(jpg|png|jpeg|gif|ico)$/i.test(extension))){
                      // extension is not allowed
                      alert('Error: invalid file extension');
                      // cancel upload
                      return false;
              		} 
					jQuery('#uploadtext_'+clickedID).text('Uploading'); // change button text, when user selects file	
					this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
					interval = window.setInterval(function(){
						var text = jQuery('#uploadtext_'+clickedID).text();
						if (text.length < 13){	
							jQuery('#uploadtext_'+clickedID).text(text + '.'); 
						}
						else { 
							jQuery('#uploadtext_'+clickedID).text('Uploading'); 
						} 
					}, 200); 
			  },
			  onComplete: function(file, response) {
			  	window.clearInterval(interval);
				jQuery('#uploadtext_'+clickedID).text('');	
				this.enable(); // enable upload button
				
				// If there was an error
			  	if(response.error ){
					var buildReturn = '<span class="upload-error">' + response.error + '</span>';
					jQuery(".upload-error").remove();
					clickedObject.parent().after(buildReturn);
				}
				else{ 
					var isSlider = jQuery("#" + clickedID + "_type").val();
					if(isSlider != 'upload') { 
						var buildReturn = '<img id="image_'+clickedID+'" src="<?php echo get_bloginfo('template_url').'/thumb.php?src=' ?>'+response.url+'&w=150"  />';
						jQuery("#reset_" + clickedID).show();
						jQuery("#uploaded_image_" + clickedID).attr("href",response.url);
						jQuery("#uploaded_image_" + clickedID).html(buildReturn);
						jQuery("#image_" + clickedID).fadeIn();
						jQuery("#uploaded_image_" + clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
					}
					clickedObject.parent().prev('input').val(response.url);
					jQuery(".upload-error").remove();

					
					if(isSlider == 'upload') 
					{
						//multi file add
						// add file to the list
						
						var CounFiles = jQuery("." + clickedID + "_img_count").val();
						CounFiles++;
						jQuery("." + clickedID + "_img_count").val(CounFiles);
	
						var ImgDetails = '<input type="hidden" name="'+clickedID+'_sliderdata['+CounFiles+'][img]" value="'+response.url+'" />';
						ImgDetails += '<table class="added_image"><tr><td width="60px" valign="top">';
						ImgDetails += '<img src="<?php bloginfo('template_url') ?>/thumb.php?src='+response.url+'&w=50" alt="" /><br/><br/><img src="<?php echo ADMIN_IMAGES ?>/drag.png" alt="Drag" title="Drag and Move this item" />';
						ImgDetails += '</td><td valign="top">';
						ImgDetails += '<div>' + file + '<div style="float:right; width:35px;"><a href="#" class="remove" onclick="return false" ><img src="<?php echo ADMIN_IMAGES ?>/bin.gif" alt="Remove" title="Remove" /></a></div></div>';
						
						for ( var i in response.fields.fields )
						{ 
							var field = response.fields.fields[i]; 
							var field_id = field['id'];
							var field_std = field['std'];
							var field_desc = field['desc'];
							
							if(field['type'] == 'text') {
								ImgDetails += '<div><input type="text" name="'+clickedID+'_sliderdata['+CounFiles+']['+field_id+']" value="' + field_std + '" class="slider_text slider_'+field_id+'" title="'+field_desc+'"  /></div>';  
							} else if (field['type'] == 'textarea') {
								ImgDetails += '<div><textarea name="'+clickedID+'_sliderdata['+CounFiles+']['+field_id+']" class="slider_textarea slider_'+field_id+'" title="'+field_desc+'" >' + field_std + '</textarea></div>';  
							} else if (field['type'] == 'select') {
								ImgDetails += '<div><select name="'+clickedID+'_sliderdata['+CounFiles+']['+field_id+']" class="slider_select slider_'+field_id+'" >';
	
								for ( var key in field['options'] )
								{
									var selected = '';
									if(key == field_std) selected = ' selected="selected"';
									ImgDetails += '<option '+ selected +' value="' + key + '" >' + field["options"][key] + '</option>';
								}
								ImgDetails += '</select></div>';  
							}
						}
	
						ImgDetails += '</td></tr></table>';
	
						var FilesList = jQuery('#files_' + clickedID );
						jQuery('<li class="ui-state-default"></li>').prependTo(FilesList).html(ImgDetails);
	
						fields_desc();
					
					}
					
				}		  	
			  }			  
		});		
	});


	jQuery('.reset_button').click(function(){
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');
			var theID = jQuery(this).attr('title');				

			var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
		
			var data = {
				action: 'tfuse_ajax_post_action',
				type: 'image_reset',
				data: theID
				<?php if(isset($post->ID)) { echo ",
				referer:" . $post->ID; } ?>
			};
			
			jQuery.post(ajax_url, data, function(response) {
				var image_to_remove = jQuery('#image_' + theID);
				var button_to_hide = jQuery('#reset_' + theID);
				image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
				button_to_hide.fadeOut();
				clickedObject.parent().prev('input').val('');	
			});
			
			return false; 
	});


	function fields_desc( ) {

		jQuery(".remove").live("click", function(){
			var list = jQuery(this).parents('li').remove();			
		});
		
		jQuery(".slider_text, .slider_textarea").focus(function(){
			var desc = jQuery(this).attr("title");
			var value = jQuery(this).val();
			if(value == desc) {	
				jQuery(this).css("font-style","normal");
				jQuery(this).val("");
			}
		});

		jQuery(".slider_text, .slider_textarea").blur(function(){
			var desc = jQuery(this).attr("title");
			var value = jQuery(this).val();
			if(value == "") {
				jQuery(this).css("font-style","italic");
				jQuery(this).val(desc);
			}
		});

		jQuery(".slider_text, .slider_textarea").each(function(){
			var desc = jQuery(this).attr("title");
			var value = jQuery(this).val();
			if(value=="" || value==desc) {
				jQuery(this).css("font-style","italic");
				jQuery(this).val(desc);
			}
		});

	}

	fields_desc();

	jQuery(".slider").sortable({ cursor: 'move' });
	//jQuery(".slider").disableSelection();

});
	</script>

	<style>
	.slider li {
		border:1px solid #DADADA;
		background-color:#EFEFEF;
		padding:5px;
		margin-bottom:5px;
		margin-top:5px;
		width:530px;
		list-style-type:none;
		font-family:Arial, Helvetica, sans-serif;
		color:#666666;
		font-size:0.8em;
	}
	
	.slider li:hover {
		background-color:#FFF;
		cursor:move;
	}
	.slider .remove {
		cursor:pointer;
		border: none;
	}
	
	</style>
<?php
}
?>