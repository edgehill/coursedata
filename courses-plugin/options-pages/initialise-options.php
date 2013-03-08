<?php
// -----------------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR add_action('admin_init', 'cpd_initialise_options'); 
// -----------------------------------------------------------------------------------------------

function cpd_initialise_options(){

	// --------------------------------
	//  ADD SECTIONS
	// --------------------------------
	
    // First, register the sections. This is necessary since all future options must belong to one.  


	// MAIN OPTIONS - apply to URL, credit scheme 
	add_settings_section(  
		'main_options_section',    			// ID used to identify this section and with which to register options  
		'Main Options',       				// Title to be displayed on the administration page  
		'cpd_main_options_dsc_callback',   	// Callback used to render the description of the section  
		'main-page'         				// Page on which to add this section of options  
	);
	
	
	// VENUES SECTION
	add_settings_section(  
		'venue_section',    		// ID 
		'Venue', 		      		// Title 
		'cpd_venues_dsc_callback',	// Callback for description
		'venue-page'         		// Page on which to add this section
	);
	
	
	// ATTENDANCE MODE SECTION
	add_settings_section(  
		'am_section', 		   		// ID 
		'Attendance Mode',       	// Title 
		'cpd_am_dsc_callback',		// Callback for description
		'am-page'         			// Page on which to add this section
	);
	
	// ATTENDANCE PATTERN SECTION
	add_settings_section(  
		'ap_section', 		   		// ID 
		'Attendance Pattern',       // Title 
		'cpd_ap_dsc_callback',		// Callback for description
		'ap-page'         			// Page on which to add this section
	);


	// PROVIDER SECTION
	add_settings_section(  
		'provider_section', 		   		// ID 
		'Provider Information',       		// Title 
		'cpd_provider_dsc_callback',		// Callback for description
		'provider-page'         			// Page on which to add this section
	);
	


	// -----------------------------
	//  ADD THE FIELDS
	// -----------------------------

	// Fields for main section:

	// APPLY TO
	add_settings_field(
		'apply_to_url',				// ID used to identify this field
		'Apply to URL',				// Title of the field to be displayed next to it
		'cpd_apply_to_url',			// Callback used to render the field element
		'main-page',				// Page on which to add this field
		'main_options_section'		// Section on which to add this field
	);

	// CREDIT SCHEME
	add_settings_field(
		'credit_scheme',			// ID 
		'Credit Scheme',			// Field Title
		'cpd_credit_scheme',		// Callback used to render the field element
		'main-page',				// Page on which to add this field
		'main_options_section'		// Section on which to add this field
	);
	
	// GENERIC ABSTRACT
	add_settings_field(
		'generic_abstract',			// ID 
		'Generic Abstract',			// Field Title
		'cpd_abstract',				// Callback used to render the field element
		'main-page',				// Page on which to add this field
		'main_options_section'		// Section on which to add this field
	);
	
	// Fields for venue section:
	
	// VENUE SHORT TITLE (used for display in 'intakes' section)
	add_settings_field(
		'venue_short_title',		// ID 
		'Venue - Short Title',		// Field Title
		'cpd_venue_short_title',	// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);
	
	// VENUE TITLE	
	add_settings_field(
		'venue_title',				// ID 
		'Venue Title',				// Field Title
		'cpd_venue_title',			// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);
	
	// VENUE ADDRESS LN 1
	add_settings_field(
		'add1',						// ID 
		'Address Line 1',			// Field Title
		'cpd_add1',					// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);
	
	// VENUE ADDRESS LN 2
	add_settings_field(
		'add2',						// ID 
		'Address Line 2',			// Field Title
		'cpd_add2',					// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);

	// VENUE ADDRESS LN 3
	add_settings_field(
		'add3',						// ID 
		'Address Line 3',			// Field Title
		'cpd_add3',					// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);
	
	// VENUE ADDRESS LN 4
	add_settings_field(
		'add4',						// ID 
		'Address Line 4',			// Field Title
		'cpd_add4',					// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);	
	
	// VENUE POSTCODE
	add_settings_field(
		'postcode',					// ID 
		'Postcode',					// Field Title
		'cpd_postcode',				// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);

	// VENUE PHONE
	add_settings_field(
		'phone',					// ID 
		'Phone',					// Field Title
		'cpd_phone',				// Callback used to render the field element
		'venue-page',				// Page on which to add this field
		'venue_section'				// Section on which to add this field
	);
	
	
	// Fields for attendance mode section:
	
	// TEXT (value)
	add_settings_field(
		'text',						// ID 
		'XCRI Text',				// Field Title
		'cpd_am_xcri_text',			// Callback used to render the field element
		'am-page',					// Page on which to add this field
		'am_section'				// Section on which to add this field
	);
		
	// XCRI (key)
	add_settings_field(
		'key',						// ID 
		'XCRI Key',					// Field Title
		'cpd_am_xcri_key',			// Callback used to render the field element
		'am-page',					// Page on which to add this field
		'am_section'				// Section on which to add this field
	);
	
	
	// Fields for attendance pattern section:
	
	// TEXT (value)
	add_settings_field(
		'ap_text',					// ID 
		'XCRI Text',				// Field Title
		'cpd_ap_xcri_text',			// Callback used to render the field element
		'ap-page',					// Page on which to add this field
		'ap_section'				// Section on which to add this field
	);
		
	// XCRI (key)
	add_settings_field(
		'ap_key',					// ID 
		'XCRI Key',					// Field Title
		'cpd_ap_xcri_key',			// Callback used to render the field element
		'ap-page',					// Page on which to add this field
		'ap_section'				// Section on which to add this field
	);
	

	// Fields for provider section:
	
	// PROVIDER TITLE 
	add_settings_field(
		'provider_title',			// ID 
		'Title',					// Field Title
		'cpd_provider_title',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// URL
	add_settings_field(
		'provider_',			// ID 
		'URL',			// Field Title
		'cpd_provider_url',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// ADDRESS LINE 1
	add_settings_field(
		'provider_add1',			// ID 
		'Address Line 1',			// Field Title
		'cpd_provider_add1',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// ADDRESS LINE 2
	add_settings_field(
		'provider_add2',			// ID 
		'Address Line 2',			// Field Title
		'cpd_provider_add2',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// ADDRESS LINE 3
	add_settings_field(
		'provider_add3',			// ID 
		'Address Line 3',			// Field Title
		'cpd_provider_add3',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// POSTCODE
	add_settings_field(
		'provider_postcode',			// ID 
		'Postcode',			// Field Title
		'cpd_provider_postcode',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// PHONE
	add_settings_field(
		'provider_phone',			// ID 
		'Phone',			// Field Title
		'cpd_provider_phone',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// EMAIL
	add_settings_field(
		'provider_email',			// ID 
		'Email',			// Field Title
		'cpd_provider_email',		// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// DESCRIPTION
	add_settings_field(
		'provider_description',		// ID 
		'Description',				// Field Title
		'cpd_provider_description',	// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);

	// LOCATION URL
	add_settings_field(
		'provider_location_url',	// ID 
		'Location URL',				// Field Title
		'cpd_provider_location_url',	// Callback used to render the field element
		'provider-page',			// Page on which to add this field
		'provider_section'			// Section on which to add this field
	);
	
	
	
	// --------------------
	//  REGISTER SETTINGS
	// --------------------
	
	register_setting(  
        'main_options_section',  
        'options'  
    );

	register_setting(  
        'venue_section',  		// Group options - match settings_field() in the form
        'venues',				// DB options name
  		'validate_venues_fn'	// Callback function - validation
    );

	register_setting(  
        'am_section', 		// Group options - match settings_field() in the form
        'attendance_modes',	// DB options name
  		'validate_am_fn' 	// Callback function - validation
    );

	register_setting(  
        'ap_section', 			// Group options - match settings_field() in the form
        'attendance_patterns',	// DB options name
  		'validate_ap_fn' 		// Callback function - validation
    );

    register_setting(  
        'provider_section',		// Group options - match settings_field() in the form
        'xcri_provider'			// DB options name
    );


	
	/* ---------------
		USAGE...
	   ---------------
	// You can access the venues like this:
	
	$venues[1]['venue_title']; // Aintree Campus, Edge Hill University
	$venues[1]['add1'];			// 79 Dog Street
	$venues[1]['add2'];			// Dogville
	$venues[1]['add1'];			// Dogbury
	$venues[1]['postcode'];		// D0G D0G
	
	
	// Set the items dynamically using:
	
	$venues[$venue_id]['venue_title'];
	
	// or something like this from the input...
	
	$venue_id = $_GET['venue_id'];
	echo '<input type="text" name="venue[$venue_id]['venue_title']" />';
	
	// And if it is add new, you can calculate the last venue's id, add one to it, and put that number in the venue[$venue_id]... that way you can the 'add new' and 'edit' on one form....
	*/
	
}
?>