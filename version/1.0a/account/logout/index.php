<?php
session_start(); 
session_destroy();
header( 'Location: '.$conf_site_url.'/account/login/?msg=You have been logged out' ) ;	
exit;
?>