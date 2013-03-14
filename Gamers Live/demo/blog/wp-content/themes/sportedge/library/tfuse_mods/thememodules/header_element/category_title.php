<?php global $cat_ID, $post;
if (is_category()) $tfuse_cat_title = get_option( PREFIX . '_category_title_searchform_'  . $cat_ID);
elseif ( is_single()) $tfuse_cat_title = get_post_meta($post->ID, PREFIX.  '_post_category_title', true);
if ( $tfuse_cat_title != 'false'): ?>
<!-- category title more -->
<div class="cat_title">
    <?php  require_once(THEME_MODULES .'/searchform.php');?>
    <strong class="title"><span><?php _e('More in', 'tfuse'); echo ' '. get_cat_name(get_query_var('cat'));?></span></strong>
</div>
<!--/ category title more -->
<?php endif; ?>