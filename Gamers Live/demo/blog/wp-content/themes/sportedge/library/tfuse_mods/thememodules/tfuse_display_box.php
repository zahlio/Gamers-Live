<?php

class tfuse_display_box
{

	var $runs;
	var $boxname;
	var $placeholder;
	var $prev_image_array;

	function tfuse_display_box( $boxname, $placeholder = array(), $default = 3 )
	{

		if(get_option($boxname . '_count') != "")
		{
			$this->runs = get_option($boxname . '_count');
		}
		else
		{
			$this->runs = $default;
		}

		$this->boxname = $boxname;
		$this->placeholder = $placeholder;
	}


	function display( )
	{
		global $post;

		for ($counter = 1; $counter <= $this->runs; $counter++)
		{

			$preview = '';
			switch (get_option($this->boxname . $counter))
			{

				case 'post':
					$query_string = "&showposts=1";
					$offset = 0;

					#calculate post offset
					if($counter > 1)
					{
						for ($i = 1; $i < $counter; $i++)
						{
							if(get_option($this->boxname . $i) == get_option($this->boxname . $counter))
							{
								if(get_option($this->boxname . $i . '_post') == get_option($this->boxname . $counter . '_post'))
								{
									$offset++;
								}
							}
						}
					}

					$query_string .= "&offset=" . $offset . ".&cat=" . get_option($this->boxname . $counter . '_post');
					query_posts($query_string);


					break;

				case 'page':
					$query_string = "page_id=" . get_option($this->boxname . $counter . '_page');
					query_posts($query_string);

					break;

				case 'widget':
					if(function_exists('dynamic_sidebar'))
					{
						if($counter == 1)
						{
							echo '<div class="wrapper">
	    					  <div class="content"> 
	            			  <div class="home-text">' . "\n";
							dynamic_sidebar('Home Page Box ' . $counter);
							echo  '</div></div></div>' . "\n";
						}
						else
						{
							echo '<div class="navigation">' . "\n";
							dynamic_sidebar('Home Page Box ' . $counter);
							echo '</div>' . "\n";
						}
					}
					break;
				default:

					echo $this->placeholder[$counter];

			}

			if(get_option($this->boxname . $counter) == 'page' || get_option($this->boxname . $counter) == 'post')
			{

				if($counter == 1)
				{

					if(have_posts()) :
						echo '<div class="wrapper">
		    					  <div class="content"> 
		            			  <div class="home-text">
		            			  <div class="widget box-white">' . "\n";
						while(have_posts()) : the_post();
						echo '<h3>' . get_the_title() . '</h3>' . "\n";
						echo $preview . "\n";
						the_excerpt();
						endwhile;
						echo  '</div></div></div></div>' . "\n";
					endif;

				}
				else
				{

					if(have_posts()) :
						echo '<div class="navigation">
		 						  <div class="widget box-white">' . "\n";
						while(have_posts()) : the_post();
						echo '<h3>' . get_the_title() . '</h3>' . "\n";
						echo $preview . "\n";
						the_excerpt();
						endwhile;
						echo '</div></div>' . "\n";
					endif;

				}

			}
		}
	}
}