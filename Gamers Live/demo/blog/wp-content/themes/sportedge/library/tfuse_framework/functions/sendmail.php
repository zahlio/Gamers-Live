<?php

if(isset($_POST['email']))
{
		error_reporting(0);	
		$errorC = false;
	
		$the_blogname   = $_POST['myblogname'];
		$the_myemail 	= base64_decode($_POST['tempcode']);
		$the_email 		= $_POST['email'];
		$the_name 		= $_POST['yourname'];
		$the_message 	= $_POST['message'];

		$the_phone 		= $_POST['phone'];
		$the_fax 		= $_POST['fax'];
		$the_company 	= $_POST['company'];
		$the_website 	= $_POST['website'];
		
		# want to add aditional fields? just add them to the form in template_contact.php,
		# you dont have to edit this file
		
		//added fields that are not set explicit like the once above are combined and added before the actual message
		$already_used = array('email','yourname','message','phone','fax','company','website','myblogname','tempcode','temp_url','ajax');
		$attach = '';
		
		foreach ($_POST as $key => $field)
		{
			if(!in_array($key,$already_used))
			{
				$attach.= $key.": ".$field."<br /> \r\n";
			}
		}
		$attach.= "<br /> \r\n";
		
		if(!checkmymail($the_email))
		{
			$errorC = true;
			$the_emailclass = "error";
		}else{
			$the_emailclass = "valid";
			}
		
		if($the_message == "")
		{
			$errorC = true;
			$the_messageclass = "error";
		}else{
			$the_messageclass = "valid";
			}
		
		if($errorC == false)
		{ 	
			$to      =  $the_myemail;
			$subject = "New Message from " . $the_blogname;
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From:'. $the_email  . " \r\n";
		
			$message1 = nl2br($the_message);

			if(!empty($the_name)) 		$the_name 		= "Name:  	$the_name <br/>";
			if(!empty($the_company)) 	$the_company 	= "Company: $the_company <br/>";
			if(!empty($the_phone)) 		$the_phone 		= "Phone:   $the_phone <br/>";
			if(!empty($the_fax)) 		$the_fax 		= "Fax:  	$the_fax <br/>";
			if(!empty($the_website)) 	$the_website 	= "Website: $the_website <br/>";
			
			$message = "
			You have a new message! <br/>
			$the_name
			$the_company
			$the_phone
			$the_website
			
			$attach <br />
			
			Message: $message1 <br />";
			
			ob_start();
			error_reporting(E_ALL); 
			ini_set('display_errors', 'On');
			$send = mail($to,$subject,$message,$header);
			$buffer = ob_get_contents();
			ob_end_clean();

			//if(@mail($to,$subject,$message,$header)) $send = true; else $send = false;
			
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