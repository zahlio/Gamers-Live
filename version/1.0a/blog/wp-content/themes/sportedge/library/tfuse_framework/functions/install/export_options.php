<?php

	global $wpdb, $tfuse;
	
	$prefix = $tfuse->prefix;
	
	$slug_prefix = sanitize_title(get_option("{$prefix}_themename"));
	
	$content  = "";

	//$options = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE '{$prefix}_%'" );
	
	
	/**********************************  EXPORT UPLOAD DIR LOCATION  **********************************/
	$upload_dir = wp_upload_dir();
	$upload_link = $upload_dir['baseurl'];
	
	$content .= "<item><name>upload_link</name>\r\n<value>".$upload_link."</value>\r\n";
	$content .= "<option>".get_template()."</option>\r\n";
	$content .= "</item>\r\n";

	/**********************************  EXPORT FRONT PAGE OPTION  **********************************/
	$key      = get_option('page_on_front');
	$content .= "<item><name>page_on_front</name>\r\n<value>".$key."</value>\r\n";
	$content .= "<option>pag</option>\r\n";
	$pag 	  = get_page($key);
	if(isset($pag)) $content .= "<slug>".$pag->post_name."</slug>\r\n";
	$content .= "</item>\r\n";

	$key      = get_option('show_on_front');
	$content .= "<item><name>show_on_front</name>\r\n<value>".$key."</value>\r\n";
	$content .= "</item>\r\n";

	$key      = get_option('permalink_structure');
	$content .= "<item><name>permalink_structure</name>\r\n<value>".$key."</value>\r\n";
	$content .= "</item>\r\n";

	$key      = get_option('posts_per_page');
	$content .= "<item><name>posts_per_page</name>\r\n<value>".$key."</value>\r\n";
	$content .= "</item>\r\n";


	/**********************************  EXPORT ADMIN OPTIONS  **********************************/
	
	//exportam din BD fiecare optiune
	$admin_options = get_option("{$prefix}_admin_options");
	
	foreach($admin_options as $option_admin) {
	
		if($option_admin['type'] == 'tab' or !isset($option_admin['id']) or $option_admin['id'] == '') continue;

		//daca optiunea exista in BD se exporta valoare ei
		if(tfuse_option_exist($option_admin['id'])) {
			$content .= "<item><name>".$option_admin['id']."</name>\r\n<value>".get_option($option_admin['id'])."</value>\r\n";
			
			//daca optiunea este de tip categories sau pages se mai adauga un tag care specifica tipul ei
			if(isset($option_admin['install']) && $option_admin['install'] != '') {
				$content .= "<option>".$option_admin['install']."</option>\r\n";
				
				if($option_admin['install'] == 'cat') { $cat = get_category(get_option($option_admin['id'])); $content .= "<slug>".$cat->slug."</slug>\r\n"; }
				if($option_admin['install'] == 'pag') { $pag = get_page(get_option($option_admin['id'])); $content .= "<slug>".$pag->post_name."</slug>\r\n"; }
			}
			
			$content .= "</item>\r\n";
		}
		
		//if type = array
		if(is_array($option_admin['type'])) {
		
			foreach ( $option_admin ['type'] as $array ) {

				if ($array ['type'] == 'text' and tfuse_option_exist($option_admin['id']) ) {
					$content .= "<item><name>".$array ['id']."</name>\r\n<value>".get_option($array ['id'])."</value>\r\n";
					$content .= "</item>\r\n";
				}
			}
		}
		
		
		//pentru optiunea multicheck
		if($option_admin['type'] == 'multicheck') {
		
			foreach($option_admin['options'] as $key => $value) {
			
				if(tfuse_option_exist($option_admin['id']."_".$key)) {
					$content .= "<item><name>".$option_admin['id']."_".$key."</name>\r\n<value>".get_option($option_admin['id']."_".$key)."</value>\r\n";
					$content .= "<type>".$option_admin['type']."</type>\r\n";
					
					if($option_admin['install'] != '') {
						$content .= "<option>".$option_admin['install']."</option>\r\n";
						
						if($option_admin['install'] == 'cat') { $cat = get_category($key); $content .= "<slug>".$cat->slug."</slug>\r\n"; }
						if($option_admin['install'] == 'pag') { $pag = get_page($key); $content .= "<slug>".$pag->post_name."</slug>\r\n"; }
					}
					$content .= "</item>\r\n";
				}
			}
		}
		
		
		//if type = multi
		if($option_admin['type'] == 'multi' and tfuse_option_exist($option_admin['id']."_hidden") ) {
		
			$content .= "<item><name>".$option_admin['id']."_hidden</name>\r\n<value>".get_option($option_admin['id']."_hidden")."</value>\r\n";
			$content .= "</item>\r\n";
			
			for($i=0;$i<get_option($option_admin['id']."_hidden");$i++) {
			
				$content .= "<item><name>".$option_admin['id']."_".$i."</name>\r\n<value>".get_option($option_admin['id']."_".$i)."</value>\r\n";
				
				$install_type = substr(get_option($option_admin['id']."_".$i),0,3);
				$key = substr(get_option($option_admin['id']."_".$i),4);
				
				$content .= "<type>".$option_admin['type']."</type>\r\n";
				$content .= "<option>".$install_type."</option>\r\n";
				
				if($install_type == 'cat') { $cat = get_category($key); $content .= "<slug>".$cat->slug."</slug>\r\n"; }
				if($install_type == 'pag') { $pag = get_page($key); $content .= "<slug>".$pag->post_name."</slug>\r\n"; }
				if($install_type == 'pos') { $pos = get_post($key); $content .= "<slug>".$pos->post_name."</slug>\r\n"; }

				$content .= "</item>\r\n";
				
			}
			
		}
		
		
		//if type = boxes
		if($option_admin['type'] == 'boxes' and tfuse_option_exist($option_admin['id']."_count") ) {
		
			$content .= "<item><name>".$option_admin['id']."_count</name>\r\n<value>".get_option($option_admin['id']."_count")."</value>\r\n";
			$content .= "</item>\r\n";
			
			for($i=1;$i<=get_option($option_admin['id']."_count");$i++) {
			
				$install_type = get_option($option_admin['id'].$i);
			
				$content .= "<item><name>".$option_admin['id'].$i."</name>\r\n<value>".$install_type."</value>\r\n";
				$content .= "</item>\r\n";
				
				if($install_type == 'post') { 
					$key      = get_option($option_admin['id'].$i."_post");
					$content .= "<item><name>".$option_admin['id'].$i."_post</name>\r\n<value>".$key."</value>\r\n";
					$content .= "<option>cat</option>\r\n";
					$cat 	  = get_category($key); 
					$content .= "<slug>".$cat->slug."</slug>\r\n";
					$content .= "</item>\r\n";
				}
				
				if($install_type == 'page') { 
					$key      = get_option($option_admin['id'].$i."_page");
					$content .= "<item><name>".$option_admin['id'].$i."_page</name>\r\n<value>".$key."</value>\r\n";
					$content .= "<option>pag</option>\r\n";
					$pag 	  = get_page($key); 
					$content .= "<slug>".$pag->post_name."</slug>\r\n";
					$content .= "</item>\r\n";
				}

			}
			
		}
		
		
		//if type = slider
		if($option_admin['type'] == 'slider' and tfuse_option_exist($option_admin['id']."_type") ) {
		
			$install_type = get_option($option_admin['id']."_type");
		
			$content .= "<item><name>".$option_admin['id']."_type</name>\r\n<value>".$install_type."</value>\r\n";
			$content .= "</item>\r\n";
			
			if($install_type == 'posts') { 
				$content .= "<item><name>".$option_admin['id']."_posts_tags</name>\r\n<value>".get_option($option_admin['id']."_posts_tags")."</value>\r\n";
				$content .= "</item>\r\n";
			}
			
			if($install_type == 'categories') { 
				$content .= "<item><name>".$option_admin['id']."_categories</name>\r\n<value>".get_option($option_admin['id']."_categories")."</value>\r\n";
				$content .= "<type>".$option_admin['type']."</type>\r\n";
				$content .= "<option>cat</option>\r\n";
				
				$cat_slugs = array();
				$cats = explode(',',get_option($option_admin['id']."_categories"));
				
				foreach ($cats as $key) {
					$cat = get_category($key);
					$cat_slugs[] = $cat->slug;
				}
					
				$content .= "<slug>".implode(',', $cat_slugs)."</slug>\r\n";
				$content .= "</item>\r\n";
			}
			
			if($install_type == 'upload') { 
			
				$img_count = get_option($option_admin['id']."_img_count");
				$content .= "<item><name>".$option_admin['id']."_img_count</name>\r\n<value>".$img_count."</value>\r\n";
				$content .= "</item>\r\n";
				
				for ($i=1;$i<=$img_count;$i++) {
					$content .= "<item><name>".$option_admin['id']."_sliderdata_".$i."</name>\r\n<value>".pk(get_option($option_admin['id']."_sliderdata_".$i))."</value>\r\n";
					$content .= "<type>".$option_admin['type']."</type>\r\n";
					$content .= "<option>array</option>\r\n";
					$content .= "</item>\r\n";
				}
				
			}

		}
		
	} // END foreach (export admin options)
	

	
	/**********************************  EXPORT CATEGORIES OPTIONS  **********************************/
	
	$cat_slug_ids = array();
	$all_categories = (array) get_terms( 'category', 'get=all' ); //echo "<pre>"; print_r($category_ids); echo "</pre>"; 
	foreach ($all_categories as $cat) {
		$cat_slug_ids[$cat->slug] = $cat->term_id;
	}
	
	$category_options = get_option("{$prefix}_category_options");
	
	
	foreach($category_options as $option_category) {
	foreach($cat_slug_ids as $slug => $cat_id) {
		
		if(tfuse_option_exist($option_category['id']."_".$cat_id)) {
			$content .= "<item><name>".$option_category['id']."_".$cat_id."</name>\r\n<value>".get_option($option_category['id']."_".$cat_id)."</value>\r\n";
			$content .= "<slug>".$slug."</slug>\r\n";
			$content .= "<type>category</type>\r\n";		
			$content .= "</item>\r\n";
		}
		
		if($option_category['type'] == 'multicheck') {
		
			foreach ($option_category['options'] as $key => $value) {
			
				if(tfuse_option_exist($option_category['id']."_".$cat_id."_".$key)) {
					$content .= "<item><name>".$option_category['id']."_".$cat_id."_".$key."</name>\r\n<value>".get_option($option_category['id']."_".$cat_id."_".$key)."</value>\r\n";
					$content .= "<slug>".$slug."</slug>\r\n";
					$content .= "<type>category_multicheck</type>\r\n";		
					$content .= "</item>\r\n";
				}
			
			}

		}

	} } // END foreach (export categories options)
	
	
	/**********************************  EXPORT TESTIMONIALS  **********************************/
	
	if(tfuse_option_exist('testimonials_manager')) {
		$content .= "<item><name>testimonials_manager</name>\r\n<value>".pk(get_option('testimonials_manager'))."</value>\r\n";
		$content .= "<type>testimonials</type>\r\n";		
		$content .= "</item>\r\n";
	}

	/**********************************  EXPORT WIDGETS  **********************************/
	
	$widgets = $wpdb->get_results( "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'widget_%'" );
	
	foreach($widgets as $widget) {	
	
		if(tfuse_option_exist($widget->option_name)) {
			//$content .= "<item><name>".$widget->option_name."</name>\r\n<value>".$widget->option_value."</value>\r\n";
			$content .= "<item><name>".$widget->option_name."</name>\r\n<value>".pk(get_option($widget->option_name))."</value>\r\n";			
			$content .= "<type>widget</type>\r\n";		
			$content .= "</item>\r\n";
		}

	}
	
	if(tfuse_option_exist('sidebars_widgets')) {
		$content .= "<item><name>sidebars_widgets</name>\r\n<value>".pk(get_option('sidebars_widgets'))."</value>\r\n";
		$content .= "<type>widget</type>\r\n";		
		$content .= "</item>\r\n";
	}
	
	/**********************************  EXPORT NAVIGATION  **********************************/

    $current_template = get_option('template');
    if(tfuse_option_exist("theme_mods_{$current_template}")) {
        $theme_mods = get_option("theme_mods_{$current_template}");
        $content .= "<item><name>nav_menu_options</name>\r\n<value>".pk($theme_mods)."</value>\r\n";
		$content .= "<type>nav_opt</type>\r\n";
		$content .= "</item>\r\n";
    }
	
	/**********************************  SAVE OPTIONS TO FILE  **********************************/
	
	
	//$upload_dir = wp_upload_dir(); //print_r($upload_dir);	
	//$filename = $upload_dir['path'].'/test_.txt';
	
	$filename = THEME_INSTALL . '/options.txt';

    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $content) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }

    echo "Success";

    fclose($handle);


?>