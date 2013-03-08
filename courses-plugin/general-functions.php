<?php 
/*----------------------------------*/
/* GENERAL FUNCTIONS      			*/
/*----------------------------------*/
// This is where all the miscellaneous functions go that the plugin relies on.




#-------------------------------------------------------
#  Functions to return related presentations / courses
#-------------------------------------------------------

// returns all presentations for a given course (returns object - see usage below)
function cpd_get_presentations_ids($course_id){ 
    
    global $wpdb;
    $pres_ids = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type = 'presentations' AND ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'course_relation' AND meta_value = $course_id)");
    return $pres_ids;
    
    // Use this code to access the returned ids:
    /*
        foreach($pres_ids as $pres_id){
            echo $pres_id->ID . "<br />";
        }
    */
}

// returns all presentation titles for a given course (returns object - see usage below)
function cpd_get_presentations_titles($course_id){
    
    global $wpdb;
    $pres_ids = cpd_get_presentations_ids($course_id);
    $pres_titles = array();
    foreach($pres_ids as $pres_id){
       		$pres_titles[] = get_the_title($pres_id->ID);
    }
    return $pres_titles;
    
    // Use this code to access the returned ids:
    /*
        foreach($pres_titles as $pres_title){
            echo $pres_title . "<br />";
        }
    */
}

// Get presentation ids and titles, as an associative array  (id => title)
function cpd_get_presentations($course_id){
    
    global $wpdb;
    $pres_ids = cpd_get_presentations_ids($course_id);
    $presentations = array();
    foreach($pres_ids as $pres_id){

    	$presentations[$pres_id->ID] = get_the_title($pres_id->ID);
       
    }
    return $presentations;
    
    // Use this code to access the returned ids:
    /*
        foreach($presentations as $id => $title){
            echo '<a href="www.edgehill.com?presentation=' .$id. '">' . $title. '</a>';
        }
    */
}

// Get course id and titles from a presentation post id
function cpd_get_course( $pres_id ){
	
	$course_id = get_post_meta( $pres_id, 'course_relation', true );
    $course = array();
	$course['id'] = $course_id;
	$course['title'] = get_the_title( $course_id ) ;
	return $course;
	
	/*
		Example usage:
		
		$course = cpd_get_course($post->ID);
		echo $course['id'] . " - " . $course['title'];
	*/
}


// @TODO - Finish this function.... it will be useful for the feed (optimising the query)
// Get all the course and related presentation's information - all the post meta. Returns an array
function cpd_get_course_and_presentation_info( $course_id ){
	
	$course = array(); // will contain course and presentation info 
	
	// Get the basic course info from the posts db (title, id)
	$course['title'] = get_the_title( $course_id );
	$course['post_id'] = $course_id;
	
	// Get the course's postmeta data - (do a loop getting each related postmeta and putting it in the array)

	// $course_postmeta = cpd_get_post_meta_all( $course_id );	
		
	// Get the related presentation's ids
	$presentations = cpd_get_presentations($course_id);
	
	foreach($presentations as $id => $title){
    	$course['presentation'][$id]['title'] = $title; 
    }
	
	// Loop through each...
		
		// Grab the postmeta info...
	
	return $course;
	//return $full_course;
	
}

