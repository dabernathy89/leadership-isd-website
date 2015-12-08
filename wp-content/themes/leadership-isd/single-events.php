<?php

// Set up the layout for content-sidebar
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );

// Move the post meta to above the post
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_header', 'genesis_post_meta', 8 );

add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {

	$allday = get_post_meta( get_the_ID(), 'be_calendar_allday', true );
	$start = date( 'l, F jS', get_post_meta( get_the_ID(), 'be_event_start', true ) );
	$starttime = date( 'g:i a', get_post_meta( get_the_ID(), 'be_event_start', true ) );
	$end = date( 'l, F jS', get_post_meta( get_the_ID(), 'be_event_end', true ) );
	$endtime = date( 'g:i a', get_post_meta( get_the_ID(), 'be_event_end', true ) );

	$post_meta = $starttime . ' ' . $start . ' – ' . $endtime . ' ' . $end;

	if ( $start == $end )
		$post_meta = $starttime . ' ' . $start;

	// $post_meta = '[post_categories before="// " after=""] [post_tags before="Tagged: "]';
	return $post_meta;
}

// Remove the default sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_sidebar', 'lisd_event_archive_sidebar');

// Add an event-specific sidebar instead
function lisd_event_archive_sidebar() {
    genesis_widget_area( 'events-sidebar' );
}

genesis();