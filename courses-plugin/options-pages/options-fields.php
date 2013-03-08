<?php
// -----------------------------------------------------------------------------------------------
//  MAIN FIELDS
// -----------------------------------------------------------------------------------------------

// APPLY TO URL
function cpd_apply_to_url(){
	
	$options = get_option('options');
    echo '<input type="text" name="options[apply_to_url]" size="40" value="' . $options['apply_to_url'] . '" />';
}

// CREDIT SCHEME
function cpd_credit_scheme(){
	
	$options = get_option('options');
    echo '<input type="text" name="options[credit_scheme]" size="40" value="' . $options['credit_scheme'] . '" />';
}

// CREDIT SCHEME
function cpd_abstract(){
	
	$options = get_option('options');
    echo '<textarea name="options[abstract]">' . $options['abstract'] . '</textarea>';
}


// -----------------------------------------------------------------------------------------------
//  VENUES FIELDS 
// -----------------------------------------------------------------------------------------------

//VENUE SHORT TITLE
function cpd_venue_short_title(){
	
	global $venues;
	global $venue_id;
	$venues = get_option('venues');
	$venue_id = $_GET['venue_id'];
	
	echo "<input type='text' name='venues[venue_short_title]' size='60' value='" . $venues[$venue_id]['venue_short_title'] . "' \>";
}

//VENUE TITLE
function cpd_venue_title(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[venue_title]' size='60' value='" . $venues[$venue_id]['venue_title'] . "' \>";
	
}

//ADDRESS LINE 1
function cpd_add1(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[add1]' size='60' value='" . $venues[$venue_id]['add1'] . "' \>";
}

//ADDRESS LINE 2
function cpd_add2(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[add2]' size='60' value='" . $venues[$venue_id]['add2'] . "' \>";
}

//ADDRESS LINE 3
function cpd_add3(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[add3]' size='60' value='" . $venues[$venue_id]['add3'] . "' \>";
}

//ADDRESS LINE 4
function cpd_add4(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[add4]' size='60' value='" . $venues[$venue_id]['add4'] . "' \>";
}

//POSTCODE
function cpd_postcode(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[postcode]' size='60' value='" . $venues[$venue_id]['postcode'] . "' \>";
}

//POSTCODE
function cpd_phone(){
	
	global $venues;
	global $venue_id;
	
	echo "<input type='text' name='venues[phone]' size='60' value='" . $venues[$venue_id]['phone'] . "' \>";
}


// -----------------------------------------------------------------------------------------------
//  ATTENDANCE MODE FIELDS
// -----------------------------------------------------------------------------------------------

// TEXT VALUE
function cpd_am_xcri_text(){
	
	global $attendance_modes;
	global $am_id;
	$attendance_modes = get_option('attendance_modes');
	$am_id = $_GET['am_id'];
	
	echo "<input type='text' name='attendance_modes[text]' value='" . $attendance_modes[$am_id]['text'] . "' \>";
}

// XCRI KEY 
function cpd_am_xcri_key(){

	global $attendance_modes;
	global $am_id;
	
	echo "<input type='text' name='attendance_modes[key]' value='" .  $attendance_modes[$am_id]['key'] . "' \>";
}


// -----------------------------------------------------------------------------------------------
//  ATTENDANCE PATTERN FIELDS
// -----------------------------------------------------------------------------------------------

// TEXT VALUE
function cpd_ap_xcri_text(){
	
	global $attendance_patterns;
	global $ap_id;
	$attendance_patterns = get_option('attendance_patterns');
	$ap_id = $_GET['ap_id'];
	
	echo "<input type='text' name='attendance_patterns[text]' value='" . $attendance_patterns[$ap_id]['text'] . "' \>";
}

// XCRI KEY 
function cpd_ap_xcri_key(){

	global $attendance_patterns;
	global $ap_id;
	
	echo "<input type='text' name='attendance_patterns[key]' value='" .  $attendance_patterns[$ap_id]['key'] . "' \>";
}


// -----------------------------------------------------------------------------------------------
//  PROVIDER FIELDS
// -----------------------------------------------------------------------------------------------

// TITLE
function cpd_provider_title(){

	global $provider;
	$provider = get_option('xcri_provider');

	echo "<input type='text' name='xcri_provider[title]' value='" .  $provider['title'] . "' \>";
}

// URL
function cpd_provider_url(){

	global $provider;

	echo "<input type='text' name='xcri_provider[url]' value='" .  $provider['url'] . "' \>";
}

// ADDRESS 1
function cpd_provider_add1(){

	global $provider;

	echo "<input type='text' name='xcri_provider[add1]' value='" .  $provider['add1'] . "' \>";
}

// ADDRESS 2
function cpd_provider_add2(){

	global $provider;

	echo "<input type='text' name='xcri_provider[add2]' value='" .  $provider['add2'] . "' \>";
}

// ADDRESS 3
function cpd_provider_add3(){

	global $provider;

	echo "<input type='text' name='xcri_provider[add3]' value='" .  $provider['add3'] . "' \>";
}



// TODO: Address Line 4 ------------------------>>>>>>>>>>>>>






// POSTCODE
function cpd_provider_postcode(){

	global $provider;

	echo "<input type='text' name='xcri_provider[postcode]' value='" .  $provider['postcode'] . "' \>";
}

// PHONE
function cpd_provider_phone(){

	global $provider;

	echo "<input type='text' name='xcri_provider[phone]' value='" .  $provider['phone'] . "' \>";
}

// EMAIL
function cpd_provider_email(){

	global $provider;

	echo "<input type='text' name='xcri_provider[email]' value='" .  $provider['email'] . "' \>";
}

// DESCRIPTION
function cpd_provider_description(){

	global $provider;

	echo "<textarea name='xcri_provider[description]'>".  $provider['description'] . "</textarea>";
}

// LOCATION URL
function cpd_provider_location_url(){

	global $provider;

	echo "<input type='text' name='xcri_provider[location_url]' value='" .  $provider['location_url'] . "' \>";
}


// -----------------------------------------------------------------------------------------------
//  SECTION CALLBACKS - TO DISPLAY DESCRIPTIONS
// -----------------------------------------------------------------------------------------------

// We don't want any descriptions but the functions need to be here so there's no error
function cpd_main_options_dsc_callback(){}
function cpd_venues_dsc_callback(){}
function cpd_am_dsc_callback(){}
function cpd_ap_dsc_callback(){}
function cpd_provider_dsc_callback(){}

?>