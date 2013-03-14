<?php

 	//THEME INFO
	$themeauthor = "<a target=_blank href='http://themefuse.com'>ThemeFuse</a> - ";
	$authorurl1  = "";
	$authorurl2  = "";
	$authorname1 = "ThemeFuse";
	$authorname2 = "";
	$forumurl	 = "http://themefuse.com/forum/sportedge-wp";
	$themename   = "Sportedge";
	$manualurl   = "http://themefuse.com/wp-docs/sportedge/";

	$prefix		 = sanitize_title($themename);

	update_option("{$prefix}_themename",	$themename);
	update_option("{$prefix}_themeauthor",	$themeauthor);
	update_option("{$prefix}_authorurl1",	$authorurl1);
	update_option("{$prefix}_authorurl2",	$authorurl2);
	update_option("{$prefix}_authorname1",	$authorname1);
	update_option("{$prefix}_authorname2",	$authorname2);
	update_option("{$prefix}_forumurl",		$forumurl);
	update_option("{$prefix}_manual",		$manualurl);

	add_action('admin_head', 'tfuse_admin_head_advanced');
	function tfuse_admin_head_advanced() {
	?>
		<script src="<?php echo THEME_URI ?>/library/tfuse_mods/options/advanced.js" type="text/javascript" ></script>
	<?php
	}




?>