<?php

function TFuse_Unregister_WP_Widget_RSS() {
	unregister_widget('WP_Widget_RSS');       
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_RSS');

?>