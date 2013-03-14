jQuery(document).ready(function($) {
								
	$('.tfuse_upload_button').click(function()
	{
		var btnid = $(this).attr('id'); 
		var formfield = $(this).prev('input').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		ff(formfield);
		return false;
	});

	function ff(formfield){
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			jQuery('input[name="'+formfield+'"]').val(imgurl);
			tb_remove();
		}
	}
});
