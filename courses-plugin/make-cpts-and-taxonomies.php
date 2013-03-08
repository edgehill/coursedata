<?php
/* -----------------------------------------------------*/
/*  MAKE CPT's & TAXONOMIES                   			*/
/* -----------------------------------------------------*/



#-------------------------------------------
#  MAKE CUSTOM POST TYPES                   
#-------------------------------------------

add_action( 'init', 'cpd_create_post_type' ); 
function cpd_create_post_type() {
	
	// Make 'Courses'
	register_post_type( 'courses',
		array(
			'labels' => array(
				'name' => __( 'CPD Courses' ),
				'singular_name' => __( 'Course' ),
			    'add_new' => _x('Add New Course', 'course'),  
    			'add_new_item' => __('Add New CPD Course'),  
    			'edit_item' => __('Edit CPD Course'),  
    			'new_item' => __('Add New Course'),  
    			'all_items' => __('View Courses'),  
				'view_item' => __('View Course'),  
				'search_items' => __('Search Course'),  
				'not_found' =>  __('No Courses found'),  
				'not_found_in_trash' => __('No Courses found in Trash'),  
				'parent_item_colon' => '',  
				'menu_name' => 'CPD Courses'
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'cpd-modules'),
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'revisions', 'thumbnail'),
			'taxonomies' => array('category')
		)
	);
	
	// Make 'Presentation'
	register_post_type( 'presentations',
		array(
			'labels' => array(
				'name' => __( 'CPD Presentations' ),
				'singular_name' => __( 'Presentation' ),
			    'add_new' => _x('Add New Presentation', 'presentation'),  
    			'add_new_item' => __('Add New CPD Presentation'),  
    			'edit_item' => __('Edit CPD Presentation'),  
    			'new_item' => __('Add New Presentation'),  
    			'all_items' => __('View Presentations'),  
				'view_item' => __('View Presentation'),  
				'search_items' => __('Search Presentation'),  
				'not_found' =>  __('No Presentations found'),  
				'not_found_in_trash' => __('No Presentations found in Trash'),  
				'parent_item_colon' => '',  
				'menu_name' => 'CPD Presentations'
			),
			'public' => true,
			'has_archive' => true,
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'revisions')
		)
	);
}

#-------------------------------------------
#  MAKE TAXONOMIES                 
#-------------------------------------------

// Make the subjects taxonomy (like categories)

add_action( 'init', 'create_subjects_taxonomies', 0 );
function create_subjects_taxonomies() {
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name' => _x( 'Subjects', 'taxonomy general name' ),
		'singular_name' => _x( 'Subject', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Subjects' ),
		'all_items' => __( 'All Subjects' ),
		/*'parent_item' => __( 'Parent Subject' ),
		'parent_item_colon' => __( 'Parent Subject:' ),*/
		'edit_item' => __( 'Edit Subject' ), 
		'update_item' => __( 'Update Subject' ),
		'add_new_item' => __( 'Add New Subject' ),
		'new_item_name' => __( 'New Subject Name' ),
		'menu_name' => __( 'Subjects' ),
	); 	
	
	register_taxonomy(
		'subjects', 
		'courses', array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'subject' ),
		)
	);
}


// Make the keywords taxonomy (uses taggings)

add_action( 'init', 'make_keywords_taxonomy');

function make_keywords_taxonomy(){
	register_taxonomy(
		'keywords',
		'courses',
		array(
			'label' => __( 'Keywords' ),
			'rewrite' => array( 'slug' => 'keywords' ),
			'update_count_callback' => '_update_post_term_count'
		)
	);
}
?>
