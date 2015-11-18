<?php
/**
 * This file adds the Home Page to the Leadership ISD Theme.
 *
 * @author Red Blue Concepts
 * @package Leadership ISD Theme
 * @subpackage Customizations
 */

//* Filter the homepage site description
add_filter( 'genesis_seo_description', 'leadership_isd_seo_description', 10, 2 );
function leadership_isd_seo_description( $description, $inside ) {

    $inside = esc_html( get_bloginfo( 'description' ) );
    $description = sprintf( '<h2 class="site-description">%s</h2>', $inside );

    return $description;

}

add_action( 'genesis_meta', 'leadership_isd_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function leadership_isd_front_page_genesis_meta() {

	//* Add front-page body class
	add_filter( 'body_class', 'leadership_isd_fp_body_class' );

	//* Force full width content layout
	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	//* Remove breadcrumbs
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

	//* Remove the default Genesis loop
	remove_action( 'genesis_loop', 'genesis_do_loop' );

	//* Add the rest of front page widgets
	add_action( 'genesis_loop', 'leadership_isd_front_page_content' );

}

function leadership_isd_front_page_content() {

	global $post;

	include( get_stylesheet_directory() . '/templates/front-page/front-page-1.php' );

	include( get_stylesheet_directory() . '/templates/front-page/front-page-2.php' );

	include( get_stylesheet_directory() . '/templates/front-page/front-page-3.php' );

	include( get_stylesheet_directory() . '/templates/front-page/front-page-4.php' );

	include( get_stylesheet_directory() . '/templates/front-page/front-page-5.php' );

}

function leadership_isd_fp_body_class( $classes ) {
	$classes[] = 'front-page';

	return $classes;
}

genesis();
