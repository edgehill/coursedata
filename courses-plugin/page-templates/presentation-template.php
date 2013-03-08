<?php // NOTE: These page templates are here for legacy purposes. The actual presentation template is in the themes folder (single-presentations.php)
// Redirect to related course

$course = cpd_get_course($post->ID);
$url = get_permalink($course['id']);

wp_redirect( $url );
exit;

?>