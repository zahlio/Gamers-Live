jQuery(document).ready(function() {

	var options = new Array();

    //******* PAGES *******//
    options['sportedge_page_select_header_element'] = jQuery('#sportedge_page_select_header_element').val();
	jQuery('#sportedge_page_select_header_element').bind('change', function() {
		options['sportedge_page_select_header_element'] = jQuery(this).val();
		tfuse_toggle_options(options);
	});

    options['sportedge_page_select_type_slider'] = jQuery('#sportedge_page_select_type_slider').val();
	jQuery('#sportedge_page_select_type_slider').bind('change', function() {
		options['sportedge_page_select_type_slider'] = jQuery(this).val();
		tfuse_toggle_options(options);
	});

    
    //-------------------------------------------------//
    options['sportedge_page_featured_tabs'] 	 = jQuery('#sportedge_page_featured_tabs').attr('checked')?1:0;
    options['sportedge_page_bottom_boxes'] 	 = jQuery('#sportedge_page_bottom_boxes').attr('checked')?1:0;
    options['sportedge_page_authors_box'] 	 = jQuery('#sportedge_page_authors_box').attr('checked')?1:0;

	jQuery('#sportedge_page_featured_tabs').bind('change', function() {
		options['sportedge_page_featured_tabs'] = jQuery(this).attr('checked')?1:0;
		tfuse_toggle_options(options);
	});

	jQuery('#sportedge_page_bottom_boxes').bind('change', function() {
		options['sportedge_page_bottom_boxes'] = jQuery(this).attr('checked')?1:0;
		tfuse_toggle_options(options);
	});

	jQuery('#sportedge_page_authors_box').bind('change', function() {
		options['sportedge_page_authors_box'] = jQuery(this).attr('checked')?1:0;
		tfuse_toggle_options(options);
	});



	//******* POSTS *******//
    options['sportedge_post_select_header_element'] = jQuery('#sportedge_post_select_header_element').val();
	jQuery('#sportedge_post_select_header_element').bind('change', function() {
		options['sportedge_post_select_header_element'] = jQuery(this).val();
		tfuse_toggle_options(options);
	});

    options['sportedge_post_select_type_slider'] = jQuery('#sportedge_post_select_type_slider').val();
	jQuery('#sportedge_post_select_type_slider').bind('change', function() {
		options['sportedge_post_select_type_slider'] = jQuery(this).val();
		tfuse_toggle_options(options);
	});

    //-------------------------------------------------//
    options['sportedge_post_bottom_posts'] 	 = jQuery('#sportedge_post_bottom_posts').attr('checked')?1:0;

	jQuery('#sportedge_post_bottom_posts').bind('change', function() {
		options['sportedge_post_bottom_posts'] = jQuery(this).attr('checked')?1:0;
		tfuse_toggle_options(options);
	});


	//******* Categories *******//
    var tag_ID = jQuery('input[name="tag_ID"]').val();
	if(tag_ID)
	{
        options['sportedge_category_select_header_element'] = jQuery('#sportedge_category_select_header_element_'+tag_ID).val();
        jQuery('#sportedge_category_select_header_element_'+tag_ID).bind('change', function() {
            options['sportedge_category_select_header_element'] = jQuery(this).val();
            tfuse_toggle_options(options);
        });

        options['sportedge_category_type_slider'] = jQuery('#sportedge_category_type_slider_'+tag_ID).val();
        jQuery('#sportedge_category_type_slider_'+tag_ID).bind('change', function() {
            options['sportedge_category_type_slider'] = jQuery(this).val();
            tfuse_toggle_options(options);
        });
	}

    //-------------------------------------------------//
    options['sportedge_category_featured_tabs'] 	 = jQuery('#sportedge_category_featured_tabs_'+tag_ID).attr('checked')?1:0;

	jQuery('#sportedge_category_featured_tabs_'+tag_ID).bind('change', function() {
		options['sportedge_category_featured_tabs'] = jQuery(this).attr('checked')?1:0;
		tfuse_toggle_options(options);
	});



	tfuse_toggle_options(options);

	function tfuse_toggle_options(options)
    {

		//******* PAGES *******//
        jQuery('#sportedge_page_select_type_slider, #sportedge_page_image_header_upload, #sportedge_page_slider_cat, ' +
             '#sportedge_page_number_post, #sportedge_page_slider_posts_0, #sportedge_page_slider_data_upload').parents('.option-inner').hide();

		if(options['sportedge_page_select_header_element'] == 'type1')
		{
            jQuery('#sportedge_page_select_type_slider, #sportedge_page_slide_tab_title').parents('.option-inner').show();
            if(options['sportedge_page_select_type_slider'] == 'typeslider4')
            {
                jQuery('#sportedge_page_slider_posts_0').parents('.option-inner').show();
            }
            else if(options['sportedge_page_select_type_slider'] == 'typeslider3')
            {
                jQuery('#sportedge_page_number_post').parents('.option-inner').show();
            }
            else if(options['sportedge_page_select_type_slider'] == 'typeslider2')
            {
                jQuery('#sportedge_page_slider_data_upload').parents('.option-inner').show();
            }
            else if(options['sportedge_page_select_type_slider'] == 'typeslider1')
            {
                jQuery('#sportedge_page_slider_cat, #sportedge_page_number_post').parents('.option-inner').show();
            }

        }
        else if(options['sportedge_page_select_header_element'] == 'type2')
		{
            jQuery('#sportedge_page_image_header_upload').parents('.option-inner').show();
		}

        jQuery('#sportedge_page_tab_name_recent, #sportedge_page_tab_name_popular, #sportedge_page_tab_name_most_commented, ' +
             '#sportedge_page_tab_number_posts').parents('.option-inner').hide();


        if( options['sportedge_page_featured_tabs'] )
		{
            jQuery('#sportedge_page_tab_name_recent, #sportedge_page_tab_name_popular, #sportedge_page_tab_name_most_commented, ' +
                 '#sportedge_page_tab_number_posts').parents('.option-inner').show();
        }

        jQuery('#sportedge_page_bottom_cat_0, #sportedge_page_btm_number_posts').parents('.option-inner').hide();

        if( options['sportedge_page_bottom_boxes'] )
		{
            jQuery('#sportedge_page_bottom_cat_0, #sportedge_page_btm_number_posts').parents('.option-inner').show();
        }

        jQuery('#sportedge_page_authors_box_title').parents('.option-inner').hide();

        if( options['sportedge_page_authors_box'] )
		{
            jQuery('#sportedge_page_authors_box_title').parents('.option-inner').show();
        }


		//******* POSTS *******//
        jQuery('#sportedge_post_slide_tab_title, #sportedge_post_select_type_slider, #sportedge_post_image_header_upload, #sportedge_post_slider_cat, ' +
             '#sportedge_post_number_post, #sportedge_post_slider_posts_0, #sportedge_post_slider_data_upload').parents('.option-inner').hide();

		if(options['sportedge_post_select_header_element'] == 'type1')
		{
            jQuery('#sportedge_post_select_type_slider, #sportedge_post_slide_tab_title').parents('.option-inner').show();
            if(options['sportedge_post_select_type_slider'] == 'typeslider4')
            {
                jQuery('#sportedge_post_slider_posts_0').parents('.option-inner').show();
            }
            else if(options['sportedge_post_select_type_slider'] == 'typeslider3')
            {
                jQuery('#sportedge_post_number_post').parents('.option-inner').show();
            }
            else if(options['sportedge_post_select_type_slider'] == 'typeslider2')
            {
                jQuery('#sportedge_post_slider_data_upload').parents('.option-inner').show();
            }
            else if(options['sportedge_post_select_type_slider'] == 'typeslider1')
            {
                jQuery('#sportedge_post_slider_cat, #sportedge_post_number_post').parents('.option-inner').show();
            }

        }
        else if(options['sportedge_post_select_header_element'] == 'type2')
		{
            jQuery('#sportedge_post_image_header_upload').parents('.option-inner').show();
		}

        jQuery('#sportedge_post_bottom_number').parents('.option-inner').hide();

        if( options['sportedge_post_bottom_posts'] )
		{
            jQuery('#sportedge_post_bottom_number').parents('.option-inner').show();
        }


		//******* CATEGORIES *******//
		if(tag_ID)
		{

            jQuery('#sportedge_category_type_slider_'+tag_ID+', #sportedge_category_slider_posts_'+tag_ID+'_0'+
            ',#sportedge_category_image_header_'+tag_ID+'_upload, #sportedge_category_number_post_'+tag_ID+
            ', #sportedge_category_slider_cat_'+tag_ID+', #sportedge_category_slide_tab_title_'+tag_ID).parents('.form-field').hide();

            if(options['sportedge_category_select_header_element']=='type1')
            {
                jQuery('#sportedge_category_type_slider_'+tag_ID+', #sportedge_category_slide_tab_title_'+tag_ID).parents('.form-field').show();

                if(options['sportedge_category_type_slider']=='typeslider1')
                {
                    jQuery('#sportedge_category_slider_cat_'+tag_ID+', #sportedge_category_number_post_'+tag_ID).parents('.form-field').show();
                }
                else if(options['sportedge_category_type_slider']=='typeslider2')
                {
                    jQuery(' #sportedge_category_number_post_'+tag_ID).parents('.form-field').show();
                }

                else if(options['sportedge_category_type_slider']=='typeslider3')
                {
                    jQuery(' #sportedge_category_slider_posts_'+tag_ID+'_0').parents('.form-field').show();
                }
            }
            else if(options['sportedge_category_select_header_element']=='type2')
            {
                jQuery('#sportedge_category_image_header_'+tag_ID+'_upload').parents('.form-field').show();
            }

            jQuery('#sportedge_category_tab_name_recent_'+tag_ID+', #sportedge_category_tab_name_popular_'+tag_ID +
            ',#sportedge_category_tab_name_most_commented_'+tag_ID+', #sportedge_category_tab_number_posts_'+tag_ID).parents('.form-field').hide();


            if( options['sportedge_category_featured_tabs'] )
            {
                jQuery('#sportedge_category_tab_name_recent_'+tag_ID+', #sportedge_category_tab_name_popular_'+tag_ID +
                ',#sportedge_category_tab_name_most_commented_'+tag_ID+', #sportedge_category_tab_number_posts_'+tag_ID).parents('.form-field').show();
            }

            
		}

	}
});