 
jQuery(document).ready(function(){

	//tfuse_form(); //controls the contact form located in library/tfuse_framework/js/sendmail.js
	tfuse_form1(); //controls the contact form2
	tfuse_form2(); //controls the contact form2

});


function tfuse_form1(){
	var my_error;
	var url = jQuery("input[name=temp_url]").attr('value');
	jQuery(".ajax_form #send").bind("click", function(){
											 
	my_error = false;
	jQuery(".ajax_form input, .ajax_form textarea, .ajax_form radio, .ajax_form select").each(function(i)
	{
				var surrounding_element = jQuery(this);
				var value 				= jQuery(this).attr("value"); 
				var check_for 			= jQuery(this).attr("id");
				var required 			= jQuery(this).hasClass("required"); 

				if(check_for == "email"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
					if(!value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/)){
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");	
					}
				}
				
				if(check_for == "name" || check_for == "message"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
				
					if(value == "" || value == 'Name (required)' || value == 'Type your message' ){ 
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");
					}
				}
				
				if(required && check_for != "name" && check_for != "email" && check_for != "message"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
					if(value == ""){					
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");	
					}
				}
				
				
			   	if(jQuery(".ajax_form input, .ajax_form textarea, .ajax_form radio, .ajax_form select").length  == i+1){
						if(my_error == false){
							jQuery(".ajax_form").slideUp(400);
							
							var $datastring = "ajax=true";
							jQuery(".ajax_form input, .ajax_form textarea, .ajax_form radio, .ajax_form select").each(function(i)
							{
								var $name = jQuery(this).attr('name');	
								var $value = encodeURIComponent(jQuery(this).attr('value'));
								$datastring = $datastring + "&" + $name + "=" + $value;
							});
																
							
							jQuery(".ajax_form #send").fadeOut(100);	
							
							jQuery.ajax({
							   type: "POST",
				   			   url: url+"/library/tfuse_framework/functions/sendmail.php",
							   data: $datastring,
							   success: function(response){
								   jQuery(".ajax_form").before("<div class='ajaxresponse' style='display: none;'></div>");
								   jQuery(".ajaxresponse").html(response).slideDown(400); 
								   jQuery(".ajax_form #send").fadeIn(400);
					   			   jQuery(".ajax_form input, .ajax_form textarea, .ajax_form radio, .ajax_form select").val("");
								}
							});
						} 
					}
			});
			return false;
	});
}


function tfuse_form2(){ 
	var my_error1;
	var url = jQuery("input[name=temp_url1]").attr('value');
	jQuery(".ajax_form1 #send1").bind("click", function(){
												 
	my_error1 = false;
	jQuery(".ajax_form1 input, .ajax_form1 textarea, .ajax_form1 radio, .ajax_form1 select").each(function(i)
	{
				var surrounding_element = jQuery(this);
				var value 				= jQuery(this).attr("value"); 
				var check_for 			= jQuery(this).attr("id");
				var required 			= jQuery(this).hasClass("required"); 

				if(check_for == "email1"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
					if(!value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/)){
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error1 = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");	
					}
				}
				
				if(check_for == "name1" || check_for == "message1" || check_for == "subject1"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
				
					if(value == "" || value == 'Name' || value == 'Message' || value == 'Subject'){ 
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error1 = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");
					}
				}
				
				if(required && check_for != "name1" && check_for != "email1" && check_for != "message1" && check_for != "subject1"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
					if(value == ""){					
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error1 = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");	
					}
				}
				
				
			   	if(jQuery(".ajax_form1 input, .ajax_form1 textarea, .ajax_form1 radio, .ajax_form1 select").length  == i+1){
						if(my_error1 == false){
							jQuery(".ajax_form1").slideUp(400);
							
							var $datastring = "ajax=true";
							jQuery(".ajax_form1 input, .ajax_form1 textarea, .ajax_form1 radio, .ajax_form1 select").each(function(i)
							{
								var $name = jQuery(this).attr('name');	
								var $value = encodeURIComponent(jQuery(this).attr('value'));
								$datastring = $datastring + "&" + $name + "=" + $value;
							});
																
							
							jQuery(".ajax_form1 #send1").fadeOut(100);	
							
							
							jQuery.ajax({
							   type: "POST",
				   			   url: url+"/library/tfuse_framework/functions/sendmail2.php",
							   data: $datastring,
							   success: function(response){
								   jQuery(".ajax_form1").before("<div class='ajaxresponse1' style='display: none;'></div>");
								   jQuery(".ajaxresponse1").html(response).slideDown(400); 
								   jQuery(".ajax_form1 #send1").fadeIn(400);
					   			   jQuery(".ajax_form1 input, .ajax_form1 textarea, .ajax_form1 radio, .ajax_form1 select").val("");
								}
							});
						} 
					}
			});
			return false;
	});
}




function dropdown_menu()
{
	jQuery("#nav a, .subnav a");
	jQuery(" #nav ul ").css({display: "none", opacity:"0.90"}); // fix for opera browser
	
	jQuery("#nav li").each(function()
	{	
		
		var $sublist = jQuery(this).find('ul:first');
		
		jQuery(this).hover(function()
		{	
			$sublist.stop().css({overflow:"hidden", height:"auto", display:"none"}).slideDown(200, function()
			{
				jQuery(this).css({overflow:"visible", height:"auto"});
			});	
		},
		function()
		{	
			$sublist.stop().slideUp(250, function()
			{	
				jQuery(this).css({overflow:"hidden", display:"none"});
			});
		});	
	});
}