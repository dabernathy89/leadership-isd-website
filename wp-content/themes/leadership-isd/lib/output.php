<?php
/* 
 * Adds the required CSS to the front end.
 */

add_action( 'wp_enqueue_scripts', 'workstation_css' );
/**
* Checks the settings for the images and background colors for each image
* If any of these value are set the appropriate CSS is output
*
* @since 1.0
*/
function workstation_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color = get_theme_mod( 'workstation_accent_color', workstation_customizer_get_default_accent_color() );

	$opts = apply_filters( 'workstation_images', array( '1', '2' ) );

	$settings = array();

	foreach( $opts as $opt ){
		$settings[$opt]['image'] = preg_replace( '/^https?:/', '', get_option( $opt .'-workstation-image', sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $opt ) ) );
	}

	$css = '';

	foreach ( $settings as $section => $value ) {

		$background = $value['image'] ? sprintf( 'background-image: url(%s);', $value['image'] ) : '';

		if( is_front_page() ) {
			$css .= ( ! empty( $section ) && ! empty( $background ) ) ? sprintf( '.image-section-%s { %s }', $section, $background ) : '';
		}

	}

	$css .= ( workstation_customizer_get_default_accent_color() !== $color ) ? sprintf( '
		a,
		.add-black .after-header a:focus,
		.add-black .after-header a:hover,
		.author-box-title,
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.archive-title,
		.entry-header .entry-meta,
		.entry-title a:focus,
		.entry-title a:hover,
		.featured-content .entry-meta,
		.flexible-widgets .featured-content .has-post-thumbnail .alignnone + .entry-header .entry-title a:focus,
		.flexible-widgets .featured-content .has-post-thumbnail .alignnone + .entry-header .entry-title a:hover,
		.footer-widgets a:focus,
		.footer-widgets a:hover,
		.front-page-3 a:focus,
		.front-page-3 a:hover,
		.genesis-nav-menu .sub-menu a:focus,
		.genesis-nav-menu .sub-menu a:hover,
		.nav-secondary .genesis-nav-menu .sub-menu a:focus,
		.nav-secondary .genesis-nav-menu .sub-menu a:hover,
		.nav-secondary .genesis-nav-menu .sub-menu .current-menu-item > a,
		.page-title,
		.site-footer a:focus,
		.site-footer a:hover,
		.widget li a:focus,
		.widget li a:hover,
		.widget-title {
			color: %1$s;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.add-color .after-header,
		.add-color .site-header,
		.button,		
		.widget .button {
			background-color: %1$s;
		}

		.after-header,
		.front-page-1,
		.genesis-nav-menu .sub-menu,
		.genesis-nav-menu > .current-menu-item > a,
		.genesis-nav-menu > li > a:focus,
		.genesis-nav-menu > li > a:hover {
			border-color: %1$s;
		}
		
		@media only screen and (max-width: 880px) {
			.js nav .genesis-nav-menu .menu-item .sub-menu li a:focus,
			.js nav .genesis-nav-menu .menu-item a:focus,
			.js nav button:focus,
			.js .menu-toggle:focus {
				color: %1$s;
			}
		}
		', $color ) : '';

	if( $css ){
		wp_add_inline_style( $handle, $css );
	}

}
