function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function insertWebtreatsLink() {

	var tagtext;

	var style = document.getElementById('style_panel');

/*
	if (style.className.indexOf('current') != -1) {
		var styleid = document.getElementById('style_shortcode').value;
		if (styleid != 0 ){
			tagtext = "["+ styleid + "]Insert your text here[/" + styleid + "]";
		}
		if (styleid != 0 && styleid == 'button' ){
			tagtext = "["+ styleid + " link=\"#\"]Read More[/" + styleid + "]";	
		}
		if (styleid != 0 && styleid == 'toggle' ){
			tagtext = "["+ styleid + " title=\"Toggle Title\"]Insert your text here[/" + styleid + "]";	
		}
		if (styleid != 0 && styleid == 'frame_left' || styleid == 'frame_right' || styleid == 'frame_center' ){
			tagtext = "["+ styleid + "]Insert the full URL path to your image[/" + styleid + "]";	
		}
		if (styleid != 0 && (styleid == 'dropcap1' || styleid == 'dropcap2' ) ){
			tagtext = "["+ styleid + "]A[/" + styleid + "]";
		}

		if (styleid != 0 && styleid == 'check_list' ){
			tagtext = "["+ styleid + "]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/" + styleid + "]";
		}
		if (styleid != 0 && styleid == 'arrow_list' ){
			tagtext = "["+ styleid + "]<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>[/" + styleid + "]";
		}
		if ( styleid == 0 ){
			tinyMCEPopup.close();
		}
	}
*/
	
	if(window.tinyMCE) {
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
