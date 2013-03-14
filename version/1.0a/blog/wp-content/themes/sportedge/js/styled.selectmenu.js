// styling selectboxes
	$(function(){
			$('select.select_styled').selectmenu({
				style:'dropdown',
				transferClasses:true
			});
	});
		
	//a custom format option callback
	var addressFormatting = function(text){
		var newText = text;
		//array of find replaces
		var findreps = [
			{find:/^([^\-]+) \- /g, rep: '<span class="ui-selectmenu-item-header">$1</span>'},
			{find:/([^\|><]+) \| /g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
			{find:/([^\|><\(\)]+) (\()/g, rep: '<span class="ui-selectmenu-item-content">$1</span>$2'},
			{find:/([^\|><\(\)]+)$/g, rep: '<span class="ui-selectmenu-item-content">$1</span>'},
			{find:/(\([^\|><]+\))$/g, rep: '<span class="ui-selectmenu-item-footer">$1</span>'}
		];
		
		for(var i in findreps){
			newText = newText.replace(findreps[i].find, findreps[i].rep);
		}
		return newText;
	}