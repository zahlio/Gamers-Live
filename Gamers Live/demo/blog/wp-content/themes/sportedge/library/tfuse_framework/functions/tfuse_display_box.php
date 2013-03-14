<?php

class tfuse_display_box{

	var $runs;
	var $boxname;
	var $placeholder;
	var $prev_image_array;

	function tfuse_display_box($boxname, $placeholder = array(), $default = 3)
	{	

		if(get_option($boxname.'_count') != "")
		{
			$this->runs = get_option($boxname.'_count');
		}
		else
		{
			$this->runs = $default;
		}
		
		$this->boxname = $boxname;
		$this->placeholder = $placeholder;
		
		
	}
		
	
	function display()
	{	
		global $post;	
		
		for($counter = 1; $counter <= $this->runs; $counter++)
		{	
		
			$preview = '';
			switch(get_option($this->boxname.$counter))
  	 		{	
  	 			
	  	 		case 'post':
	  	 		$query_string = "&showposts=1";
	  	 		$offset = 0;
	  	 		
	  	 		#calculate post offset
	  	 		if($counter > 1)
	  	 		{ 
	  	 			for($i = 1; $i < $counter; $i++)
	  	 			{
	  	 				if( get_option($this->boxname.$i) == get_option($this->boxname.$counter) )
	  	 				{
	  	 					if( get_option($this->boxname.$i.'_post') == get_option($this->boxname.$counter.'_post') )
	  	 					{
	  	 					$offset++;
	  	 					}
	  	 				}
	  	 			}
	  	 		}
	  	 		
	  	 		$query_string .= "&offset=".$offset.".&cat=".get_option($this->boxname.$counter.'_post');
	  	 		query_posts($query_string);
	  	 		
				 
	  	 		break;
	  	 		
	  	 		case 'page':
	  	 		$query_string = "page_id=".get_option($this->boxname.$counter.'_page');
	  	 		query_posts($query_string);
	  	 			  	 		
	  	 		break;
	  	 		
	  	 		case 'widget':
	  	 		if (function_exists('dynamic_sidebar') && dynamic_sidebar('Home Page Box  '.$counter)){}
	  	 		break;
	  	 		default:
	  	 		if($counter == $this->runs) { $last_box = 'plast'; } else { $last_box = ''; } 
	  	 		echo '<div class="panel '.$last_box.' " >'."\n";
	  	 		echo $this->placeholder[$counter];
	  	 		echo'</div><!--end widget-->'."\n";
  	 		}
  	 		
  	 		if(	get_option($this->boxname.$counter) == 'page' ||
  	 			get_option($this->boxname.$counter) == 'post')
  	 		{ 
 				if (have_posts()) : 
				while (have_posts()) : the_post(); 

				if($counter == $this->runs) { $last_box = 'plast'; } else { $last_box = ''; }
				$preview = tfuse_get_image('image',290,125,'', 90, null, 'img',1,0,'','',false,false,true);
						
				echo '<div class="panel '.$last_box.' " >'."\n";
				echo '<h2>'.get_the_title().'</h2>'."\n";
				echo '<div class="line"></div>'."\n";
				echo $preview."\n";
				the_content('...read more');
				echo '</div><!--end widget-->'."\n";
				endwhile; 
				endif;
			}
		}
	}
}

			