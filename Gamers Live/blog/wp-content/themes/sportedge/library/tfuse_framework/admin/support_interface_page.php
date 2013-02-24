<?php

	/* Tfuse Support Interface Page */
	function tfuse_create_support_page(){
		global $tfuse;
		$prefix = $tfuse->prefix;
	 
	    $options     =  get_option("{$prefix}_template");      
	    $themeauthor =  get_option("{$prefix}_themeauthor");      
	    $themename   =  get_option("{$prefix}_themename");      
	    $authorurl1  =  get_option("{$prefix}_authorurl1");      
	    $authorurl2  =  get_option("{$prefix}_authorurl2");      
	    $authorname1 =  get_option("{$prefix}_authorname1");      
	    $authorname2 =  get_option("{$prefix}_authorname2");
	    $forumurl	 =  get_option("{$prefix}_forumurl");      
	    $manualurl   =  get_option("{$prefix}_manual"); 
	    
	     
	    $theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
	    $local_version = $theme_data['Version'];
	    $theme_version = '<span class="version">version '. $local_version .'</span>';
	?>
</strong>

		<style>
		 #contextual-help-link-wrap{
			display: none;
			}
		</style>

<div class="wrap" id="tfuse_fields">
		<div style="height:15px;">&nbsp;</div>
		<div class="tfuse_header">
			<div class="header_icon_bg">
				<a href="http://www.themefuse.com" target="_blank" title="Go to ThemeFuse"><img class="header_icon" src="<?php echo ADMIN_IMAGES;?>/thumb.png" width="70%" height="70%" /></a>
			</div>
			<!-- .header_icon_bg -->
			
			<div class="header_text">
				<h3><?php echo $themename; ?></h3>
				<a href="http://www.themefuse.com" target="_blank" title="Go to ThemeFuse"><img src="<?php echo ADMIN_IMAGES;?>/by_tfuse.png" /></a>
				<div class="clear"></div>
				
				<div class="links">
					<a target="_blank" href="<?php echo $manualurl; ?>">Online documentation</a>&nbsp;&nbsp;<span>|</span>&nbsp;&nbsp;<a target="_blank" href="<?php echo $forumurl; ?>">Support Forums</a>
					<?php echo $theme_version; ?>
				</div>
			</div>
			<!-- .header_text -->
			
			<div class="clear"></div>
		</div>
		<!-- .tfuse_fheader -->
	
		<br />
		<div class="support"> 
		<iframe src="http://themefuse.com/pages/support.html" width="746" height="351" scrolling="no" frameBorder="0"></iframe>
		</div>

        <div style="clear:both;"></div>
   
</div>

 <?php
}

?>