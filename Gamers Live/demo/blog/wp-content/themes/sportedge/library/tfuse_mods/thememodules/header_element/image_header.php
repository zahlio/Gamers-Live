<?php
    $tfuse_header_image =true;
    $tfuse_header_bg    =false;

    if ( is_singular())
    {
        $tfuse_type = tfuse_header_parametrs();
        $tfuse_image_header = 'background-image:url('.tfuse_page_options(PREFIX."_".$tfuse_type['type_page']."_image_header_upload", true). ')';
        $tfuse_header_bg    = (tfuse_page_options(PREFIX."_".$tfuse_type['type_page']."_image_header_upload", true) !='')? $tfuse_image_header : false;

    }
    elseif ( is_category())
    {
        $tfuse_image_header = 'background-image:url('.tfuse_options(PREFIX."_category_image_header_",true,false, true). ')';
        $tfuse_header_bg    = (tfuse_options(PREFIX."_category_image_header_",true,false, true) !='')? $tfuse_image_header : false;

    }

    if (!$tfuse_header_bg)
    {
        $tfuse_header_color        = get_option(PREFIX.'_header_colorpicker');
        $tfuse_header_pattern      = get_option(PREFIX.'_header_pattern_background');
        $tfuse_custom_image_header = get_option(PREFIX.'_header_image');

        $tfuse_header_pattern = ( $tfuse_header_pattern == 'none') ? false : get_template_directory_uri().'/images/'.$tfuse_header_pattern;
        $tfuse_header_image   = !empty($tfuse_custom_image_header) ? $tfuse_custom_image_header : $tfuse_header_pattern ;
        $tfuse_header_bg      = ($tfuse_header_image) ? 'background-image:url('.$tfuse_header_image. ')' : 'background:'.$tfuse_header_color;

    }
?>

<!-- header image -->

<div class="header_image" style="<?php echo $tfuse_header_bg ?>">&nbsp;</div>
<!--/ header image -->