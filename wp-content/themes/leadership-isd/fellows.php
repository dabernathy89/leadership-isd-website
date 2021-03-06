<?php
/* Template Name: Fellows */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'lisd_fellows_archive_loop' );

function lisd_fellows_archive_loop() {

    include( get_stylesheet_directory() . '/templates/fellows/grid-loop.php' );

    include( get_stylesheet_directory() . '/templates/fellows/previous-fellows.php' );

}

function custom_excerpt_length( $length ) {
	return 9;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

add_action( 'pre_get_posts', 'rb_unlimited_per_page' );
function rb_unlimited_per_page( $query ) {
	$query->set( 'posts_per_page', '-1' );
}

genesis();