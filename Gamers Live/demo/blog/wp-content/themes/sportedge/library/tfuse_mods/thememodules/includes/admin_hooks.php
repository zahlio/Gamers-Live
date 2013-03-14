<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Hook Definitions

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Hook Definitions */
/*-----------------------------------------------------------------------------------*/

// header.php
function tfuse_title() { do_action ( 'tfuse_title' ); }
function tfuse_meta()  { do_action ( 'tfuse_meta' ); }
function tfuse_head()  { do_action ( 'tfuse_head' ); }
function tfuse_logo()  { do_action ( 'tfuse_logo' ); }
function tfuse_menu()  { do_action ( 'tfuse_menu' ); }
function tfuse_sidebar() { do_action ( 'tfuse_sidebar' ); }

// page.php
function tfuse_before_sidebar() { do_action ( 'tfuse_before_sidebar' ); }
function tfuse_after_sidebar() { do_action ( 'tfuse_after_sidebar' ); }
function tfuse_comments() { do_action ( 'tfuse_comments'); }
function tfuse_middle_class() { do_action ( 'tfuse_middle_class'); }


// single.php
function tfuse_post_media() { do_action( 'tfuse_post_media' ); }
function tfuse_post_meta(){ do_action( 'tfuse_post_meta' ); }
function tfuse_post_title() { do_action( 'tfuse_post_title' ); }


// blog.php
function tfuse_category_post_image() { do_action( 'tfuse_category_post_image' ); }

// portfolio.php
function tfuse_portfolio_post_icon() { do_action( 'tfuse_portfolio_post_icon' ); }
function tfuse_gallery_class() { do_action( 'tfuse_gallery_class' ); }
// footer.php
function tfuse_bottom() { do_action( 'tfuse_bottom' ); }
function tfuse_second_bottom() { do_action( 'tfuse_second_bottom' ); }
function tfuse_footer() { do_action( 'tfuse_footer' ); }
function tfuse_contact_footer() { do_action( 'tfuse_contact_footer' ); }
function tfuse_footer_social() { do_action( 'tfuse_footer_social' ); }

// tmeplate_blog.php
function tfuse_pagination_template() { do_action( 'tfuse_pagination_template' ); }
?>