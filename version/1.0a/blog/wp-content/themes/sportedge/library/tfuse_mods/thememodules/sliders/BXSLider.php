<!-- slider -->

<div class="header_slider">

    <ul id="slider1" class="bxSlider">
      <?php  $sliderArr = tfuse_slides();

       foreach( $sliderArr as $postdata) :
           $tfuse_target = 'target ='. (!empty($postdata['target']) ? $postdata['target']  : '_self' )?>
      <li style="background: url('<?php echo $postdata['image']; ?>') no-repeat scroll center 0 transparent;">
          <div class="fakeimg"></div>
          <div class="slide-text-wrapper">
            <div class="slide-text-content">
            <div class="meta-date">
                <?php if (!empty($postdata['category'])) { ?><span class="ico_cat"><em><?php echo $postdata['category']; ?></em></span><?php  } ?>
                <?php echo $postdata['date']; ?>
            </div>
            <?php if (!empty($postdata['title']) )
           {  $tfuse_tittle_class = (!empty($postdata['link']) ) ? '' : 'class="slide-title"' ;
               if (!empty($postdata['link']) )
               {  ?>
               <a href="<?php echo $postdata['link'];  ?>" <?php echo $tfuse_target ?> class="slide-title">
           <?php } ?>
                <strong <?php echo $tfuse_tittle_class ?>><?php echo $postdata['title']; ?></strong>
            <?php if (!empty($postdata['link'])) { ?></a><?php }
           } ?>
            <div class="slide-button">
                <?php if (!empty($postdata['link']) ) { ?><a <?php echo $tfuse_target ?> href="<?php echo $postdata['link'];  ?>" class="button_link">
                    <span><?php _e('Read', 'tfuse'); ?></span>
               </a><?php } ?>
                <?php if ($postdata['type'] != 'upload') { ?><a href="<?php comments_link(); ?>" class="link-comments"><?php comments_number('0 comments', '1 comment', '% comments') ?></a><?php } ?>
            </div>
            </div>
        </div>
      </li>
       <?php endforeach; ?>
    </ul>
</div>
<div class="container_title">
<div class="header_title">
    <div class="header_tab_title">
        <a href="#prev" class="slider-prev slidernav" id="go-prev"><?php _e('Prev', 'tfuse'); ?></a><a href="#next" class="slider-next slidernav" id="go-next"><?php _e('Next', 'tfuse'); ?></a>
        <?php    $count = 0; foreach( $sliderArr as $postdata) :
                $pager_active = (!$count) ? ' pager-active' : '';
                if ( ($count+1) < count($sliderArr) )  $tfuse_count = $count+1; else  $tfuse_count = 0;
                $tfuse_next_title =  $sliderArr[$tfuse_count]['title'];
                $count++;
        ?>
            <h1 class="title<?php echo $pager_active ?>"><?php echo $tfuse_next_title; ?></h1>
        <?php endforeach; ?>


    </div>
</div>
</div>

<!--/ slider -->
