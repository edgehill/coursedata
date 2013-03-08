<?php 
// CPD Options Pages
// ---------------------------------------------------
// Register the options page and pull in the resources

add_action('admin_menu', 'cpd_add_options_menu');
add_action('admin_init', 'cpd_initialise_options');  

// Make menu
function cpd_add_options_menu(){
    add_options_page(
        'CPD Course - Manage Information', 		// page title
        'CPD Courses - Manage Info',         	// menu title
        'manage_options',           			// capability
        'manage-info-page',    					// slug
        'cpd_plugin_options_page'  				// callback function
    );    
}

// Register and initialise the fields and sections with WP Settings API
require_once dirname( __FILE__ ) . '/initialise-options.php';

// The pages...
require_once dirname( __FILE__ ) . '/options-views.php';

// The fields...
require_once dirname( __FILE__ ) . '/options-fields.php';

// The validate functions... (used to handle all the saves)
require_once dirname( __FILE__ ) . '/options-validation.php';
?>