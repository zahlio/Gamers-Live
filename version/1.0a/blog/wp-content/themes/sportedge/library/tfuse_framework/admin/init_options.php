<?php 
	
	/***  Add css and js to admin header  ***/
	// This function is caled from library/admin/admin.php on theme init
	function tfuse_admin_head() { 
	?>
	
		<link href="<?php echo ADMIN_CSS ?>/style.css?v=1" rel="stylesheet" type="text/css" media="screen" /> 
		<link href="<?php echo ADMIN_CSS ?>/ui.all.css" rel="stylesheet" type="text/css" media="screen" /> 
        <link href="<?php echo ADMIN_CSS ?>/colorpicker.css" rel="stylesheet" type="text/css" media="screen" />


	        <script src="<?php echo ADMIN_JS ?>/jquery.ui.core.min.js" type="text/javascript" ></script>
	        <script src="<?php echo ADMIN_JS ?>/jquery.ui.widget.min.js" type="text/javascript" ></script>
	        <script src="<?php echo ADMIN_JS ?>/jquery.ui.tabs.min.js" type="text/javascript" ></script>
	        <script src="<?php echo ADMIN_JS ?>/ajaxupload.js" type="text/javascript" ></script>
		<script src="<?php echo ADMIN_JS ?>/js.js" type="text/javascript" ></script>
        <script src="<?php echo ADMIN_JS ?>/colorpicker.js" type="text/javascript" ></script>
        <script src="<?php echo ADMIN_JS ?>/eye.js" type="text/javascript" ></script>
        <script src="<?php echo ADMIN_JS ?>/layout.js" type="text/javascript" ></script>



		
	<?php 
	}//END tfuse_admin_head()
	

	/*****************************/
	if(!isset($prefix)) $prefix='';
	tfuse_get_prefix($prefix);

?>