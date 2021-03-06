<?php
/*
 * Adds the required CSS to the front end.
 */

add_action( 'wp_enqueue_scripts', 'leadership_isd_css' );
/**
* Checks the settings for the images and background colors for each image
* If any of these value are set the appropriate CSS is output
*
* @since 1.0
*/
function leadership_isd_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$opts = apply_filters( 'leadership_isd_images', array( '1', '2' ) );

	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-leadership-isd-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.image-section-%s { %s }', $section, $background ) : '';
		}

	}

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
