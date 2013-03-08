<?php

/*
Plugin Name: Courses
Plugin URI: http://www.edgehill.ac.uk
Description:  System to manage information for CPD courses.
Author: Dan Brown
Version: 1.0
Author URI: http://www.edgehill.ac.uk
*/

// This plugin is for the management of courses and presentations for health CPDs. It also outputs the information in an XCRI feed. 

// Save URL Path to plugin. 
global $plugin_url;
$plugin_url = plugins_url('', __FILE__); 
/*-------------------------------
Usage:
global $plugin_url;
$plugin_url . '/js/toggle-item';
---------------------------------*/

// Add the javascripts
add_action('template_redirect', 'cpd_add_frontend_scripts');
function cpd_add_frontend_scripts(){
	
	global $post;
	// Scripts only for the course page
	if($post->post_type == 'courses' || $post->post_type == 'presentations' ){
		
		global $plugin_url;
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'toggle-times', $plugin_url.'/js/toggle-times.js', 'jquery' );
		
	}
}

// Get the plugin's files
require_once dirname( __FILE__ ) . '/make-cpts-and-taxonomies.php';		// Make custom post types and taxonomies...
require_once dirname( __FILE__ ) . '/admin/admin-ui-and-settings.php';	// Admin UI and settings...
require_once dirname( __FILE__ ) . '/css/css.php';						// Include the CSS...
require_once dirname( __FILE__ ) . '/admin/save.php';					// Save and delete....
//require_once dirname( __FILE__ ) . '/page-templates/make-page-templates.php';		// Make page templates...
require_once dirname( __FILE__ ) . '/general-functions.php';			// General functions...
require_once dirname( __FILE__ ) . '/options-pages/options-main.php';	// Make options pages...
require_once dirname( __FILE__ ) . '/feed/make-xcri-feed.php';			// XCRI Feed and related functions...
require_once dirname( __FILE__ ) . '/tests.php'; 						// Tests...

function courses_flush_rewrite_rules(){
	flush_rewrite_rules();
}
add_action('init', 'courses_flush_rewrite_rules');
