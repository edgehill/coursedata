<?php 
#--------------------------------------
#  	TESTS!
#--------------------------------------
//add_action('admin_bar_init','dantest');
add_action('admin_footer', 'dantest');
function dantest(){
    

	//Change the values in the database.. REMOVE ME AFTERWARDS!
	global $wpdb;

	// 1. change each venue of 1 to old1
	//$wpdb->query("UPDATE $wpdb->postmeta SET meta_value='old1' WHERE meta_key ='venue' AND meta_value='1'");

	// 2. change each 2 to 1
	//$wpdb->query("UPDATE $wpdb->postmeta SET meta_value='1' WHERE meta_key ='venue' AND meta_value='2'");

	// 3. change each temp to old1
	//$wpdb->query("UPDATE $wpdb->postmeta SET meta_value='2' WHERE meta_key ='venue' AND meta_value='old1'");





	/*
	UPDATE wp_postmeta SET meta_value='was5' WHERE meta_key ='venue' AND meta_value='5'


	SELECT * FROM wp_postmeta WHERE meta_key ='venue' 



	*/


    $post_id = 309;
    $user_id = get_post_meta($post_id, '_edit_last', true);
    echo $user_id;
    $user = get_userdata($user_id);
   
   echo $user->user_login;
    /* SCREEN, PAGENOW & CURRENT SCREEN....
    echo "<br /><br /><h1>screen</h1>";
    $screen = get_current_screen();
    print_r($screen);
    
    echo "<br /><br /><h1>pagenow</h1>";
    global $pagenow;
    print_r($pagenow);
    
    echo "<br /><br /><h1>current_screen</h1>";
    global $current_screen;
    print_r($current_screen);
	*/
	
	
	//if(file_exists(plugin_dir_path(__FILE__) . 'courses.php')){ echo "True"; } else { echo "False";}
	//echo plugins_url('datepicker', __FILE__);//__FILE__; //plugin_dir_path(__FILE__);//. 'datepicker/js/my-configuration.js';
	//if(file_exists(plugin_dir_path(__FILE__). '/datepicker/js/my-configuration.js')){ echo "True";}else{echo "false";}	
	
	
	/* ------------------
	TESTED OUTPUTS....
	
	....FROM within 'courses.php' (main plugin file)
	
	__FILE__								=  /Applications/MAMP/htdocs/cpd-courses/wp-content/plugins/courses-plugin/courses.php
	plugin_dir_path(__FILE__)  				=  /Applications/MAMP/htdocs/cpd-courses/wp-content/plugins/courses-plugin/
	plugins_url()							=  http://localhost:8888/cpd-courses/wp-content/plugins
	plugins_url('courses-plugin') 			= http://localhost:8888/cpd-courses/wp-content/plugins/courses_plugin
	plugins_url('datepicker', __FILE__); 	= http://localhost:8888/cpd-courses/wp-content/plugins/courses-plugin/datepicker
	---------------------*/	
}
?>