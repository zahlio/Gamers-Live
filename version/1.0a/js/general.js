$(document).ready(function() {

 		$.preloadCssImages();
	
		$(".dropdown ul").parent("li").addClass("parent");
		$(".dropdown li:first-child, .pricing_box li:first-child").addClass("first");
		$(".dropdown li:last-child, .pricing_box li:last-child").addClass("last");
		$(".dropdown li:only-child").removeClass("last").addClass("only");	
		$(".dropdown .current-menu-item, .dropdown .current-menu-ancestor").prev().addClass("current-prev");		

		$("ul.tabs").tabs("> .tabcontent", {
			tabs: 'li', 
			effect: 'fade'
		});
		
	$(".recent_posts li:odd").addClass("odd");
	$(".popular_posts li:odd").addClass("odd");
	$(".widget-container li:even").addClass("even");
	
// cols
	$(".row .col:first-child").addClass("alpha");
	$(".row .col:last-child").addClass("omega"); 	


// toggle content
	$(".toggle_content").hide(); 
	
	$(".toggle").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});
	
	$(".toggle").click(function(){
		$(this).next(".toggle_content").slideToggle(300,'easeInQuad');
	});
	
	$(".table-pricing tr:even").addClass("even");

// gallery
	$(".gl_col_2 .gallery-item::nth-child(2n)").addClass("nomargin");
	
// pricing
	$(".pricing_box li.price_col").css('width',$(".pricing_box ul").width() / $(".pricing_box li.price_col").size());

// buttons	
	if (!$.browser.msie) {
		$(".button_styled, .btn-share").hover(function(){
			$(this).stop().animate({"opacity": 0.85});
		},function(){
			$(this).stop().animate({"opacity": 1});
		});
	}

});
// scroll to top
$(function () {  
     $(window).scroll(function () {  
         if ($(this).scrollTop() != 0) {  
             $('.link-top').fadeIn();  
         } else {  
             $('.link-top').fadeOut();  
         }  
     });  
     $('.link-top').click(function () {  
         $('body,html').animate({  
             scrollTop: 0  
         },  
         1500);  
     });  
 });
// search field animation
$(function(){
    var input = $('.top_search input#s');
    var divInput = $('.top_search .input');
    var width = divInput.width();
    var outerWidth = divInput.parent().width() - (divInput.outerWidth() - width) - 28;
    var submit = $('#searchSubmit');
    var txt = input.val();
    
    input.bind('focus', function() {
        if(input.val() === txt) {
            input.val('');
        }
        $(this).animate({color: '#6d6d6d'}, 300); // text color
        $(this).parent().animate({
            width: outerWidth + 'px',
            backgroundColor: '#e9e9e9', // background color
            paddingRight: '10px'
        }, 300, function() {
            if(!(input.val() === '' || input.val() === txt)) {
                if(!($.browser.msie && $.browser.version < 9)) {
                    submit.fadeIn(300);
                } else {
                    submit.css({display: 'none'});
                }
            }
        }).addClass('focus');
    }).bind('blur', function() {
        $(this).animate({color: '#646464'}, 300); // text color
        $(this).parent().animate({
            width: width + 'px',
            backgroundColor: '#000', // background color
            paddingRight: '10px'
        }, 300, function() {
            if(input.val() === '') {
                input.val(txt)
            }
        }).removeClass('focus');
        if(!($.browser.msie && $.browser.version < 9)) {
            submit.fadeOut(100);
        } else {
            submit.css({display: 'none'});
        }
    }).keyup(function() {
        if(input.val() === '') {
            if(!($.browser.msie && $.browser.version < 9)) {
                submit.fadeOut(300);
            } else {
                submit.css({display: 'none'});
            }
        } else {
            if(!($.browser.msie && $.browser.version < 9)) {
                submit.fadeIn(300);
            } else {
                submit.css({display: 'none'});
            }
        }
    });
});