<?php 
//----------------------------------------------------------------
//	SAVE                      
//----------------------------------------------------------------
//  This file saves the postmeta for the courses and presentations


# ----------------------------------------
#  Save Course Info
#-----------------------------------------
add_action('save_post', 'cpd_save_course');
$do_this_once = true; 

function cpd_save_course(){ 

	global $post;
	global $wpdb;
	
	//Do checks
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if($post->post_type == 'courses'){
		
		// Verify Nonce...
		if(!wp_verify_nonce($_POST['courses_nonce'],'cpd_courses_nonce'))
		{ 
			/* Nonce not verified - @TODO - redirect with error message ideally */	
		} 
		else 
		{
			// Nonce Verified, so save it...
			
			global $do_this_once; // (just once, as WP's save fires twice)
			if($do_this_once)
			{
				
			
				// Save the post meta

				// $title 			      (Saved to post table)
				$overview	 		    = $_POST['overview'];
				$how_will_i_study		= $_POST['how_will_i_study'];
				$module_code 		    = $_POST['module_code'];
				$level 					= $_POST['level'];                      //<level>
				$credits	 			= $_POST['credits'];                    //<value>
				$cost 					= $_POST['cost'];                       //<cost>
				$duration 				= $_POST['duration'];
				$aims	    			= $_POST['aims'];                       //<objectives>
				$content 				= $_POST['content'];
				$assessment 			= $_POST['assessment'];                 //<assessment>
				$learning_outcomes		= $_POST['learning_outcomes'];          //<learningOutcome>
				$audience 				= $_POST['audience'];   
				$application_procedure 	= $_POST['application_procedure'];	 //<applicationProcedure>                    
				$contact_us 			= $_POST['contact_us'];
				$pathways 				= $_POST['pathways'];
				//$keywords 				= $_POST['keywords'];    					
				//$qualification_title	= $_POST['qualification_title'];
				//$qualification_abbreviation = $_POST['qualification_abbreviation'];	
				//$awarded_by				= $_POST['awarded_by'];
				
				update_post_meta($post->ID, 'overview', $overview);
				update_post_meta($post->ID, 'how_will_i_study', $how_will_i_study);
				update_post_meta($post->ID, 'module_code', $module_code);
				update_post_meta($post->ID, 'level', $level);
				update_post_meta($post->ID, 'credits', $credits);
				update_post_meta($post->ID, 'cost', $cost);
				update_post_meta($post->ID, 'duration', $duration);
				update_post_meta($post->ID, 'audience', $audience);
				update_post_meta($post->ID, 'aims', $aims);
				update_post_meta($post->ID, 'content', $content);
				update_post_meta($post->ID, 'subject', $subject);
				update_post_meta($post->ID, 'assessment', $assessment);
				update_post_meta($post->ID, 'learning_outcomes', $learning_outcomes);
				update_post_meta($post->ID, 'pathways', $pathways);
				update_post_meta($post->ID, 'application_procedure', $application_procedure);
				update_post_meta($post->ID, 'contact_us', $contact_us);
				//update_post_meta($post->ID, 'keywords', $keywords);
					
				$do_this_once = false;  // Don't do it again
			}
		}
	}
}


# ----------------------------------------------
#  Save Presentation Info
#-----------------------------------------------
add_action('save_post', 'cpd_save_presentation');
function cpd_save_presentation(){
    
	global $post;
	global $wpdb;
	
	// Do checks
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if($post->post_type == 'presentations')
	{
		// Verify Nonce...
		if(!wp_verify_nonce($_POST['presentations_nonce'],'cpd_presentations_nonce'))
		{
			/* Nonce not verified - redirect with error message ideally */	
		} 
		else 
		{
			// Nonce verified - so save it...

			global $do_this_once; // (as WP save fires twice)
			if($do_this_once)
			{	

    			// Save the post meta

			    $course_relation 		= $_POST['course_relation'];
				$start 					= $_POST['start'];
				$session_times 			= $_POST['session_times'];
				$study_mode 			= $_POST['study_mode'];
				$attendance_mode		= $_POST['attendance_mode'];
				$attendance_pattern		= $_POST['attendance_pattern'];
				$venue 					= $_POST['venue'];

				update_post_meta($post->ID, 'course_relation', $course_relation);
				update_post_meta($post->ID, 'start', $start);
				update_post_meta($post->ID, 'session_times', $session_times);
				update_post_meta($post->ID, 'study_mode', $study_mode);
				update_post_meta($post->ID, 'attendance_mode', $attendance_mode);
				update_post_meta($post->ID, 'attendance_pattern', $attendance_pattern);
				update_post_meta($post->ID, 'venue', $venue);			
                           
			}
		}
	}
}


/*
#-----------------------------------------
#	Delete PostMeta Data on trashing            (Sort this out - there should be a better solution than this)
#-----------------------------------------
// WP erases postmeta on post trash, so may as well delete them completely then as well. (Rename 'trash' to 'delete'. Hook up the delete functionality to that button?)
add_action('wp_trash_post', 'cpd_delete_postmeta'); // all post meta is erased when items are moved to the trash, so we'll delete the fields when that happens as well
function cpd_delete_postmeta(){
	global $post;
	global $wpdb;
	
	if($post->post_type == 'courses'){
		// delete postmeta of this course...
		$wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$post->ID'");
	}
	else if($post->post_type == 'presentations'){
		// delete postmeta of this presentation..
		$wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$post->ID'");
	}
	else if($post->post_type == 'qualifications'){
		// delete postmeta of this qualfication...
		$wpdb->query("DELETE FROM $wpdb->postmeta WHERE post_id = '$post->ID'");
	}
	
}
*/

/* TEST HOOKS - for deleting...
add_action('before_delete_post', 'b4'); //}
add_action('delete_post', 'del');		//} All only trigger when it has been permanently deleted from the trash
add_action('deleted_post','deled');		//}
*/


?>