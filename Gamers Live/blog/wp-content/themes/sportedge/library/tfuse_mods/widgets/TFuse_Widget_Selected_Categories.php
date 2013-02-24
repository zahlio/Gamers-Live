<?php
class TFuse_Walker_Category_Checklist extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	function start_lvl(&$output, $depth, $args) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl(&$output, $depth, $args) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el(&$output, $category, $depth, $args) {
		extract($args);
		if(!is_array($categories)) $categories = array();

		$output .= "\n<li id='{$field_id}-{$category->term_id}' >" . '<input value="'.$category->term_id.'" type="checkbox" name="'.$field_name.'['.$category->term_id.']" id="'.$field_id.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $categories ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '';
	}

	function end_el(&$output, $category, $depth, $args) {
		$output .= "</li>\n";
	}
}



class TFuse_Widget_Selected_Categories extends WP_Widget {

	function TFuse_Widget_Selected_Categories() {
		$widget_ops = array('description' => __( 'Show Selected Categories', 'tfuse') );
		parent::WP_Widget(false, __('TFuse Selected Categories', 'tfuse'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
       
		$title = esc_attr($instance['title']);
		$categories = isset($instance['categories']) ? $instance['categories'] : '' ;
		$c = isset($instance['count']) ? '1' : '0';
        $template = empty( $instance['template'] ) ? '' : $instance['template'];

		$before_widget = '<div id="categories-2" class="widget-container widget_categories '.$template.'">';
		$after_widget = '</div>';
		$before_title = '<h3 class="widget-title">';
		$after_title = '</h3>';		
		
		$post_data= get_category(get_query_var('cat'),false);
        $parent_id = isset($post_data->parent) ? $post_data->parent : '';
        $category_description = isset($post_data->category_description) ? $post_data->category_description : '';

		echo $before_widget;
		
		$title = tfuse_qtranslate($title);
		if ( $title )
			echo $before_title . $title . $after_title;
		?>
		
        
       <?php if ( is_array($categories) ) { ?>

		<ul>
			<?php 
			$k=0;
	        foreach ($categories as $key=>$val) {
				$post_data_curent= get_category(get_query_var('cat'),false);

                $curent_id = isset($post_data_curent->cat_ID) ? $post_data_curent->cat_ID : '';
				$cat = get_category($key);
                if(!$cat) continue;
				$cat_id=$cat->term_id;
				$k++;
				if ($k==1)                  $first = 'first '; else $first = '';
				if ($k==count($categories)) $last  = 'last ';  else $last  = '';
				if ($curent_id == $cat_id) {$active = 'current-menu-item ';} else $active='';
				if($c) $count = ' <span>('.$cat->count.')</span>'; else $count = '';
				echo '<li class="'.$first.$last.$active.'"><a href="' . get_category_link($key) . '"><span>' . get_cat_name( $key ) . $count .'</span></a></li>';
			} ?>
		</ul>
                
	<?php  } ?>
 
	<?php			
	   echo $after_widget;
   }

	function update( $new_instance, $old_instance ) {	
		return $new_instance;
	}

   function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(  'categories' => '','template' => '') );
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$categories = esc_attr($instance['categories']);
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;

		$args['field_name'] = $this->get_field_name('categories');
		$args['field_id'] = $this->get_field_id('categories');
		$args['categories'] = $instance['categories'];
 		?>

       <p>
           <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e( 'Widget Template:' ); ?></label>
           <select name="<?php echo $this->get_field_name('template'); ?>" id="<?php echo $this->get_field_id('template'); ?>" class="widefat">
               <option value="widget_box_white" <?php selected($instance['template'], 'widget_box_white' ); ?>><?php _e('White Widget Backround'); ?></option>
               <option value="no_background" <?php selected( $instance['template'], 'no_background' ); ?>><?php _e('Transparent Widget Background'); ?></option>
           </select>
       </p>


        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','tfuse'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
            <br />
            
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br /><br />
			
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Select Categories List','tfuse'); ?></label>
        </p>
			<div class="categorydiv">
            <ul class="categorychecklist form-no-clear">
            <?php
            $cat_args = array('orderby' => 'name', 'show_count' => 1, 'hierarchical' => 1, 'echo' => 1, 'hide_empty' => 0, 'title_li' => '' ); 

            
             //wp_category_checklist();
             
            $walker = new TFuse_Walker_Category_Checklist;
             
             $categorieslist = (array) get_terms('category', array('get' => 'all'));
             echo call_user_func_array(array(&$walker, 'walk'), array($categorieslist, 0, $args)); 
             
             
            /*
				$tfuse_categories = array();  
				$tfuse_categories_obj = get_categories('hide_empty=0&hierarchical=1');
				if (is_array($tfuse_categories_obj)) {
					foreach ($tfuse_categories_obj as $tfuse_cat) { ?>
                        <?php 
                        if ( esc_attr($instance['categories'][$tfuse_cat->cat_ID]) ) $checked = ' checked="checked" '; else $checked = '';
						?>
                        
						<li><input <?php echo $checked; ?> type="checkbox" name="<?php echo $this->get_field_name('categories'); ?>[<?php echo $tfuse_cat->cat_ID;?>]" value="1" id="<?php echo $this->get_field_id('categories'); ?>" />&nbsp;&nbsp;<?php echo $tfuse_cat->cat_name; ?></li>
                        <?php
 					}
				}*/
			?> 
			</ul>           
		</div>
		<?php
	}
}


register_widget('TFuse_Widget_Selected_Categories');
 
?>