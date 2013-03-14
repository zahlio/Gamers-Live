<?php
function tfuse_map($atts) {

	//extract short code attr
	extract(shortcode_atts(array('width' => 590, 'height' => 365, 'lat' => 0, 'long' => 0, 'zoom' => 12,
		                         'type' => '','address' => '','title' => ''), $atts)); ?>


<?php
    $return ='';
if ( $title != '' ) $return .= '<h2>'.html_entity_decode($title).'</h2>';
$tfuse_rand = rand(0,1000);
 if ($type == 'map1' || $type=='')
 {
    $return .= '<script type="text/javascript">
    var $j = jQuery.noConflict();
    $j(window).load(function(){
        $j("#map1'.$tfuse_rand.'").gMap({
            markers: [{
                latitude: '.$lat.',
                longitude: '. $long .'}],
            zoom: '.$zoom.'
            });
    });
</script>';

 }
 elseif ($type == 'map2')
 {
$return .= '<script type="text/javascript">
    var $j = jQuery.noConflict();
    $j(window).load(function(){
        $j("#map2'.$tfuse_rand.'").gMap({
            markers: [{
                latitude: '.$lat .',
                longitude: '.$long .'}],
            maptype: google.maps.MapTypeId.HYBRID,
            zoom: '. $zoom.'
            });
    });
</script>';
 }
 elseif ($type == 'map3')
 {
$return .= '<script type="text/javascript">
    var $j = jQuery.noConflict();
    $j(window).load(function(){
        $j("#map3'.$tfuse_rand.'").gMap({
            markers: [{
                latitude: '.$lat.',
                longitude: '. $long.',
                html: "'.$address.'",
                title: "",
                popup: true}],
            zoom: '. $zoom .'
            });
    });
</script>';
 }
$return .= '<div id="'.$type.$tfuse_rand.'" class="map frame_box" style="width: '.$width.'px; height: '.$height .'px; border: 1px solid #ccc; overflow: hidden;"></div>';

 return $return;
}
add_shortcode('map', 'tfuse_map');
?>
