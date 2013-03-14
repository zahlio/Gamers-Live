<?php  

//get post type (page,post, custom post type ...)
$post_type = tfuse_get_post_type();

if (!isset($_REQUEST['action'])) $_REQUEST['action']='';
if (!isset($_REQUEST['taxonomy'])) $_REQUEST['taxonomy']='';

//create meta_box only if is open for edit or add new post type
if( !empty($post_type) && $_REQUEST['action']!='delete' ) {
	add_action('admin_menu', 'create_meta_box');
	add_action('admin_head', 'add_script_and_styles');
}

if( $_REQUEST['action'] == 'editpost' ) {
	add_action('save_post', 'save_postdata');
}
	
	add_action('create_category', 'save_postdata');
	add_action('edit_category', 'save_postdata');
	
	add_action('delete_post', 'delete_postdata');
	add_action('delete_category', 'delete_postdata');
	
/*
if( !(basename($_SERVER['PHP_SELF']) == "admin-ajax.php" and ($_REQUEST['action'] == 'inline-save' or $_REQUEST['action'] == 'autosave') ) ) {
	add_action('save_post', 'save_postdata');
	
	add_action('create_category', 'save_postdata');
	add_action('edit_category', 'save_postdata');
}
*/

if( $_REQUEST['taxonomy'] == "category" )  {
	if($_REQUEST['action'] == 'edit') {
		add_action('edit_category_form_fields', 'create_detalied_category_meta_box');
	} else {
		add_action('edit_category_form', 'create_category_meta_box');
	}	
}
	


/* add javascript and css files only to the head if these files are called */
function add_script_and_styles() { ?> 

	<style>
	.option {	
		border-color: #FFFFFF #FFFFFF #E6E6E6 !important;
	}
	.desc {
		width: 300px !important;
	}
	body.wp-admin {
		min-width:1150px !important;
	}
	#postcustom {
		display: none;
	}
	</style>

<?php }


	

/* Add the meta boxes to the page/post or link */	
function create_meta_box() 
{  	//echo "BOX<BR>"; //vereficare
	global $tfuse, $post_type, $tfuse_custom_options;
	$themename   =  get_option("{$tfuse->prefix}_themename");

	//get post type (page,post, custom post type ...)
	$post_type = tfuse_get_post_type();

	//get specific options
	$tfuse_custom_options = $options = tfuse_custom_options($post_type);	

	if ( function_exists('add_meta_box') ) 
	{ 
		foreach ($options as $box)
		{
			if ($box['type'] == 'metabox') {
				add_meta_box($box['id'],$themename." - ".$box['name'],'new_meta_boxes',$box['page'],$box['context'], 'high'); 
			}
		}
	}  
}  
	
	
	
function new_meta_boxes()
{	
	global $post, $boxes, $post_type, $tfuse_custom_options;
	
	if(empty($boxes)) $boxes = 0; $boxes++;
	
	$count_boxes = 0;

	$custom_options = $tfuse_custom_options;
	
	$boxes;
	//calls the helping function based on value of 'type'
	foreach ($custom_options as $option)
	{				
		if($option['type']=='metabox') { $count_boxes++; }

		if ($option['type']=='metabox' and $count_boxes==$boxes)
		{
			$box_id = $option['id'];
			//security field
			echo'<input type="hidden" name="'.$box_id.'_noncename" id="'.$box_id.'_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__) ).'" />'; 
		}
		
		if ($option['type']<>'metabox' and $count_boxes==$boxes)
		{	

			if( tfuse_meta_exist($option['id']) ) $option['std'] = (get_post_meta($post->ID, $option['id'], true));
			
			$optiona[0] = $option;

			echo "\n";
			echo tfuse_options_page_content($optiona);
			echo "\n";
		}	
	}
}  //END new_meta_boxes()
	

