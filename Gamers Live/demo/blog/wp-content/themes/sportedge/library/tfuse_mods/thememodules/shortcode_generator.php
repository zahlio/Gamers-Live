<?php

	/* Tfuse Shortcodes Generator Page */
	function tfuse_generate_shortcode_page()
    {
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
	<?php 
	
	//Begin shortcode array
		$shortcodes = array();
		
		if ( is_file(THEME_MODULES.'/shortcodes/drop_cap.php') ) {
			
			$shortcodes['dropcap1'] = array(
				'attr' => array(),
				'content' => TRUE, 
			);
			
			$shortcodes['dropcap2'] = array(
				'attr' => array(),
				'content' => TRUE, 
			);
		}
		
		if ( is_file(THEME_MODULES.'/shortcodes/quotes.php') ) {
		
			$shortcodes['quote_right'] = array(
				'attr' => array(),
				'desc' => array(),
				'content' => TRUE,
			);
				
			$shortcodes['quote_left'] = array(
				'attr' => array(),
				'desc' => array(),
				'content' => TRUE,
			);
				
			$shortcodes['blockquote'] = array(
				'attr' => array(),
				'desc' => array(),
				'content' => TRUE,
			);
			
			$shortcodes['quote_box'] = array(
				'attr' => array(
					'author' => 'text', 
					'profession' => 'text'				
				),
				'desc' => array(
					'author' => 'Enter name & Surname	ex:<strong>Marissa Doe</strong>', 
					'profession' => 'Enter profession or occupation ex:	<strong> Marketing Manager</strong>'				
				),
				'content' => TRUE,
			);
		}

		if ( is_file(THEME_MODULES.'/shortcodes/button.php') ) {
			
			$shortcodes['button'] = array(
				'attr' => array(
					'link' => 'text',
					'style' => 'text',
					'target' => 'text',
                    'class' => 'select'
				),
				'desc' => array(
					'link' => 'Enter URL for button',
					'class' => 'Select style for button',
                    'style' => 'Done your prefered style for button',
					'target' => 'Enter where the new document will be displayed ex: <strong>_blank</strong>',
					),
					'options' => array(
				'button_link btn_pink' => 'Pink',
				'button_link btn_blue' => 'Blue',
				'button_link btn_green' => 'Green',
				'button_link btn_black' => 'Black',
				'button_link btn_purple' => 'Purple',
				'button_link btn_yellow' => 'Yellow',
				),
				'content' => TRUE,
				'content_text' => 'Enter text on button',
			);

		}		
	
		if ( is_file(THEME_MODULES.'/shortcodes/lightbox.php') ) {
	
			$shortcodes['lightbox'] = array(
				'attr' => array(
					'title' => 'text',
					'class' => 'text',
					'style' => 'text',
					'link' => 'text',
					'prettyPhoto' => 'text'
				),
				'desc' => array(
					'link' => 'Enter URL for Lightbox',
					'class' => 'Enter lightbox class',
					'title' => 'Enter your title for lightbox',
                    'style' => 'Done your style',
					'prettyPhoto' => 'Enter one character for show image with prettyPhoto	ex: <strong>1</strong>'
				),
				'content' => TRUE,
				'content_text' => 'Enter content (can be normal text, HTML code or shortcode)',
				);
	
			$shortcodes['lightbox_btn'] = array(
				'attr' => array(
					'title' => 'text',
					'class' => 'text',
					'style' => 'text',
					'link' => 'text',
					'prettyPhoto' => 'text',
				),
				'desc' => array(
					'link' => 'Enter URL for Lightbox Button',
					'class' => 'Enter class for lightbox button',
					'title' => 'Enter your title for lightbox',
                     'style' => 'Done your style',
					'prettyPhoto' => 'Enter one character for show image with prettyPhoto	ex: <strong>1</strong>'

				),
				'content' => TRUE,
				'content_text' => 'Enter content (can be normal text, HTML code or shortcode)',
				);
		}
		
		if ( is_file(THEME_MODULES.'/shortcodes/image_frame.php') ) {
			
			$shortcodes['frame'] = array(
				'attr' => array(
					  'title' => 'text',
					  'link' => 'text',
					  'src' => 'text',
					  'width' => 'text',
					  'height' => 'text',
					  'align' => 'select',
					  'target' => 'text',
					  'style' => 'text'
				 ),
				'desc' => array(
					 'src' => 'Enter image URL',
					 'link' => 'Enter hyperlink URL for image',
					 'align' => 'Select prefered image position',
					 'width' => 'Enter width for image: 250',
					 'height' => 'Enter width for image: 250',	
					 'title' => 'Enter title for this frame',
					 'target' => 'Enter where the image will be displayed, ex: <strong>_blank</strong> or <strong>_self</strong>',
				 	 'style' => 'Preload Image (refresh page to view) ex: <strong> preload </strong>'

				 ),
				 'options' => array(
					'left' => 'Left Position',
					'center' => 'Center Position',
					'right' => 'Right Position',
				),
				'content' => FALSE,
				'content_text' => 'Image Caption',
				);
		}
		
		if ( is_file(THEME_MODULES.'/shortcodes/columns.php') ) {
		

			$shortcodes['col_1_2'] = array(
				'attr' => array('style' => 'text'),
                'desc' => array('style' => 'Enter style for column'),
				'content' => TRUE,

			);
			$shortcodes['col_1_3'] = array(
				'attr' => array('style' => 'text'),
                'desc' => array('style' => 'Enter style for column'),
				'content' => TRUE,

			);
			$shortcodes['col_1_4'] = array(
				'attr' => array('style' => 'text'),
                'desc' => array('style' => 'Enter style for column'),
				'content' => TRUE,

			);
			$shortcodes['col_1_5'] = array(
				'attr' => array('style' => 'text'),
                'desc' => array('style' => 'Enter style for column'),
				'content' => TRUE,

			);
			$shortcodes['col_2_3'] = array(
				'attr' => array(),
				'content' => TRUE,
				'style' => 'text'
			);

			
		}
		
		
	
		if ( is_file(THEME_MODULES.'/shortcodes/video_player.php') ) {
		
			$shortcodes['youtube'] = array(
				'attr' => array(
					'title' => 'text',
					'width' => 'text',
					'height' => 'text',
					'link' => 'text',
				),
				'desc' => array(
					'width' => 'Video width in pixels',
					'height' => 'Video height in pixels',
					'link' => 'Youtube video link something like: <strong>http://www.youtube.com/watch?v=5yB1XPzFzjk</strong>',
					'title' => 'Enter title',

				),
				'content' => FALSE,
				);	
		
			$shortcodes['vimeo'] = array(
				'attr' => array(
					'title' => 'text',
					'width' => 'text',
					'height' => 'text',
					'link' => 'text',
				),
				'desc' => array(
					'width' => 'Video width in pixels',
					'height' => 'Video height in pixels',
					'link' => 'Vimeo video link something like:	<strong>http://vimeo.com/16919307</strong>',
					'title' => 'Enter title',
				),
				'content' => FALSE,
				);	
		}
		
	if ( is_file(THEME_MODULES.'/shortcodes/slides.php') ) {
		
		$shortcodes['slideshow'] = array(
			'attr' => array(
				'width' => 'text',
				'height' => 'text',
				
			),
			'desc' => array(
				'width' => 'Slideshow width in pixels',
				'height' => 'Slideshow height in pixels',
			),
			'content' => TRUE,
			'content_text' => htmlentities('Your Images URL (line by line) ex. /example/photo1.jpg'),
		);
		
		$shortcodes['slideshow_text'] = array(
			'attr' => array(
				'width' => 'text',
				'height' => 'text',
			),
			'desc' => array(
				'width' => 'Slideshow width in pixels',
				'height' => 'Slideshow height in pixels',
			),
			'content' => TRUE,
			'content_text' => htmlentities('Your Images URL (line by line) ex. /example/photo1.jpg'),
		);
	}
	if ( is_file(THEME_MODULES.'/shortcodes/nivo.php') ) {
		$shortcodes['nivoslide'] = array(
			'attr' => array(
				'width' => 'text',
				'height' => 'text',
				'effect' => 'select',
				'pauseTime' => 'text',
			),
			'options' => array(
				'sliceDown' => 'sliceDown',
				'sliceDownLeft' => 'sliceDownLeft',
				'sliceUp' => 'sliceUp',
				'sliceUpLeft' => 'sliceUpLeft',
				'sliceUpDown' => 'sliceUpDown',
				'sliceUpDownLeft' => 'sliceUpDownLeft',
				'fold' => 'fold',
				'fade' => 'fade',
				'random' => 'random',
			),
			'desc' => array(
				'width' => 'Slideshow width in pixels',
				'height' => 'Slideshow height in pixels',
				'effect' => 'The effect parameter can be any of the following',
				'pauseTime' => 'Enter pause time for each slide (in seconds)',
			),
			'content' => TRUE,
			'content_text' => htmlentities('Your Images URL (line by line) ex. /example/photo1.jpg'),
			);
		}
		
	if ( is_file(THEME_MODULES.'/shortcodes/raw.php') ) {
		
		$shortcodes['raw'] = array(
			'attr' => array('title'=>'text'),
			'content' => TRUE,
		);
	}
						
	if ( is_file(THEME_MODULES.'/shortcodes/faq.php') ) {
	
		$shortcodes['faq'] = array(
			'attr' => array(),
			'content' => TRUE,
		);
	
		$shortcodes['faq_question'] = array(
			'attr' => array(),
			'content' => TRUE,
		);
	
		$shortcodes['faq_answer'] = array(
			'attr' => array(),
			'content' => TRUE,
		);
	}							

	if ( is_file(THEME_MODULES.'/shortcodes/list.php') ) {
		
	
		$shortcodes['check_list'] = array(
			'attr' => array(),
			'content' => TRUE,
		);
	
		$shortcodes['delete_list'] = array(
			'attr' => array(),
			'content' => TRUE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/toggle_code.php') ) {
		
		$shortcodes['toggle_content'] = array(
			'attr' => array(
			'title' => 'text',
            'class' => 'text',
			),
			'desc' => array(
				'title'      => 'The title',
                'class'      => 'Enter class for Toggle Content',
			),
			'content' => TRUE,
		);
		$shortcodes['toggle_code'] = array(
			'attr' => array(
			'title' => 'text',
			'brush' => 'text',
			),
			'desc' => array(
				'title'      => 'The title',
				'brush' => 'Enter brush	ex:<strong>plain</strong>',
			),
			'content' => TRUE,
		);
		$shortcodes['code'] = array(
			'attr' => array(
			'brush' => 'text',
			),
			'desc' => array(
				'brush' => 'Enter brush	ex:<strong>plain</strong>',
			),
			'content' => TRUE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/divider.php') ) {
	
		$shortcodes['divider_space'] = array(
			'attr' => array(),
			'content' => FALSE,
		);

        $shortcodes['divider_dots'] = array(
			'attr' => array(),
			'content' => FALSE,
		);

        $shortcodes['divider_dots_full'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
		
		$shortcodes['divider_thin'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
		
		$shortcodes['divider_thin'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
		$shortcodes['divider_space_thin'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
		
		$shortcodes['clear'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
		
		$shortcodes['clearboth'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/rows.php') ) {
	
		$shortcodes['row_box'] = array(
			'attr' => array(
			'style' => 'text',
			),
			'content' => TRUE,
		);
		
		$shortcodes['row'] = array(
			'attr' => array(),
			'content' => TRUE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/link_more.php') ) {
		
		$shortcodes['link_more'] = array(
			'attr' => array('url' => 'text',
			'text' => 'text'),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/title.php') ) {
	
		$shortcodes['title'] = array(
			'attr' => array(
				'title' => 'select',
			),
			'options' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			),
			'desc' => array(
				'title'      => 'The title',
				),
			'content' => TRUE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/testimonials.php') ) {
		
		$shortcodes['testimonials'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/widget.php') ) {
	
		$shortcodes['widget'] = array(
			'attr' => array(),
			'content' => FALSE,			
			'widget_name' => 'text'
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/minigallery.php') ) {
	
		$shortcodes['minigallery'] = array(
			'attr' => array(
				'order'      => 'text',
				'orderby'    => 'text',
				'id'         => 'text',
				'include'    => 'text',
				'exclude'    => 'text',
				'class'    => 'text',
				'pretty'     => 'text',
			),
			'content' => FALSE,	
			'desc' => array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => 33,
				'include'    => '',
				'exclude'    => '',
				'class'    => 'Enter class for minigallery',
				'pretty' => 'Enter one character for show image with prettyPhoto	ex: <strong>1</strong>',
			),
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/framed_tabs.php') ) {
	
		$shortcodes['framed_tabs'] = array(
			'attr' => array(
				'title' => 'text',
				'style' => 'text',
			),
			'content' => TRUE,
			'desc' => array(
				'title'      => 'Enter the title',
				'style'         => 'Enter style for framed tabs',
			),
		);
		
		$shortcodes['tab'] = array(
			'attr' => array(
				'title' => 'Enter title for tab	ex: <strong>Tab 1</strong>', 
			),
			'content' => TRUE,
		);
	}
	
	
		
	
	if ( is_file(THEME_MODULES.'/shortcodes/search.php') ){
	
		$shortcodes['search'] = array(
			'attr' => array(),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/newsletter.php') ) {
	
		$shortcodes['newsletter'] = array(
			'attr' => array(
				'action' => 'text', 
				'title' => 'text', 
				'text' => 'text'
			),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/table.php') ) {
	
		$shortcodes['table'] = array(
			'attr' => array(
				'style' =>'select',
				'shadow' =>'text'
			),
			'desc' => array(
					'style' => 'Enter Style for Table <strong>green</strong>',
					'shadow' => 'Enter font shadow for table  button ex: <strong>1</strong>',
			),
			'options' => array(
				'table_gray' => 'Gray',
				'table_white' => 'White',
				'table_brown' => 'Brown',
				'table_blue' => 'Blue',
				'table_green_apple' => 'Green Apple',
				'table_dark_gray' => 'Dark Gray',
				'table_purple' => 'Purple',
				),
			'content' => TRUE,
		);
	}
	
	
	
	if ( is_file(THEME_MODULES.'/shortcodes/flickr.php') ) {
	
		
		$shortcodes['flickr'] = array(
			'attr' => array(
				'title' => 'text',
				'items' => 'text',
				'flickr_id' => 'text'
			),
			'desc' => array(
				'items' => 'Enter the title	ex:<strong>Flick Images</strong>',
				'items' => 'Enter the number of photos	ex:<strong> 8</strong>',
				'flickr_id' => 'Enter flickr id	ex: <strong> 51362473@N05</strong>'
			),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/chart.php') ) {
	
		$shortcodes['chart'] = array(
			'attr' => array(
				'width' => 'text',
				'height' => 'text',
				'type' => 'select',
				'title' => 'text',
				'data' => 'text',
				'label' => 'text',
				'colors' => 'text',
				'legend' => 'text',
			),
			'options' => array(
				'3dpie' => '3D PIE CHART',
				'pie' => '2D PIE CHART',
				 'line'=> 'LINE CHART',
				'bvs' => 'BAR CHART',
			),
			'desc' => array(
				'width' => 'Enter width of chart ex:<strong>590</strong>',
				'height' => 'Enter height of chart ex:<strong>250</strong>',
				'type' => 'select of chart',
				'title' => 'Eneter the title',
				'data' => 'Enter the value area for parts of chart	ex: <strong>65.671,60.252,31.381,47.092,37.329</strong>',
				'label' => 'Enter the name area for parts of chart 	ex: <strong>Human Resource|Past Military|Current Military</strong>',
				'colors' => 'Enter the colors area for parts of char	ex: <strong>4f762a,2c353d,999999,cccccc</strong>',
				'legend' => 'Enter the legend of charts	ex:<strong>10%25|30%25|20%25</strong>',
			),
			'content' => FALSE,
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/latest_posts.php') ) {
		$shortcodes['latest_posts'] = array(
			'attr' => array(
				
				'items' => 'text',
                'title' => 'text',

			),
				'content' => FALSE,
			'desc' => array(
				
				'items' => 'Enter number post for show them	ex:<strong>5</strong>',
                'title' => 'Done the title'
			),
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/popular_posts.php') ) {
		$shortcodes['popular_posts'] = array(
			'attr' => array(
				
				'title' => 'text',
				'items' => 'text',
			),
				'content' => FALSE,
			'desc' => array(
				
				'title' => 'Shortcode Title',
				'items' => 'Enter number post for show them	ex:<strong>5</strong>'
			),
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/posts.php') ) {
		$shortcodes['latest_popular_posts'] = array(
			'attr' => array(
				
				'items' => 'text',
			),
				'content' => FALSE,
			'desc' => array(
				
				'items' => 'Enter number post for show them	ex:<strong>5</strong>'
			),
		);
	}

	if ( is_file(THEME_MODULES.'/shortcodes/map.php') ) {
		
		$shortcodes['map'] = array(
			'attr' => array(
				'title' => 'text',
				'width' => 'text',
				'height' => 'text',
				'lat' => 'text',
				'long' => 'text',
				'zoom' => 'text',
				'type' => 'text',
				'address' => 'text',
				
			),
			'content' => FALSE,
			'desc' => array(
				'width' => 400,
				'height' => 300,
				'lat' => 0,
				'long' => 0,
				'zoom' => 12,
				'type' => '',
				'address' => '',
				'title' => 'Enter the title',
			),
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/box.php') ) {
		
			$shortcodes['box'] = array(
			'attr' => array(
				'class' => 'text',
				'title' => 'text',
			),
			'content' => TRUE,
			'desc' => array(
				'class' => 'Enter for for box ex: <strong>sb_orange</strong>',
				'title' => 'Box Title',
			),
		);
	}
	
	if ( is_file(THEME_MODULES.'/shortcodes/twitter.php') ) {
		
			$shortcodes['twitter'] = array(
			'attr' => array(
				'username' => 'text',
				'items' => 'text',
				'title' => 'text',
                'post_date' => 'text'
			),
			'content' => FALSE,
			'desc' => array(
				'username' => 'Enter your usermane of twitter',
				'items' => 'Enter number of itmes, ex: 7',
				'title' => 'Enter the title',
                 'post_date' =>  'Show Post Date'
			),
		);
	}
?>	
<script>
jQuery(document).ready(function(){ 
	jQuery('#shortcode_select').change(function() {
  		var target = jQuery(this).val();
  		jQuery('.rm_section').css('display', 'none');
  		jQuery('#div_'+target).css('display', '');
	});	
	
	jQuery('.code_area').click(function() { 
		document.getElementById(jQuery(this).attr('id')).focus();
    	document.getElementById(jQuery(this).attr('id')).select();
	});
	
	jQuery('.button').click(function() { 
		var target = jQuery(this).attr('id');
		var gen_shortcode = '';
  		gen_shortcode+= '['+target;
  		
  		if(jQuery('#'+target+'_attr_wrapper .attr').length > 0)
  		{
  			jQuery('#'+target+'_attr_wrapper .attr').each(function() {
				gen_shortcode+= ' '+jQuery(this).attr('name')+'="'+jQuery(this).val()+'"';
			});
		}
		
		gen_shortcode+= ']\n';
		
		if(jQuery('#'+target+'_content').length > 0)
  		{
  			gen_shortcode+= jQuery('#'+target+'_content').val()+'\n[/'+target+']\n';
  			
  			var repeat = jQuery('#'+target+'_content_repeat').val();
  			for (count=1;count<=repeat;count=count+1)
			{
				if(count<repeat)
				{
					gen_shortcode+= '['+target+']\n';
					gen_shortcode+= jQuery('#'+target+'_content').val()+'\n[/'+target+']\n';
				}
				else
				{
					gen_shortcode+= '['+target+'_last]\n';
					gen_shortcode+= jQuery('#'+target+'_content').val()+'\n[/'+target+'_last]';
				}
			}
  		}
  		
  		jQuery('#'+target+'_code').val(gen_shortcode);
	});
});
</script>

<div style="padding:30px 20px 30px 20px;background:none; width:715px;">
	<h3>Shortcodes Generator</h3>
	<?php
		if(!empty($shortcodes))
		{
	?>
			<strong>Select Shortcode:</strong>
			<select id="shortcode_select">
				<option value="">---Select---</option>
			
	<?php
			foreach($shortcodes as $shortcode_name => $shortcode)
			{
	?>
	
			<option value="<?php echo $shortcode_name; ?>"><?php echo $shortcode_name; ?></option>
	
	<?php
			}
	?>
			</select>
	<?php
		}
	?>
	
	<br/><br/>
	
	<?php
		if(!empty($shortcodes))
		{
			foreach($shortcodes as $shortcode_name => $shortcode)
			{
	?>
	
			<div id="div_<?php echo $shortcode_name; ?>" class="rm_section" style="display:none">
				<div class="rm_title">
					<h3 style="margin-left:15px"><?php echo ucfirst($shortcode_name); ?></h3>
					<div class="clearfix"></div>
				</div>
				
				<div class="rm_input rm_text" style="padding-left:20px">
				
				<!-- img src="<?php echo $plugin_url.'/'.$shortcode_name.'.png'; ?>" alt=""/><br/><br/><br/ -->
				
				<?php
					if(isset($shortcode['content']) && $shortcode['content'])
					{
						if(isset($shortcode['content_text']))
						{
							$content_text = $shortcode['content_text'];
						}
						else
						{
							$content_text = 'Your Content';
						}
				?>
				
				<strong><?php echo $content_text; ?>:</strong><br/>
				<input type="hidden" id="<?php echo $shortcode_name; ?>_content_repeat" value="<?php echo @$shortcode['repeat']; ?>"/>
				<textarea id="<?php echo $shortcode_name; ?>_content" style="width:90%;height:70px" rows="3" wrap="off"></textarea><br/><br/>
				
				<?php
					}
				?>
			
				<?php
					if(isset($shortcode['attr']) && !empty($shortcode['attr']))
					{
				?>
						
						<div id="<?php echo $shortcode_name; ?>_attr_wrapper">
						
				<?php
						foreach($shortcode['attr'] as $attr => $type)
						{
				?>
				
							<?php echo '<strong>'.ucfirst($attr).'</strong>: '.$shortcode['desc'][$attr]; ?><br/>
							
							<?php
								switch($type)
								{
									case 'text':
							?>
							
									<input type="text" id="<?php echo $shortcode_name; ?>_text" style="width:90%" class="attr" name="<?php echo $attr; ?>"/>
							
							<?php
									break;
									
									case 'select':
							?>
							
									<select id="<?php echo $shortcode_name; ?>_select" style="width:25%" class="attr" name="<?php echo $attr; ?>">
									
										<?php
											if(isset($shortcode['options']) && !empty($shortcode['options']))
											{
												foreach($shortcode['options'] as $select_key => $option)
												{
										?>
										
													<option value="<?php echo $select_key; ?>"><?php echo $option; ?></option>
										
										<?php	
												}
											}
										?>							
									
									</select>
							
							<?php
									break;
								}
							?>
							
							<br/><br/>
				
				<?php } //end attr foreach ?>
				
						</div>
				
				<?php } ?>
				<br/>
				
				<input type="button" id="<?php echo $shortcode_name; ?>" value="Generate Shortcode" class="button"/>
				
				<br/><br/><br/>
				
				<strong>Shortcode:</strong><br/>
				<textarea id="<?php echo $shortcode_name; ?>_code" style="width:90%;height:70px" rows="3" readonly="readonly" class="code_area" wrap="off"></textarea>
				
				</div>
				
			</div>
	
	<?php } //end shortcode foreach
		} ?>
	
	</div>
    <div style="clear:both;"></div>
</div>
 <?php } ?>