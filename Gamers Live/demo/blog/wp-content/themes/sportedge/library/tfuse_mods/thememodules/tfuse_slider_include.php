<?php  function tfuse_slider_include() {

    $tfuse_param = tfuse_header_parametrs();

        if ( $tfuse_param['header_element'] == 'type1' )  { require_once( THEME_MODULES.'/sliders/BXSLider.php' ); }

    elseif ( $tfuse_param['header_element'] == 'type2' || $tfuse_param['header_element'] == '') { require_once( THEME_MODULES.'/header_element/image_header.php' ); }
}
?>