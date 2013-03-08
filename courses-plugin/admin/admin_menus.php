<?php
//-------------------------------------------------------------------------------------------------------
//	ADMIN MENUS                           
//-------------------------------------------------------------------------------------------------------
//  This file makes the admin meta boxes and fields for courses and presentations


#-------------------------------------------------------------------------
#  Courses
#-------------------------------------------------------------------------

// Add Meta Boxes

add_action('add_meta_boxes', 'cpd_add_courses_boxes');

function cpd_add_courses_boxes(){ 
	
	// Overview (Previously Introduction)
	add_meta_box( 																		
        'overview',					// html id
        'Overview',					// title
        'cpd_overview_box',			// callback
        'courses', 					// post-type   
 		'normal',					// postion     --- @TODO - Add these two to all the meta boxes 
		'high'						// priority    --- @TODO - AND move all the boxes into their own meta box 
		
    );

	// How will I study
	add_meta_box( 																		
        'how_will_i_study',		
        'How Will I Study',			
        'how_will_i_study_box',	
        'courses', 					
 		'normal',					
		'high'						
    );

	// Course info box
	add_meta_box( 																		
        'course_details_box',		
        'Course Details',			
        'cpd_courses_details_box',	
        'courses', 					
 		'normal',					
		'high'						
    );

	// Audience
	add_meta_box(
		'audience_box',		
        'Audience <span class="lighter"> - Who is this module for?</span>',			
        'cpd_audience_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	// Aims
	add_meta_box(
		'aims_box',		
        'Aims <span class="lighter"> - What are the key aims of the programme?</span>',			
        'cpd_aims_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	// Content
	add_meta_box(
		'content_box',		
        'Content <span class="lighter"> - What will I study?</span>',			
        'cpd_content_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	
	// Assessment
	add_meta_box(
		'assessment_box',		
        'Assessment <span class="lighter"> - How will I be assessed?</span>',			
        'cpd_assessment_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	
	// Outcomes
	add_meta_box(
		'outcomes_box',		
        'Outcomes <span class="lighter"> - On successful completion you will:</span></p>',			
        'cpd_outcomes_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	// Pathways
	add_meta_box(
		'pathways_box',		
        'Pathways',			
        'cpd_pathways_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	
	// How to Apply
	add_meta_box(
		'apply_box',		
        'How to Apply',			
        'cpd_apply_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	// Contact Us
	add_meta_box(
		'contact_box',		
        'Contact Us',			
        'cpd_contact_box',	
        'courses', 					
 		'normal',					
		'high'
	);
	
	/*// Keywords
	add_meta_box(
		'keywords_box',		
        'Keywords',			
        'cpd_keywords_box',	
        'courses',
		'normal',
		'high'
	);*/
	
	// Revisions
	/*
	add_meta_box(
		'revisions_box',		
        'Previous Revision Content',			
        'cpd_revisions_box',	
        'courses'
	);
	*/
	
	// Its Presentations
	add_meta_box( 																		
        'its_presentation',		
        'Its Presentations',	
        'cpd_its_presentations',		
        'courses',
		'side',
		'high'

    );
	
	
	// Add Presentation Box
	add_meta_box( 																		
        'add_presentation',		
        'Add Presentation',	
        'cpd_add_presentation_box',		
        'courses',
		'side',
		'high'			
    );
    
	/*
    // Duplicate Presenation Box
    add_meta_box( 																		
        'duplicate_presentation',		
        'Duplicate a Presentation',	
        'cpd_duplicate_presentation_box',		
        'courses',
		'side'				
    );
	*/
	
	
	// Post ID
	add_meta_box( 																		
        '',		
        'Post ID',	
        'cpd_test_box',		
        'courses',
		'side'				
    );
	
} 


#---------------------------
#  Add meta box content
#---------------------------


// Overview
function cpd_overview_box(){
	
	global $post;
	$overview = get_post_meta($post->ID, 'overview', true); 

?>
	
	
	<div class="padding">
	
		<!-- Nonce -->
    	<?php wp_nonce_field( 'cpd_courses_nonce', 'courses_nonce' ); ?>
	
		<!-- Intro -->
    	<textarea name="overview" id="overview" class=""><?php echo $overview; ?></textarea>
	
	</div>

<?php
}

// How will I study
function how_will_i_study_box(){

	global $post;
	$how_will_i_study = get_post_meta($post->ID, 'how_will_i_study', true); 
?>

	<div class="padding">
	
		<!-- Intro -->
    	<textarea name="how_will_i_study" id="how_will_i_study" class=""><?php echo $how_will_i_study; ?></textarea>
	
	</div>

<?php }


// Course Details
function cpd_courses_details_box(){ 
	
	global $post;
	$module_code = get_post_meta($post->ID, 'module_code', true);;
	$level = get_post_meta($post->ID, 'level', true);
	$credits = get_post_meta($post->ID, 'credits', true);
	$cost = get_post_meta($post->ID, 'cost', true);
	$duration = get_post_meta($post->ID, 'duration', true); 
	
?>
	
	<div class="padding">
		
		<!-- Module Code -->
		<label for="module_code">Module Code: </label>
	    <input type="text" name="module_code" id="module_code" value="<?php echo $module_code; ?>" />
	
	
		<!-- Level -->
		<label for="level">Level: </label>
	    <input type="text" name="level" id="level" value="<?php echo $level; ?>" />
		<p class="caption">* Required for xcri</p>
	
		<!-- Credits-->
		<label for="credits">Credits: </label>
	    <input type="text" name="credits" id="credits" value="<?php echo $credits; ?>" />
		<p class="caption">* Required for xcri</p>
		
		<!-- Cost -->
		<label for="cost">Cost: </label>
	    <input type="text" name="cost" id="cost" value="<?php echo $cost; ?>" />

	    <!-- Duration -->
     	<label for="duration">Duration (weeks): </label>
     	<input type="text" name="duration" value="<?php echo $duration; ?>" class="number" />
     	<p class="caption">* Required for xcri</p>
   		<!-- Becomes XCRI: <duration> & creates <duration dtf="-X-">-->
			
	</div>
	
<?php
}

function cpd_audience_box(){
	
	global $post;
	$audience = get_post_meta($post->ID, 'audience', true); 
 
?>
	
	
	<div class="padding">
		
		<!-- Audience  (Who is this module for?)  -->
	    <textarea name="audience" id="audience"><?php echo $audience; ?></textarea>
	
	</div>

<?php
}


// Aims
function cpd_aims_box(){
	
	global $post;
	$aims = get_post_meta($post->ID, 'aims', true); 

?>
	
	<div class="padding">
		
		<!-- Aims  (What are the key aims of the programme?)  -->
	    <textarea name="aims" id="aims"><?php echo $aims; ?></textarea>  <!-- Becomes XCRI: <objective> -->
	
	</div>

<?php
}

// Content 
function cpd_content_box(){
	
	global $post;
	$content = get_post_meta($post->ID, 'content', true); 

?>
	
	
	<div class="padding">
		
		<!-- Content  (What will I study)  -->
	    <textarea name="content" id="content"><?php echo $content; ?></textarea>
	
	</div>
	
<?php
}


// Assessment
function cpd_assessment_box(){
	
	global $post;
	$assessment = get_post_meta($post->ID, 'assessment', true); 
	
?>
	
	
	<div class="padding">
		
		<!-- Assessment  (How will I be assessed?)  -->
	    <textarea name="assessment" id="assessment"><?php echo $assessment; ?></textarea>
	
	</div>

<?php
}


// Outcomes (Becomes <learningOutcomes)
function cpd_outcomes_box(){
	
	global $post;
	$learning_outcomes = get_post_meta($post->ID, 'learning_outcomes', true); 

?>
	
	
	<div class="padding">
		
		<!-- Outcomes  (On successful completion you will:)  -->
	    <textarea name="learning_outcomes" id="learning_outcomes"><?php echo $learning_outcomes; ?></textarea>
	
	</div>

<?php
}


// Pathways
function cpd_pathways_box(){
	
	global $post;
	$pathways = get_post_meta($post->ID, 'pathways', true); 

?>
	
	
	<div class="padding">
		
		<!-- Pathways -->
	    <textarea name="pathways" id="pathways"><?php echo $pathways; ?></textarea>
	
	</div>

<?php
}



// How to Apply
function cpd_apply_box(){ 
	
	global $post;
	$application_procedure = get_post_meta($post->ID, 'application_procedure', true); ?>
	
	
	<div class="padding">
		
		<!-- How to Apply -->
	    <textarea name="application_procedure" id="application_procedure"><?php echo $application_procedure; ?></textarea>
	
	</div><?php
}



// Contact Us
function cpd_contact_box(){
	
	global $post;
	$contact_us = get_post_meta($post->ID, 'contact_us', true); 

?>
	
	
	<div class="padding">
		
		<!-- Contact Us / Further Information -->
	    <textarea name="contact_us" id="contact_us"><?php echo $contact_us; ?></textarea>
	
	</div>

<?php
}

/*// Keywords
function cpd_keywords_box(){
	
	global $post;
	$keywords 				= get_post_meta($post->ID, 'keywords', true); 
	
?>
	
    
	<div class="padding">

      <!-- Keywords -->
      <textarea name="keywords" id="keywords" class="max_4000"><?php echo $keywords; ?></textarea>
    
    </div>

<?php
}*/


// Revisions
/*
function cpd_revisions_box(){
	
	global $post;
	$page_object = get_page( $post->ID );
    $revisions = $page_object->post_content;

?>
	
	<div class="padding">
		
		<p>Select a revisions from the revision menu to see its content. </p>
		<!-- Revisions -->
	    <textarea name="revisions" id="revisions"><?php echo $revisions; ?></textarea>
	
	</div>
	
<?php
}
*/

function cpd_its_presentations(){
	
	global $post;
	$presentations = cpd_get_presentations($post->ID);
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
}

// Add presentation button
function cpd_add_presentation_box(){ 
	
	global $post;
	global $current_screen;
	
	if ($current_screen->action == 'add'){
	    echo '<p class="lighter">Add new presentation</p>';
	} else {
	    echo '<a href="post-new.php?post_type=presentations&course=' . $post->ID .'">Add new presentation</a>';
	}
	
}


/*
// Duplicate presentation button
function cpd_duplicate_presentation_box(){
    
    global $post;
    $presentations = cpd_get_presentations($post->ID);
    
    $first = true;
    foreach($presentations as $id => $title){
		// @TODO - When you put this back in make sure you exclude draft presentations
        
        if($first){
            echo '<a href="' .$id. '">' . $title. '</a>';
            $first = false;
        }
        else {
            echo ', <a href="' .$id. '">' . $title. '</a>';
        }
    }
    echo "<br />Make this work";
}
*/


// Post ID
function cpd_test_box(){ 

	global $post;
	echo "Post ID: " . $post->ID;	
	
}



	

#-------------------------------------------------------------------------
#  Presentations
#-------------------------------------------------------------------------
	
// Add Meta Boxes
add_action('add_meta_boxes', 'cpd_add_presentation_boxes');
function cpd_add_presentation_boxes(){
 
	// Course relation
	 add_meta_box(
	   'course_box',
	   'Belongs to...',
	   'cpd_course_box',
	   'presentations',
	   'normal',
	   'high' 
	 );
	 
	
	// Dates and Times
	 add_meta_box(
	   'dates_box',
	   'Dates',
	   'cpd_dates_box',
	   'presentations',
	   'normal',
	   'high' 
	 );
	 
	// Atendance
	 add_meta_box(
	   'attendance_box',
	   'Attendance',
	   'cpd_attendance_box',
	   'presentations',
	   'normal',
	   'high' 
	 );
	 
	// Venue
	 add_meta_box(
	   'venue_box',
	   'Venue',
	   'cpd_venue_box',
	   'presentations',
	   'normal',
	   'high' 
	 );
	 
	/*
	 add_meta_box(
	   'revisions_box',
	   'Previous Revision Content',
	   'cpd_presentation_revisions_box',
	   'presentations'
	 );
	*/
	 
	 
	 // Post ID
	add_meta_box( 																		
		 '',		
		 'Post ID',	
		 'cpd_presentation_test_box',		
		 'presentations',
		 'side'				
	);
	
	
	// This course link
 	add_meta_box( 																		
		 'course_link',		
		 'Its Course',	
		 'cpd_view_course_box',		
		 'presentations',
		 'side'				
	);
	
	// Its Presentations
	add_meta_box( 																		
        'other_presentation',		
        'This Courses Others Presentations',	
        'cpd_other_presentations',		
        'presentations',
		'side'				
    );
}




// Add Meta Box Content...

// Course Relation
function cpd_course_box(){
 
	global $post;
	$course_relation = get_post_meta($post->ID, 'course_relation', true); 
	$course_id = $_GET['course']; // set if clicked 'add presentation' 

?>
    
	<div class="padding">
	
		<!-- Nonce -->
		<?php wp_nonce_field( 'cpd_presentations_nonce', 'presentations_nonce' ); ?>
 
	   	<!-- Related Course-->
	    <select name="course_relation" id="course_relation">
	    	<?php
	    	    // Display all courses as options, preselect if the presentation is already related to a course, or if user has clicked 'add presentation'
	    		global $wpdb;
		        $courses = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'courses' AND post_status = 'publish'");
				
		        foreach($courses as $course){ ?>
		       		<option 
		       		    value="<?php echo $course->ID ?>" 
		       		    <?php
		       		        // If user clicked 'add presentation' || or if presentation already has a related course
		       		        if($course_id == $course->ID || $course->ID == $course_relation){ 
		       		            echo " selected='selected'"; 
		       		        } ?>
		       		>
		       		    <?php echo $course->post_title; ?>
		            </option>
	       	<?php } ?>
	    </select>
   
 	</div>

<?php 
}

// Dates
function cpd_dates_box(){

	global $post;
 	$start          = get_post_meta($post->ID, 'start', true);
	$session_times = get_post_meta($post->ID, 'session_times', true); 

?>
    
    <div class="padding">
 
   		<!-- Start -->
   		<label for="start">Start: </label>
     	<input type="text" name="start" value="<?php echo $start; ?>" id="datepicker" placeholder="YYYY-MM-DD" class="required" />
     	<p class="caption">* Required for xcri</p>
   		<!-- Becomes XCRI: <start> -->

     
   		<!-- Session Times -->
        <label for="session_times">Session Times: </label>
        <textarea name="session_times" id="session_times"><?php echo $session_times; ?></textarea>
   
 	</div>

<?php
}


// Attendance
function cpd_attendance_box(){
 
	 global $post;
	 $this_am_key = get_post_meta($post->ID, 'attendance_mode', true);
	 $this_ap_key = get_post_meta($post->ID, 'attendance_pattern', true); 
	 $attendance_modes = get_option('attendance_modes');
	 $attendance_patterns = get_option('attendance_patterns');

?>
    
    <div class="padding">
       <!-- Attendance Mode -->
       <label for="attendance_mode">Attendance Mode: </label>
       <select name="attendance_mode">
       		<?php // make a default blank option... ?>
       		<option value="0">--blank--</option>
            <?php
                // Loop through the attendance mode options in the options table, if the key matches this presentations venue key, make it selected
                foreach ($attendance_modes as $key => $attendance_mode) {
                    ?>
                        <option 
                            value="<?php echo $key; ?>"
                            <?php if($key == $this_am_key) echo "selected"; ?>   
                        >
                            <?php echo $attendance_mode['text']; ?> 
                        </option>	
                    <?php 
                }
            ?>
        </select>
      

     	<!-- Attendance Pattern -->
   		<label for="attendance_pattern">Attendance Pattern: </label>
   		<select name="attendance_pattern">
   			<?php // make a default blank option... ?>
       		<option value="0">--blank--</option>
        	<?php
                // Loop through the attendance pattern options in the options table, if the key matches this presentations venue key, make it selected
                foreach($attendance_patterns as $key => $attendance_pattern){
                    ?>
                        <option 
                            value="<?php echo $key; ?>"
                            <?php if($key == $this_ap_key) echo "selected"; ?>   
                        >
                            <?php echo $attendance_pattern['text']; ?> 
                        </option>	
                    <?php 
                }
            ?>
     	</select>
 </div>

<?php
}

// Venue
function cpd_venue_box(){
 
    global $post;
    $this_venues_key = get_post_meta($post->ID, 'venue', true); 
	$venues = get_option('venues');

?>
    
    <div class="padding">
 
        <!-- Venue -->
        <?php  echo $this_venue_key; ?>
        <label for="venue">Venue: </label>
        <select name="venue">
        	<?php
 				$venue_no = 1;
				// Loop through the venue options in the options table, if the key matches this presentations venue key, make it selected
				foreach($venues as $venue_key => $venue){
					?>
						<option 
                        	value="<?php echo $venue_key; ?>"
                        	<?php if($venue_key == $this_venues_key) echo "selected";?>   
                        >
                        	<?php echo $venue['venue_title']; ?> 
						</option>
					<?php 
					$venue_no++;
                }
                // Make a default online study option... ?>
       			<option value="0">Online Study</option>
			?>
       </select>
       <p class="caption">* Required for xcri</p>
   
       </div>

<?php 
} 

// Revisions
/*
function cpd_presentation_revisions_box(){
 
    global $post;
	$page_object = get_page( $post->ID );
    $revisions = $page_object->post_content; ?>
	
	
	<div class="padding">
		
		<p>Select a revisions from the revision menu to see its content. </p>
		
		<!-- Revisions -->
	    <textarea name="revisions" id="revisions"><?php echo $revisions; ?></textarea>
	
	</div>

<?php
}
*/

function cpd_other_presentations(){
	
	global $post;
	
	// get related course id 
	$course_id = get_post_meta($post->ID, 'course_relation', true); 
	
	$presentations = cpd_get_presentations($course_id);
	$first = true;
	foreach($presentations as $id => $title){
		if($id != $post->ID){
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
	}
}


// Post ID
function cpd_presentation_test_box(){ 

	global $post;
	echo "Post ID: " . $post->ID;	
	
}

function cpd_view_course_box(){

		global $post;
		$course = cpd_get_course( $post->ID );
		echo '<a href="post.php?post='.$course['id'].'&action=edit">' .$course['title']. '</a>';
}


?>