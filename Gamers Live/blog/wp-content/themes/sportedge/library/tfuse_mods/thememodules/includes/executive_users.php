<?php

$tfuse_user_option = array();

$tfuse_users = get_users('role=editor&fields=ID');

foreach ($tfuse_users as $id):
    $user_info = get_userdata($id);
    
    $tfuse_user_option[$id]['first_name'] = $user_info->first_name;
    $tfuse_user_option[$id]['last_name'] = $user_info->last_name;
    $tfuse_user_option[$id]['description'] = $user_info->description;
    $tfuse_user_option[$id]['twitter'] = ( !empty($user_info->theme_fuse_extends_user_options['twitter']) ) ? $user_info->theme_fuse_extends_user_options['twitter'] : '';
    $tfuse_user_option[$id]['Photo'] = (!empty($user_info->theme_fuse_extends_user_options['Photo'])) ? $user_info->theme_fuse_extends_user_options['Photo'] : '';
endforeach;


?>
<!-- category title more -->
<div class="cat_title">
    <strong class="title"><?php $tfuse_title_ath_box = tfuse_page_options(PREFIX . '_page_authors_box_title', true); ?>
        <span><?php  _e( $tfuse_title_ath_box, 'tfuse'); ?></span>
    </strong>
</div>
<!--/ category title more -->

<div class="row">
    <?php foreach($tfuse_user_option as $tfuse_val): ?>
    <div class="col col_1_4">
    <?php if ( !empty($tfuse_val["Photo"]) )  tfuse_get_image(140,140,'img',$tfuse_val["Photo"], '', false, 'frame_box'); ?>
    <?php if ( !empty($tfuse_val["first_name"])|| !empty($tfuse_val["last_name"]) ) { echo '<strong>'.$tfuse_val["first_name"].' '.$tfuse_val["last_name"].'</strong>'; } ?>
    <?php if ( !empty($tfuse_val["twitter"]) )
    {
        $pattern = '/([@]{1})([a-zA-Z0-9\_]+)/';
        $replace = '<a href="http://twitter.com/\2" target="_blank">\1\2</a>';
        $tweet_user = preg_replace($pattern, $replace, $tfuse_val["twitter"]);
        echo '<p>'.$tweet_user.'</p>';
    }

        if ( !empty($tfuse_val['description']) ) echo '<p>'.$tfuse_val['description'].'</p>'; ?>
    </div>
    <?php endforeach;  ?>
</div>



