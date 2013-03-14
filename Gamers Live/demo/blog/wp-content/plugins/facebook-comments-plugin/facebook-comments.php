<?php
/*
Plugin Name:  Facebook Comments
Plugin URI:   http://3doordigital.com/wordpress/plugins/facebook-comments/?utm_source=WordPress&utm_medium=Admin&utm_campaign=Facebook%2BComments
Description:  Facebook comments can be annoying to set up. This plugin makes it simple to add the Facebook comments system to your WordPress site without any hassle. You can also insert the comment box as a shortcode into any post, page or template and use your own settings for each time you do it!
Version:      2.0.5
Author: Alex Moss
Author URI: http://alex-moss.co.uk/
License: GPL v3

Copyright (C) 2010-2010, Alex Moss - alex@3doordigital.com
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Alex Moss or pleer nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) )
	require 'class-admin.php';
else
	require 'class-frontend.php';

// Add settings link on plugin page
function fb_link($links) {
  $settings_link = '<a href="options-general.php?page=fbcomments">Settings</a>';
  array_unshift($links, $settings_link);
  return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'fb_link' );
?>