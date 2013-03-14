<?php

// Change this with yours data


if(isset($_POST['email']))
{
		error_reporting(0);	
		$errorC = false;

        $the_blogname   = $_POST['myblogname'];
        $the_myemail 	= base64_decode($_POST['tempcode']);
		$the_email 		= $_POST['email'];
		$the_date_in 	= $_POST['date_in_input'];
		$the_date_out 	= $_POST['date_out_input'];
		$the_type	 	= $_POST['reserv_type'];
		$the_no_adults	= $_POST['reserv_no_adults'];
		$the_no_children= $_POST['reserv_no_children'];

		
		# want to add aditional fields? just add them to the form in template_contact.php,
		# you dont have to edit this file
		
		//added fields that are not set explicit like the once above are combined and added before the actual message
		$already_used = array('email','date_in_input','date_out_input','reserv_no_adults','reserv_no_children','reserv_type','ajax');
		$attach = '';
		
		foreach ($_POST as $key => $field)
		{
			if(!in_array($key,$already_used))
			{
				$attach.= $key.": ".$field."<br /> \n";
			}
		}
		$attach.= "<br /> \n";
		
		if(!checkmymail($the_email))
		{
			$errorC = true;
			$the_emailclass = "error";
		}
        else
        {
			$the_emailclass = "valid";
	    }

		
		if($errorC == false)
		{ 	
			$to      =  $the_myemail;
			$subject = "New Reservations from " . $the_blogname;
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From:'. $the_email  . " \r\n";


			if(!empty($the_email)) 		$the_email 		= "Email:  	$the_email <br/>";
			if(!empty($the_date_in)) 	$the_date_in 	= "Check-in date: $the_date_in <br/>";
			if(!empty($the_date_out)) 	$the_date_out 	= "Check-out date:   $the_date_out <br/>";
			if(!empty($the_type)) 		$the_type 		= "Room type:  	$the_type <br/>";
			if(!empty($the_no_adults)) 	$the_no_adults 	= "No. of adults: $the_no_adults <br/>";
			if(!empty($the_no_children)) $the_no_children = "No. of children: $the_no_children <br/>";
			
			$message = "
			You have a new reservation request! <br/>
			$the_email
			$the_date_in
			$the_date_out
			$the_type
            $the_no_adults
            $the_no_children

            $attach <br />";

            //if(mail($to,$subject,$message,$header)) $send = true; else $send = false;

			ob_start();
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
			$send = mail($to,$subject,$message,$header);
			$buffer = ob_get_contents();
			ob_end_clean();

			if(isset($_POST['ajax'])){

			if ($send)
			echo '<div class="column col-2"><h2>Your message has been sent!</h2><div class="confirm">
					<p class="textconfirm">Thank you for contacting us.<br/>We will get back to you within 2 business days.</p>
				  </div></div>';
			else
			echo '<div class="column col-2"><h2>Oops!</h2><div class="confirm">
					<p class="texterror">Due to an unknown error, your form was not submitted, please resubmit it or try later.</p>
					<code>'.$buffer.'</code>
				  </div></div>';

			}
		}
		
}
	
function checkmymail($mailadresse){
	$email_flag=preg_match("!^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$!",$mailadresse);
	return $email_flag;
}

?>