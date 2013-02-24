<?php
session_start(); 
session_destroy();
header( 'Location: http://www.gamers-live.net/account/login/?msg=You have been logged out' ) ;	
exit;
?>