<?php
/*
Template Name: Page 404
*/

// Tribe Events hack - create empty post object
global $post;
if (!isset($post)) {
	$post = new stdClass();
	$post->post_type = 'unknown';
}
// End Tribe Events hack

get_header(); 

ancora_show_post_layout( array('layout' => '404'), false );

get_footer(); 
?>