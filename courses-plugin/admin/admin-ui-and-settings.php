<?php
//----------------------------------------------------
//	ADMIN UI & SETTINGS                            
//----------------------------------------------------
//  Changes to the admin area are made here.



// Get the Admin Interfaces
require_once dirname( __FILE__ ) . '/admin_menus.php';


// Change Placeholder text in title field
add_filter( 'enter_title_here', 'cpd_title_placeholder' );
function cpd_title_placeholder( $title ){ /* Add the right label text to the 'title field */
    $screen = get_current_screen();
    if ( 'courses' == $screen->post_type ) {
        $title = 'Course Title'; 
	} else if ( 'presentations' == $screen->post_type ) {
		$title = 'Presentation Title (e.g. March 2012)';
	}
	return $title;
}

// Remove the 'categories' option in courses menu
add_action( 'admin_menu', 'cpd_adjust_the_menu', 999 );
function cpd_adjust_the_menu() {
	
	/* remove_submenu_page() uses the slugs - find them using...
	   global $submenu;
	   var_dump($submenu);*/
	   
	$page = remove_submenu_page( 'edit.php?post_type=courses', 'edit-tags.php?taxonomy=category&amp;post_type=courses' );
}

// Make the categories list longer
add_action('admin_head', 'categories_selection_jquery');
function categories_selection_jquery() {
	echo'
	<script>
		jQuery(function($){
			$("#subjectsdiv #subjects-all").height("auto");
		});
	</script>
	';
}

// Add datepicker (and put in the footer so we can target the presentation page)
add_action('admin_footer', 'cpd_admin_init');
function cpd_admin_init(){
	
	global $post;
	if($post->post_type == 'presentations'){
		
		global $plugin_url;
		wp_enqueue_script('my-jquery', $plugin_url . '/datepicker/js/jquery-1.7.2.min.js'); 
		wp_enqueue_script('datepicker', $plugin_url . '/datepicker/js/jquery-ui-1.8.21.custom.min.js'); 
		wp_enqueue_style('jquery.ui.theme', $plugin_url . '/datepicker/css/smoothness/jquery-ui-1.8.21.custom.css');
		wp_enqueue_script('my-configuration', $plugin_url . '/datepicker/js/my-configuration.js');
	
	}
	
}


// Add the validation scripts (footer so we can target specific pages)
add_action('admin_footer', 'cpd_validator', 999);
function cpd_validator(){
	
	global $post;
	if($post->post_type == 'courses' || $post->post_type == 'presentations'){
		
		
		// page specific validation here...
		wp_enqueue_script('jquery');
		wp_enqueue_script('form_validation', plugins_url('form-validation/jquery.validate.min.js', __FILE__));
		wp_enqueue_script('calibrate', plugins_url('form-validation/calibrate.js', __FILE__));
		
	}
	
}


/* Using a separate taxonomy now....
// Change the 'category' meta-box title to 'Subjects'
add_action('add_meta_boxes','cpd_change_cat_box');
function cpd_change_cat_box() {
	remove_meta_box('categorydiv', 'courses', 'side');
	add_meta_box(
		'subjects',
		__('Subjects'),
		'post_categories_meta_box',
		'courses',
		'side'
	);
}
*/

// Remove categories box from courses admin 
function cpd_remove_categories() {
	remove_meta_box( 'categorydiv' , 'courses' , 'normal' );
}
add_action( 'admin_menu' , 'cpd_remove_categories' );


// Change the courses table to show the linked presentations
add_filter( 'manage_edit-courses_columns', 'cpd_change_courses_table', 10, 2 );
function cpd_change_courses_table( $column ){
 
    $columns = array(
       'title' => 'Course',
       //'categories' => 'Subjects',
       'presentations' => 'Presentations',
       'add presentation' => 'Add Presentation',
       'author' => 'Author',
	   'date' => 'Date',
       'post id' => 'Post ID'
   );
    return $columns;
    
}


// Put content in the course table's new column's fields
add_filter( 'manage_courses_posts_custom_column', 'cpd_change_courses_table_content', 10, 2 );
function cpd_change_courses_table_content ($column_name, $post_id){
 
    switch($column_name){
        case 'presentations':
            $presentations = cpd_get_presentations($post_id);
            $first = true;
            foreach($presentations as $id => $title){
				if(!wp_is_post_revision($id)){
                	if($first){
	                    echo '<a href="post.php?post=' .$id. '&action=edit">' . $title. '</a>';
	                    $first = false;
						
	                }
	                else {
	                    echo ', <a href="post.php?post=' .$id. '&action=edit">' . $title. '</a>';
	                }
				}

            }
            break;
        case 'add presentation':
            echo '<a href="post-new.php?post_type=presentations&course=' . $post_id . '">Add presentation</a>';
            break;
        case 'post id':
            echo $post_id;
            break;
   }
}


// Change Presentations Table to show the related course
add_filter( 'manage_edit-presentations_columns', 'cpd_change_presentations_table', 10, 2 );
function cpd_change_presentations_table( $column ){
 
    $columns = array(
       	'title' => 'Presentation',
       	'course' => 'Course',
		'author' => 'Author',
		'date' => 'Date',
		//'duplicate' => 'Duplicate Presentation',
		'post id' => 'Post ID'
   );
    return $columns;
    
}

// Put content in the presentation table's new column's fields
add_filter( 'manage_presentations_posts_custom_column', 'cpd_change_presentation_table_content', 10, 2 );
function cpd_change_presentation_table_content ($column_name, $post_id){
    
   switch($column_name){
       case 'course':
           $course_id = get_post_meta($post_id,'course_relation', true);
           echo '<a href="post.php?post='. $course_id .'&action=edit">'. get_the_title($course_id) .'</a>';
           break;
       case 'duplicate':
           echo '<a href="">Duplicate Presentation</a>';
           break;
       case 'post id':
           echo $post_id;
           break;
   }
}

// Set amount of revisions saved
define( 'WP_POST_REVISIONS', 6);
?>