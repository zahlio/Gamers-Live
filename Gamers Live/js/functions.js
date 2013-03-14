// Kameleon Template
//Author: Chris Mooney (http://themeforest.net/user/ChrisMooney)

// Cufon Setup
jQuery(document).ready(function($) {
Cufon.replace('h3,h4,h5,.process,#tagline ');


//Portfolio Hover Effect
	$('.portfolio-small li img, .portfolio-list li img').hover(function() {
		
		$(this).children('a').show();
		$('.portfolio-small li img, .portfolio-list li img').stop().animate({ opacity: .5 }, 300);
		$(this).stop().css('opacity', 1);
		
	}, function() {
		$('.portfolio-small li img, .portfolio-list li img').stop().animate({ opacity: 1 }, 300);
		
	});

//Homepage Screenshot Scroll
$(".scrollable").scrollable();


//LightBox Setup
 $('.portfolio-small a, .portfolio-list a').lightBox({
	 fixedNavigation:true,
	 overlayOpacity: 0.8,
	imageLoading: 'img/lightbox/lightbox-ico-loading.gif',
	imageBtnClose: 'img/lightbox/lightbox-btn-close.gif',
	imageBtnPrev: 'img/lightbox/lightbox-btn-prev.gif',
	imageBtnNext: 'img/lightbox/lightbox-btn-next.gif',
	imageBlank: 'img/lightbox/lightbox-blank.gif'
	 
	 });

// Tipsy Tooltips
$('.tooltip').tipsy({fade: true});
$('.tooltip.north').tipsy({fade: true, gravity: 's'});
$('.tooltip.east').tipsy({fade: true, gravity: 'w'});
$('.tooltip.west').tipsy({fade: true, gravity: 'e'});
// Form Tooltips
$('form [title]').tipsy({fade: true, trigger: 'focus', gravity: 'w'});	

	
	
	
	
	 
}); 
