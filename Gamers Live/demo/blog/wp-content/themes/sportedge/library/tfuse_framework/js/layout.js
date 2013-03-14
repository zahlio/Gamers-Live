(function($){
	var initLayout = function() {
		var hash = window.location.hash.replace('#', '');
		var currentTab = $('ul.navigationTabs a')
							.bind('click', showTab)
							.filter('a[rel=' + hash + ']');
		if (currentTab.size() == 0) {
			currentTab = $('ul.navigationTabs a:first');
		}
		showTab.apply(currentTab.get(0));
		$('#colorpickerHolder').ColorPicker({flat: true});
		$('#colorpickerHolder2').ColorPicker({
			flat: true,
			color: '#00ff00',
			onSubmit: function(hsb, hex, rgb) {
				$('#colorSelector2 div').css('backgroundColor', '#' + hex);
			}
		});
		$('#colorpickerHolder2>div').css('position', 'absolute');
		var widt = false;
		$('#colorSelector2').bind('click', function() {
			$('#colorpickerHolder2').stop().animate({height: width ? 0 : 173}, 500);
			widt = !widt;
		});
		
		
		$('.tf_color_select').live('hover', function(){
			$(this).ColorPicker({
			
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val('#'+hex);
				$(el).change();
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			},
			onChange: function (hsb, hex, rgb) {
				$('.tf_color_selected').val('#'+hex).change();			
			}
		})
		});
		
		
		$('.tf_color_select').ColorPicker({
			
			onSubmit: function(hsb, hex, rgb, el) {
				
				$(el).val('#'+hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			},
			onChange: function (hsb, hex, rgb) {
				$('.tf_color_selected').val('#'+hex).change();			
			}
		})
		.live('focus', function(){
			$('.tf_color_selected').removeClass('tf_color_selected');	
			$(this).addClass('tf_color_selected');	
		})
	};
	
	var showTab = function(e) {
		var tabIndex = $('ul.navigationTabs a')
							.removeClass('active')
							.index(this);
		$(this)
			.addClass('active')
			.blur();
		$('div.tab')
			.hide()
				.eq(tabIndex)
				.show();
	};
	
	EYE.register(initLayout, 'init');
})(jQuery)