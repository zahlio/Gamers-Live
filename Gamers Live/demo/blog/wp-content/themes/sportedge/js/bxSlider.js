var $j = jQuery.noConflict();
   $j(window).load(function () {

 var slider = $j('#slider1').bxSlider({
   controls: false,
   mode: 'vertical',
   speed: 500,
   pause: 5000,
   easing: 'easeOutCubic',
   auto: true,
   autoHover: true,
   onBeforeSlide: function(currentSlide, totalSlides){
            
       $j('div.header_tab_title .title').removeClass('pager-active');
       $j('div.header_tab_title .title:eq('+currentSlide+')').addClass('pager-active');
   }
 });

 $j('#go-prev').click(function(){
   slider.goToPreviousSlide();
   return false;
 });

 $j('#go-next').click(function(){
   slider.goToNextSlide();
   return false;
 });



   });