function save_postdata() 
{

if(basename( $_SERVER['PHP_SELF']) == "admin.php" ||  $_REQUEST['action'] == 'trash')  return;
//die("<br>**SAVE POST DATA**<BR>"); //vereficare

	global  $tfuse, $wpdb, $post_type, $tfuse_custom_options;
	
	if(!isset($_REQUEST['taxonomy'])) 	$_REQUEST['taxonomy'] = '';
	if(!isset($_REQUEST['action'])) 	$_REQUEST['action'] = '';
	if(!isset($_REQUEST['post_ID'])) 	$_REQUEST['post_ID'] = '';
	if(!isset($_REQUEST['tag_ID'])) 	$_REQUEST['tag_ID'] = '';
	
	$post_id = $_REQUEST['post_ID'];
	$cat_id  = $_REQUEST['tag_ID']; // 3.0
	
	if(!isset($cat_id)) $cat_id = $wpdb->insert_id;

	$options = $tfuse_custom_options;
	
	if($_REQUEST['taxonomy'] == "category") $options = get_option("{$tfuse->prefix}_category_options");
	
	if( $_REQUEST['taxonomy'] != "category" && ($post_type == "page" || $post_type == "post") )
	{
		// Verify if user can edit this page/post
		$post_type = $_POST['post_type'];
		if ( !current_user_can( "edit_{$post_type}", $post_id ) ) return $post_id;
	}
	 
	if(!is_array($options) or empty($options)) $options = array();
	
	foreach ($options as $option)
	{
		if($option['type'] == 'metabox') {
			// Verify
			if (!wp_verify_nonce($_POST[$option['id'].'_noncename'], plugin_basename(__FILE__))) 
			{	
				return $post_id;
			}
		}
		
		if($option['type'] <> 'metabox') {
		
			if(is_array($option['type'])) {  
				foreach($option['type'] as $array){
					if($array['type'] == 'text'){
						$array['ids'] = $array['id']."_".$cat_id;
						if($_REQUEST['taxonomy']=="category" && $_REQUEST['action']== "editedtag") $array['id'] = $array['ids'];
						$arraya[0] = $array;
						tfuse_save_options($arraya); 
					}
				}
				continue;
			}
		
			// Save data
			$option['ids'] = $option['id']."_".$cat_id;
			if($_REQUEST['taxonomy']=="category" && $_REQUEST['action']== "editedtag") $option['id'] = $option['ids'];
			$optiona[0] = $option;
			tfuse_save_options($optiona);
		
		}
	} 	
}  // END save_postdata()