function cpd_get_post_meta_all($post_id){
    global $wpdb;
    $data   =   array();
    $wpdb->query("
        SELECT 'meta_key', 'meta_value'
        FROM $wpdb->postmeta
        WHERE 'post_id' = $post_id
    ");
    foreach($wpdb->last_result as $key => $value){
        $data[$value->meta_key] =   $value->meta_value;
    };
    return $data;
}

// takes the venue's array key and returns the venue title and address
function cpd_get_venue($venue_key){
	
	$all_venues = get_option('venues'); // Get all the venues from the option

	$venue = array(); // We'll put the individual venue here
	
	$venue['venue_short_title'] = $all_venues[$venue_key]['venue_short_title'];
	$venue['venue_title'] = $all_venues[$venue_key]['venue_title'];
	$venue['add1'] = $all_venues[$venue_key]['add1'];
	$venue['add2'] = $all_venues[$venue_key]['add2'];
	$venue['add3'] = $all_venues[$venue_key]['add3'];
	$venue['postcode'] = $all_venues[$venue_key]['postcode'];
	$venue['phone'] = $all_venues[$venue_key]['phone'];
	
	return $venue;
	
}


//--------------------------------------
//  Search
//--------------------------------------

function get_cpd_course_search_form($echo = true) {
?>
		<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="s" class="assistive-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
			<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
			<input type="hidden" name="post_type" value="courses" />
			<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
		</form>
<?php 
}


//--------------------------------------
//  Security
//--------------------------------------

// Filter unwanted tags out of a string. Use this as you output text.
function cpd_filter_tags($str){
					
	// Tags and attributes we let in
	$allowed = 	array(
		'a' => array(
			'href' => array(),
			'title' => array()
		),
		'br' => array(),
		'em' => array(),
		'strong' => array(), 
		'div' => array(), 
		'ul' => array(), 
		'li' => array(), 
		'p' => array(), 
		'h1' => array(), 
		'h2' => array(), 
		'h3' => array()
	);
				
	return wp_kses($str, $allowed);
}




#--------------------------------------
#  YE OLDE Get Presentation Info for FE links
#--------------------------------------

/*
 * Get all the post_ids of presentations for a given course
 * 
 * @Params: Takes - course post id, Return - numerical array with presentation ids 
 */
function cpd_get_presentation_ids($course_id){
	    
    global $wpdb;
    $post_ids = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'course_relation' AND meta_value = $course_id");
   
    $p_ids = array();
    foreach($post_ids as $post_id){
		$p_ids[] = $post_id->post_id;
	}
    return($p_ids);
        
}


// A better version of the function below
/*
function cpd_get_course_presentations($post_id){
	global $wpdb;
	$pres_ids = cpd_get_presentation_ids($post_id);
	
	// @TODO - finish me!
	
}
*/


function get_course_presentations($post_id){
    
    // Use the function get_presentation_ids() instead of most of the below now...
	global $wpdb;
	$matching = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'course_relation' AND meta_value = $post_id", ARRAY_A); 
	
	// Get the id's out of the returned nested arrays...		
	$matching_presentations_post_ids = array();
	foreach($matching as $key => $value){
		/*
		echo "K: ". $key . "<br />";
		echo "V: ". $value. "<br /><br />";
		*/
		foreach($value as $key => $val){
			/*
			echo "--K: ". $key . "<br />";
			echo "--V: ". $val. "<br /><br />";	
			*/
			$matching_presentations_post_ids[] = $val; // This array fills with the post_id's of the presentations matching the course
		}
	}
	
	// Get the title of the matching presentations, put them in an array with the corresponding post_id
	$presentation_titles = array();
	foreach($matching_presentations_post_ids as $value){
		$presentation_titles[$value] = get_the_title($value);//get_post_meta($value, 'presentation', true);
	}
	
	// Put matching presentations into a link form in an array
	$presentation_links = array();
	foreach($presentation_titles as $post_id => $title){
		$presentation_links[] =  "<a href='index.php?p=" . $post_id . "'>" . $title . "</a>";
	}
	return $presentation_links;		
}


/* ------------------------------------- */
/*	SHORTCODES 							 */
/* ------------------------------------- */


// Test shortcode
function dancode_f( $atts ){
 	
 	return "DANCODE DANCODE";
}
add_shortcode( 'dancode', 'dancode_f' );


// Searchform shortcode - searches the cpd courses
function cpd_searchform( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="hidden" name="post_type" value="courses" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';

    return $form;
}
add_shortcode('cpdsearch', 'cpd_searchform');


// CPD Course Table shortcode - shows and links to all cpd courses
function cpd_coursetable( $table ) {

	global $wpdb;
	// Get all the courses, course codes and permalinks (alphabetical order)
	$courses = $wpdb->get_results( 
		"
		SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'courses' AND post_status != 'auto-draft' AND post_status != 'draft' AND post_status != 'trash' ORDER BY post_title ASC
		"
	);

	$table = '<table class="cpd-table">';
	$table .= '<colgroup>
			       <col span="1" style="width: 18%;">
			       <col span="1" style="width: 72%;">
			       <col span="1" style="width: 10%;">
			    </colgroup>
				<tr>
					<th>Code</th>
					<th>Module</th>
					<th>level</th>
				</tr>';
	foreach($courses as $course){
		$table .= 	'<tr>
						<td>'.get_post_meta($course->ID, 'module_code', true). '</td>
						<td><a href="'. get_permalink($course->ID). '">' .$course->post_title. '</a></td>
						<td>'.get_post_meta($course->ID, 'level', true).'</td>
					</tr>'; 
	}
	$table .= '</table>';
    return $table;
}
add_shortcode('cpdtable', 'cpd_coursetable');


// Shortcode to display the leaflet menu page
function cpd_leaflets_menu( $menu ){

	
	global $wpdb;
	// Get all the courses
	$courses = $wpdb->get_results( 
		"
		SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'courses' AND post_status != 'auto-draft' AND post_status != 'trash'
		"
	);
	
	$menu = '<table>';
	$menu .= 	'<tr>
					<th>Course</th>
					<th>Download</th>
				</tr>';
			
	foreach($courses as $course){
		$menu .= 	'<tr>
						<td><a href="'. get_permalink($course->ID). '">' .$course->post_title. '</a></td>
						<td><a href="#">Download leaflet</a></td>
					</tr>'; 
	}
	$menu .= 	'</table>';
	
	return $menu;
	
}
add_shortcode('cpd-leaflets-menu', 'cpd_leaflets_menu');


?>