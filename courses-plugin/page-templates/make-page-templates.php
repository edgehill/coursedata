<?php // NOTE: These page templates are here for legacy purposes. Page templates are now in the themes folder
//---------------------------------
//	New Page Templates
//---------------------------------

/*
add_action('template_redirect', 'cpd_my_template');
function cpd_my_template(){
	echo "Courses Redirect";
	global $post;
	if( $post->post_type == 'courses'){
		
		include(dirname( __FILE__ ) . '/course-template.php');
		exit;
    }
    if( $post->post_type == 'presentations'){
		
		include(dirname( __FILE__ ) . '/presentation-template.php');
		exit;	
	}
}
*/
		
?>