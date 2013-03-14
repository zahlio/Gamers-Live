       <div class="grid_8">
            <?php
               echo '<h3>' . tfuse_options(PREFIX.'_footer_menu_name',true,true) .'</h3>';

                require_once( THEME_MODULES . '/page-nav-footer.php' );
                if (  tfuse_options(PREFIX.'_footer_shortcodes', true) )
                {
                    tfuse_area_shortcodes(PREFIX.'_footer_shortcodes');
                }
            ?>
        </div><!-- /.grid_8 -->

        <div class="grid_4">
            <?php dynamic_sidebar('Footer 2'); ?>
        </div><!-- /.grid_4 -->

