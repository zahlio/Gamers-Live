jQuery(document).ready(function(){ 
	tfuse_reservations_form();
});

function tfuse_reservations_form(){ 
	var my_error;
	jQuery("#send").bind("click", function(){
		
	my_error = false;
	jQuery("#reservationForm input, #reservationForm textarea, #reservationForm radio, #reservationForm select").each(function(i)
	{
				var surrounding_element = jQuery(this);
				var value               = jQuery(this).attr("value");
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

				if(required && check_for != "email"){
					surrounding_element.removeClass("error valid");
					baseclases = surrounding_element.attr("class");
					if(value == ""){
						surrounding_element.attr("class",baseclases).addClass("error");
						my_error = true;
					}else{
						surrounding_element.attr("class",baseclases).addClass("valid");
					}
				}


			   if(jQuery("#reservationForm input, #reservationForm textarea, #reservationForm radio, #reservationForm select").length  == i+1){
					if(my_error == false){
						jQuery("#reservationForm p.notice, #reservationForm #send").hide();
                        jQuery("#reservationForm p.sending").show();


						var $datastring = "ajax=true";
						jQuery("#reservationForm input, #reservationForm textarea, #reservationForm radio, #reservationForm select").each(function(i)
						{
							var $name = jQuery(this).attr('name');
							var $value = encodeURIComponent(jQuery(this).attr('value'));
							$datastring = $datastring + "&" + $name + "=" + $value;
						});

						jQuery.ajax({
						   type: "POST",
						   url: "./reservations.php",
						   data: $datastring,
						   success: function(response){
                               jQuery("#reservationForm p.sending, #reservationForm p.notice").hide();
                               if(response=='success') {
                                   jQuery("#reservationForm p.textconfirm").show();
                               } else {
                                   jQuery("#reservationForm p.texterror").show();
                               }
						   }
						});
					}
				}

			});
			return false;
	});
}
