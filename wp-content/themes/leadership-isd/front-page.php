<?php
/**
 * This file adds the Home Page to the Workstation Pro Theme.
 *
 * @author StudioPress
 * @package Workstation Pro
 * @subpackage Customizations
 */

//* Filter the homepage site description
add_filter( 'genesis_seo_description', 'workstation_seo_description', 10, 2 );
function workstation_seo_description( $description, $inside ) {

    $inside = esc_html( get_bloginfo( 'description' ) );
    $description = sprintf( '<h2 class="site-description">%s</h2>', $inside );

    return $description;

}

add_action( 'genesis_meta', 'workstation_front_page_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function workstation_front_page_genesis_meta() {

	if ( is_active_sidebar( 'front-page-1' ) || is_active_sidebar( 'front-page-2' ) || is_active_sidebar( 'front-page-3' ) || is_active_sidebar( 'front-page-4' ) ) {

		//* Add front-page body class
		add_filter( 'body_class', 'workstation_body_class' );
		function workstation_body_class( $classes ) {

   			$classes[] = 'front-page';

  			return $classes;
  
		}

		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add the rest of front page widgets
		add_action( 'genesis_loop', 'workstation_front_page_widgets' );

	}

}

function workstation_front_page_widgets() {

	$image_section_1 = get_option( '1-workstation-image', sprintf( '%s/images/bg-1.jpg', get_stylesheet_directory_uri() ) );

	$image_section_2 = get_option( '2-workstation-image', sprintf( '%s/images/bg-2.jpg', get_stylesheet_directory_uri() ) );

	if ( ! empty( $image_section_1 ) ) {	
		echo '<div class="image-section-1"></div>';	
	}

	genesis_widget_area( 'front-page-1', array(
		'before' => '<div id="front-page-1" class="front-page-1"><div class="flexible-widgets widget-area wrap' . workstation_widget_area_class( 'front-page-1' ) . '">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-2', array(
		'before' => '<div id="front-page-2" class="front-page-2"><div class="flexible-widgets widget-area wrap' . workstation_widget_area_class( 'front-page-2' ) . '">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'front-page-3', array(
		'before' => '<div id="front-page-3" class="front-page-3"><div class="flexible-widgets widget-area wrap' . workstation_widget_area_class( 'front-page-3' ) . '">',
		'after'  => '</div></div>',
	) );

	if ( ! empty( $image_section_2 ) ) {
		echo '<div class="image-section-2"></div>';
	}

	genesis_widget_area( 'front-page-4', array(
		'before' => '<div id="front-page-4" class="front-page-4"><div class="flexible-widgets widget-area wrap' . workstation_widget_area_class( 'front-page-4' ) . '">',
		'after'  => '</div></div>',
	) );

}

genesis();
