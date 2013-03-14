<?php

class tfuse_breadcrumb {
	
	var $breadcrumb = array();
	var $prefix;
	var $suffix;

	function tfuse_breadcrumb($prefix = '', $suffix = '', $curent = true, $display = true) {
		global $wp_query, $post;
		
		$this->prefix = $prefix;
		$this->suffix = $suffix;
		
		
		if ( is_page() ) {
		
			$page_ID = $post->ID;
			if($curent) {
				$key = "pag_".$page_ID;
				$parent[$key] = $this->prefix.'<a href="'.get_permalink($page_ID).'" >'.get_the_title($page_ID).'</a>'.$this->suffix;
				$this->breadcrumb = array_merge($parent, $this->breadcrumb);
			}
			$this->tfuse_page_parents ($page_ID);
		
		} else if ( is_category() ) {
		
			$cat_ID = get_query_var('cat');
			if($curent) {
				$key = "cat_".$cat_ID;
				$parent[$key] =  $this->prefix.'<a href="'.get_category_link($cat_ID).'" >'. get_cat_name($cat_ID).'</a>'.$this->suffix;
				$this->breadcrumb = array_merge($parent, $this->breadcrumb);
			}
			$this->tfuse_category_parents ($cat_ID);	
		
		} else if ( is_single() ) {
		
			$post_ID = $post->ID;
			$post_parent_id = $this->tfuse_post_parents ($post_ID);
			$key = "cat_".$post_parent_id;
			$parent[$key] =  $this->prefix.'<a href="'.get_category_link($post_parent_id).'" >'. get_cat_name($post_parent_id).'</a>'.$this->suffix;
			$this->breadcrumb = array_merge($parent, $this->breadcrumb);

			$this->tfuse_category_parents ($post_parent_id);	

		} else if ( is_tag() ) {
			$this->breadcrumb['tag'] = $this->prefix.'<a href="#">Tag Archives: '.single_tag_title('', false).'</a>'.$this->suffix;
		} else if ( is_author() ) {
			$this->breadcrumb['author'] = $this->prefix.'<a href="#">Archive by Author</a>'.$this->suffix;
		} else if ( is_year() ) {
			$this->breadcrumb['year'] = $this->prefix.'<a href="#">Archive for '.get_the_time('Y').'</a>'.$this->suffix;
		} else if ( is_month() ) {
			$this->breadcrumb['month'] = $this->prefix.'<a href="#">Archive for '.get_the_time('F, Y').'</a>'.$this->suffix;
		} else if ( is_day() ) {
			$this->breadcrumb['day'] = $this->prefix.'<a href="#">Archive for '.get_the_time('F jS, Y').'</a>'.$this->suffix;
		}
		
		return $this->breadcrumb;

	}	
	
	
	
	function tfuse_page_parents ($id) {
	
		$post_data = get_post($id);
		if ($post_data->post_parent) {
			$page_parent_id = $post_data->post_parent;
			$key = "pag_".$page_parent_id;
			$parent[$key] = $this->prefix.'<a href="'.get_permalink($page_parent_id).'" >'.get_the_title($page_parent_id).'</a>'.$this->suffix;
			$this->breadcrumb = array_merge($parent, $this->breadcrumb);
			$this->tfuse_page_parents ($page_parent_id);
	    }
		
	}	
	
	
	function tfuse_category_parents ($id) {
	
		$category_data = get_category($id);
		if ($category_data->parent) {
			$category_parents_id = $category_data->parent;
			$key = "cat_".$category_parents_id;;
			$parent[$key] = $this->prefix.'<a href="'.get_category_link($category_parents_id).'" >'. get_cat_name($category_parents_id).'</a>'.$this->suffix;
			$this->breadcrumb = array_merge($parent, $this->breadcrumb);
			$this->tfuse_category_parents ($category_parents_id);
	    }
		
	}
	
	
	function tfuse_post_parents ($id) {
		
		//verificam categoriile la care este atasat acest post si selectam prima categorie care este in navigation sau submenu
	
		$nav_categories = $this->tfuse_navigation_category(); //categoriile care sunt in navigation
		$incategories = wp_get_post_categories( $id ); //categoriile la care este atasat acest post
		foreach($nav_categories as $cat) {
			$descendants = get_term_children( (int) $cat, 'category');
			if ( in_category( $cat ) ) { 
				$result[] = $cat;
			} else if ( in_category( $descendants ) ) {
				$result = array_intersect($descendants,$incategories);
				$result = array_values($result);
			}
		}
		return $post_parent_id = $result[0];
		
	}
	

	function tfuse_navigation_category () {
		
		$nav_categories = array();
		$nav_count = get_option(PREFIX.'_navigation_hidden');
		for($i=0;$i<$nav_count;$i++) {
			$nav_val = get_option(PREFIX.'_navigation_'.$i);
			$nav_val = explode('_',$nav_val);
			if($nav_val[0] == 'cat') $nav_categories[] = $nav_val[1];
		}
		return $nav_categories;
	}	
	
}

?>