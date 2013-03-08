<?php


// -----------------------------------------------------------------------------------------------
// Validate functions (used to save the venues, attendanceMode and attendancePattern)
// -----------------------------------------------------------------------------------------------

function validate_venues_fn($input){
	
	// With this we have to check what venue it is (using the venue_id)
	// Then we have to get the whole array of venues, and insert the new values, and return the whole array with all the venues back
	// IMPORTANT: The returned array overwrites all the previous venues, so it must contain all the existing values as well as the new changed ones

	$venues = get_option('venues');			// get all the venues
	$editmode = $_POST['editmode']; 		// add-venue, edit-venue or delete-venue
	$venue_id = $_POST['venue_id']; 		// venue's id (either set to a number or 'new' if add new)
	
	
	// The validation function fires when the page is opened as well as when the settings are saved. 
	// Only do the save function if an item is being editted (when venue_id is set)
	if(isset($venue_id)){
		if($venue_id == 'new'){
			
			// Do Add Venue
		
			// Make the new array key - (last array key plus one) 
			end($venues);
			$last_id = key($venues);
			$new_id = $last_id + 1; // key of new venue
			
			// Get the form info
			$venue_short_title = $input['venue_short_title'];
			$venue_title = $input['venue_title'];
			$add1 = $input['add1'];
			$add2 = $input['add2'];
			$add3 = $input['add3'];
			$add4 = $input['add4'];
			$postcode = $input['postcode'];
			$phone = $input['phone'];
			
			// Put them in array with new array key
			$venues[$new_id]['venue_short_title'] = $venue_short_title;
			$venues[$new_id]['venue_title'] = $venue_title;
			$venues[$new_id]['add1'] = $add1;
			$venues[$new_id]['add2'] = $add2;
			$venues[$new_id]['add3'] = $add3;
			$venues[$new_id]['add4'] = $add4;
			$venues[$new_id]['postcode'] = $postcode;
			$venues[$new_id]['phone'] = $phone;
			
			return $venues; // return modified array, this replaces the DB field's contents
			
		}
		elseif($editmode != 'delete-venue') {
			
			// Do Edit Venue
			
			// Get the form info
			$venue_short_title = $input['venue_short_title'];
			$venue_title = $input['venue_title'];
			$add1 = $input['add1'];
			$add2 = $input['add2'];
			$add3 = $input['add3'];
			$add4 = $input['add4'];
			$postcode = $input['postcode'];
			$phone = $input['phone'];

			
			// Put them in with the rest of the venues
			$venues[$venue_id]['venue_short_title'] = $venue_short_title;
			$venues[$venue_id]['venue_title'] = $venue_title;
			$venues[$venue_id]['add1'] = $add1;
			$venues[$venue_id]['add2'] = $add2;
			$venues[$venue_id]['add3'] = $add3;
			$venues[$venue_id]['add4'] = $add4;
			$venues[$venue_id]['postcode'] = $postcode;
			$venues[$venue_id]['phone'] = $phone;
			
			return $venues; // return modified array, this replaces DB fields contents
			
		} elseif($editmode == 'delete-venue'){
			
			// Do Delete Venue
			
			// Remove this venue from the array
			unset($venues[$venue_id]);
			
			return $venues;  
		}
	}
	
	return $input;	
}


function validate_am_fn($input){   

	// IMPORTANT: The returned array overwrites all the previous venues, so it must contain all the existing values as well as the new changed ones
	 
	$attendance_modes = get_option('attendance_modes');
	$editmode = $_POST['editmode']; 	// add-attendance-pattern, edit-attendance-pattern or delete-attendance-pattern
	$am_id = $_POST['am_id']; 			// am's id (a number or 'new')
	

	// The validation function fires willy nilly - when the page is opened as well as when the settings are saved. 
	// Only do the save function if an item is being editted (when am_id is set)
	if(isset($am_id)){
		if($am_id == 'new'){
			
			// Do Add <AM>
			
			// Make the new array key - (last array key plus one) 
			end($attendance_modes);
			$last_id = key($attendance_modes);
			$new_id = $last_id + 1; // key of new venue
						
			// Get the form info
			$text = $input['text'];
			$key = $input['key'];
			
			// Put it in the new array
			$attendance_modes[$new_id]['text'] = $text;
			$attendance_modes[$new_id]['key'] = $key;
			
			return $attendance_modes;
			
		}
		elseif($editmode != 'delete-attendance-mode') {
			
			// Do Edit <AM>
			
			// Get the form info
			$text = $input['text'];
			$key = $input['key'];
			
			// Put it in the new array
			$attendance_modes[$am_id]['text'] = $text;
			$attendance_modes[$am_id]['key'] = $key;
			return $attendance_modes;
		}
		elseif($editmode == 'delete-attendance-mode'){
			
			// Do Delete <AM>
			unset($attendance_modes[$am_id]);
			
			return $attendance_modes;
			
		}
	}
	return $input;
}

function validate_ap_fn($input){

	// IMPORTANT: The returned array overwrites all the previous venues, so it must contain all the existing values as well as the new changed ones
		
	$attendance_patterns = get_option('attendance_patterns');
	$editmode = $_POST['editmode']; 	// add-attendance-pattern, edit-attendance-pattern or delete-attendance-pattern
	$ap_id = $_POST['ap_id']; 			// ap's id (a number or 'new')
	

	// This validation function fires willy nilly - on page open and when settings are saved. 
	// Only do the save if it needs to (when ap_id is set)
	if(isset($ap_id)){
		if($ap_id == 'new'){
			
			// Do Add <AP>
			
			// Make the new array key - (last array key plus one) 
			
			end($attendance_patterns);
			$last_id = key($attendance_patterns);
			$new_id = $last_id + 1; // key of new venue
						
			
			// Get the form info
			$text = $input['text'];
			$key = $input['key'];
			
			// Put it in the new array
			$attendance_patterns[$new_id]['text'] = $text;
			$attendance_patterns[$new_id]['key'] = $key;
			
			return $attendance_patterns;
			
		}
		elseif($editmode != 'delete-attendance-pattern') {
			
			// Do Edit <AP>
			
			// Get the form info
			$text = $input['text'];
			$key = $input['key'];
			
			// Put it in the new array
			$attendance_patterns[$ap_id]['text'] = $text;
			$attendance_patterns[$ap_id]['key'] = $key;
			
			return $attendance_patterns;
			
		}
		elseif($editmode == 'delete-attendance-pattern'){
			// Do Delete <AP>
			unset($attendance_patterns[$ap_id]);
			
			return $attendance_patterns;
			
		}
	}
	return $input;	
	
}

?>