function delete_postdata() 
{ 	//die("<br>**DELETE POST DATA**<BR>"); //vereficare
	global $tfuse, $wpdb;
	
	if(!isset($_REQUEST['taxonomy'])) 	$_REQUEST['taxonomy'] = '';
	if(!isset($_REQUEST['action'])) 	$_REQUEST['action'] = '';
	if(!isset($_REQUEST['action2'])) 	$_REQUEST['action2'] = '';
	if(!isset($_REQUEST['delete_tags'])) 	$_REQUEST['delete_tags'] = '';
	if(!isset($_REQUEST['post'])) 		$_REQUEST['post'] = '';
	if(!isset($_REQUEST['delete_all'])) 	$_REQUEST['delete_all'] = '';
	if(!isset($_REQUEST['post_ID'])) 	$_REQUEST['post_ID'] = '';
	if(!isset($_REQUEST['tag_ID'])) 	$_REQUEST['tag_ID'] = '';
	
	
	$post_id = $_REQUEST['post_ID'];
	$cat_id  = $_REQUEST['tag_ID'];
	
	//delete one category
	if(basename($_SERVER['PHP_SELF']) == "admin-ajax.php" && $_REQUEST['taxonomy'] == "category" && $_REQUEST['action'] == "delete-tag") {
	
		$options = get_option("{$tfuse->prefix}_category_options");
		foreach ($options as $option)
		{ 
		
			if($option["type"] == "multicheck") { 
				foreach($option['options'] as $key => $value) {
					if( tfuse_option_exist($option['id']."_".$cat_id."_".$key) ) delete_option( $option['id']."_".$cat_id."_".$key );
				}
			}
			
			if($option["type"] == "multi") {
				$i = 0;
				delete_option( $option['id']."_".$cat_id."_hidden" );
				
				while(tfuse_option_exist( $option['id']."_".$cat_id."_".$i) ) { 
					delete_option( $option['id']."_".$cat_id."_".$i );
					$i++; 
				}
			}
			
			if(is_array($option['type'])) {  
				foreach($option['type'] as $array){
					delete_option( $array['id']."_".$cat_id );
				}
			}

			if( tfuse_option_exist($option['id']."_".$cat_id) ) delete_option( $option['id']."_".$cat_id );
		}
	}
	
	
	//delete more category
	if( $_REQUEST['taxonomy'] == "category" && ($_REQUEST['action'] == "delete" || $_REQUEST['action2'] == "delete") )
	{
		$options = get_option("{$tfuse->prefix}_category_options");

		if ( !is_array($_REQUEST['delete_tags']) ) $delete_ids[] = $_REQUEST['delete_tags'];
		else                                  	   $delete_ids   = $_REQUEST['delete_tags'];
		if ( !is_array($delete_ids) ) 			   $delete_ids 	 = array();

		foreach ($delete_ids as $id)
		{
			foreach ($options as $option)
			{
				if($option["type"] == "multicheck") {
					foreach($option['options'] as $key => $value) {
						if( tfuse_option_exist($option['id']."_".$id."_".$key) ) delete_option( $option['id']."_".$id."_".$key );
					}
				}
				
				if($option["type"] == "multi") { 
					$i = 0;
					delete_option( $option['id']."_".$id."_hidden" );
					
					while(tfuse_option_exist( $option['id']."_".$id."_".$i) ) { 
						delete_option( $option['id']."_".$id."_".$i );
						$i++; 
					}
				}
				
				if(is_array($option['type'])) {  
					foreach($option['type'] as $array){
						delete_option( $array['id']."_".$id );
					}
				}
		
				if( tfuse_option_exist($option['id']."_".$id) ) delete_option( $option['id']."_".$id );
				
			}
		}
	}
	
	//delete posts/pages
	if($_REQUEST['post']<>'' && ($_REQUEST['action'] == "delete" || isset($_REQUEST['delete_all']) ) ) {

		if(isset ($_REQUEST['post_type']) && $_REQUEST['post_type']=='page') 
		{
			$options = get_option("{$tfuse->prefix}_page_options");
		} else 
		{
			$options = get_option("{$tfuse->prefix}_post_options");
		}
		
		if ( !is_array($_REQUEST['post']) ) $delete_ids[] = $_REQUEST['post'];
		else                                $delete_ids   = $_REQUEST['post'];
		if ( !is_array($delete_ids) ) 		$delete_ids   = array();
		
		foreach ($delete_ids as $id)
		{
			foreach ($options as $option)
			{
				if($option["type"] == "multicheck") {
					foreach($option['options'] as $key => $value) {
						if( tfuse_meta_exist($option['id']."_".$key, $id) ) delete_post_meta($id , $option['id']."_".$key, get_post_meta($id , $option['id']."_".$key, true));
					}
				}
				
				if($option["type"] == "multi") { 
					$i = 0;
					delete_option( $option['id']."_".$id."_hidden" );
					
					while(tfuse_meta_exist( $option['id']."_".$i, $id) ) { 
						delete_post_meta($id , $option['id']."_".$i, get_post_meta($id , $option['id']."_".$i, true));
						$i++; 
					}
				}
				
				if(is_array($option['type'])) {  
					foreach($option['type'] as $array){
						delete_option( $array['id']."_".$id );
					}
				}
			
				if( tfuse_meta_exist($option['id'], $id) ) delete_post_meta($id , $option['id'], get_post_meta($id , $option['id'], true));
			}
		}
	}
	
}  // END delete_postdata()


//------------------------------------------------------------------//

function create_category_meta_box() {
	global $category_options; 
	//echo "CAT"; //vereficare

	foreach ($category_options as $option)
	{
		echo '
<div class="form-field">
<label for="'.$option['id'].'">'.$option['name'].'</label>';	

		$optiona[0] = $option;
		echo tfuse_options_page_content($optiona,true);;
		
		echo '
<p>'.$option['desc'].'</p>
</div>';
		
	} //End foreach

	echo "<p class='new_submit'></p><br />\n";

} //END create_category_meta_box()


//------------------------------------------------------------------//

function create_detalied_category_meta_box() {
	global $category_options;
	
	if(!isset($_REQUEST['tag_ID'])) $_REQUEST['tag_ID'] = '';
	$cat_id  = $_REQUEST['tag_ID'];
	
	foreach ($category_options as $option)
	{   
		$option['id'] = $option['id']."_".$cat_id;
		
		if( is_array($option['type']) ) {
			$i = 0;
			foreach($option['type'] as $array){
				if($array['type'] == 'text'){
					$array['id'] = $array['id']."_".$cat_id;
					$option['type'][$i] = $array;
					$i++;
				}
			}
			
		}

		echo '
<tr class="form-field">
<th scope="row" valign="top"><label for="'.$option['id'].'">'.$option['name'].'</label></th><td>';	

		$optiona[0] = $option;
		echo tfuse_options_page_content($optiona,true);
		
		echo '
<div class="description">'.$option['desc'].'</div></td>
</tr>';
		
	} //End foreach

} //END create_detalied_category_meta_box()

?>
