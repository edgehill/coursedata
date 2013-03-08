<?php
//--------------------------------------
//	MAKE THE XCRI FEED
//--------------------------------------
// Old way of doing xcri feed....
/*
add_action('do_feed_xcri-feed', 'cpd_xcri_feed', 10, 1); // Make sure you have 'do_feed_#customfeed#'
function cpd_xcri_feed() {
	load_template( plugin_dir_path(__FILE__). '/feed/xcri-feed.php'); // You'll create a your-custom-feed.php file in your theme's directory
}
*/




/*
add_action('init', 'my_add_feed');

function my_rewrite_rules( $wp_rewrite ) {
  $new_rules = array(
    'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
  );
  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

function my_add_feed(  ) {
  global $wp_rewrite;
  add_feed('custom-feed', 'my_create_feed');
  add_action('generate_rewrite_rules', 'my_rewrite_rules');
  $wp_rewrite->flush_rules();
}
*/





// Make a custom feed

add_action('init', 'custom_xcri_feed');

function custom_xcri_feed()
{	
	global $wp_rewrite;
    add_feed('courses.xml', 'custom_xcri_feed_template');
    add_action('generate_rewrite_rules', 'my_rewrite_rules');
  	$wp_rewrite->flush_rules();
}



function my_rewrite_rules( $wp_rewrite ) {

	  $new_rules = array(
	    	'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
	  );
	  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
 
function custom_xcri_feed_template()
{
     load_template( dirname( __FILE__ ) . '/custom-xcri-feed.php');
}


/* 
 *  Insert feed elements from Postmeta Table..
 *
 *  Display the feed element and contents only if...
 * 	 a) It exists in DB
 * 	 b) Its not empty
 *
 *  Only used in THE_LOOP. 
 *
 *  Args($meta_key = postmeta meta_key value; $tag_name = tag text)
 *
 */
function display_feed_item($meta_key, $tag_name){ 
	    
	global $post;
	$feed_content = trim(get_post_meta($post->ID, $meta_key, true)); // trim - so won't display even if just whitespace in DB
	if($feed_content){
		echo "<".$tag_name.">" . $feed_content . "</".$tag_name.">\n";
	}

}

// Displays a venue's attributes if it exists
/*
 * It must be passed the $venue array that results from cpd_get_venue
 *
 */
function display_venue_item($venue, $name, $tag){

	$feed_item = trim($venue[$name]);
	if($feed_item){ 
		echo "<".$tag.">".$feed_item."</".$tag.">";
	}


}

// Same as above but takes all the tags out
function display_feed_item_no_tags($meta_key, $tag_name){ //
	    
	global $post;
	$feed_content = trim(get_post_meta($post->ID, $meta_key, true)); // trim - so won't display even if just whitespace in DB
	$transform1 = wp_kses($feed_content, array()); // filter tags
	$transform2 = esc_attr($transform1); // escape html 
	if($feed_content){
		echo "<".$tag_name.">" . $transform2 . "</".$tag_name.">\n";
	}

}


// same as above function but can define a post_id
function display_feed_item_from_id($meta_key, $tag_name, $post_id){ 
	    
	$feed_content = trim(get_post_meta($post_id, $meta_key, true)); // trim - so won't display even if just whitespace in DB
	if($feed_content){
		echo "<".$tag_name.">" . $feed_content . "</".$tag_name.">";
	}

}


?>