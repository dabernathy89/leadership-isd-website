<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Leadership ISD Theme' );
define( 'CHILD_THEME_URL', 'http://www.leadershipdisd.org/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'leadership_isd_enqueue_scripts_styles' );
function leadership_isd_enqueue_scripts_styles() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300italic,700italic,700,300', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'leadership-isd-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => 'Menu',
		'subMenu'  => 'Menu',
	);
	wp_localize_script( 'leadership-isd-responsive-menu', 'LeadershipISDL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add accessibility support
add_theme_support( 'genesis-accessibility', array( 'drop-down-menu', 'headings', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'flex-height'     => true,
	'width'           => 300,
	'height'          => 60,
	'header-selector' => '.site-title a',
	'header-text'     => false,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'footer',
) );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add new image sizes
add_image_size( 'featured-content-lg', 1200, 600, TRUE );
add_image_size( 'featured-content-sm', 600, 400, TRUE );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Rename Primary Menu
add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Header Navigation Menu', 'secondary' => 'Before Header Navigation Menu' ) );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reposition the navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_nav', 5 );


//* Remove skip link for primary navigation and add skip link for footer widgets
add_filter( 'genesis_skip_links_output', 'leadership_isd_skip_links_output' );
function leadership_isd_skip_links_output( $links ){

	if( isset( $links['genesis-nav-primary'] ) ){
		unset( $links['genesis-nav-primary'] );
	}

	$new_links = $links;
	array_splice( $new_links, 3 );

	if ( is_active_sidebar( 'flex-footer' ) ) {
		$new_links['footer'] = 'Skip to footer';
	}

	return array_merge( $new_links, $links );

}

//* Reposition the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 8 );

//* Reposition the entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

//* Add featured image above the entry content
add_action( 'genesis_entry_header', 'leadership_isd_featured_photo', 5 );
function leadership_isd_featured_photo() {

	if ( is_attachment() || ! genesis_get_option( 'content_archive_thumbnail' ) )
		return;

	if ( is_singular() && $image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) ) ) {
		printf( '<div class="featured-image"><img src="%s" alt="%s" class="entry-image"/></div>', $image, the_title_attribute( 'echo=0' ) );
	}

}

//* Add Excerpt support to Pages
add_post_type_support( 'page', 'excerpt' );

//* Output Excerpt on Pages
add_action( 'genesis_meta', 'leadership_isd_page_description_meta' );
function leadership_isd_page_description_meta() {

	if ( is_front_page() ) {
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
		add_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		add_action( 'genesis_after_header', 'genesis_seo_site_description', 10 );
		add_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
	}

	if ( is_archive() && ! is_post_type_archive() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
		add_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 10 );
		add_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
	}

	if ( is_post_type_archive() && genesis_has_post_type_archive_support() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
		add_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		add_action( 'genesis_after_header', 'genesis_do_cpt_archive_title_description', 10 );
		add_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
	}

	if( is_author() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
		add_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		add_action( 'genesis_after_header', 'genesis_do_author_title_description', 10 );
		add_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
	}

	if ( is_page_template( 'page_blog.php' ) && has_excerpt() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
		add_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		add_action( 'genesis_after_header', 'leadership_isd_add_page_description', 10 );
		add_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
	}

	elseif ( is_singular() && is_page() && has_excerpt() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		add_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		add_action( 'genesis_after_header', 'leadership_isd_add_page_description', 10 );
		add_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
	}

}

function leadership_isd_add_page_description() {

	echo '<div class="page-description">';
	echo '<h1 itemprop="headline" class="page-title">' . get_the_title() . '</h1>';
	echo '<p>' . get_the_excerpt() . '</p></div>';

}

function leadership_isd_open_after_header() {
	echo '<div class="after-header"><div class="wrap">';
}

function leadership_isd_close_after_header() {
	echo '</div></div>';
}

//* Setup widget counts
function leadership_isd_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

function leadership_isd_widget_area_class( $id ) {

	$count = leadership_isd_count_widgets( $id );

	$class = '';

	if( $count == 1 ) {
		$class .= ' widget-full';
	} elseif( $count % 3 == 1 ) {
		$class .= ' widget-thirds';
	} elseif( $count % 4 == 1 ) {
		$class .= ' widget-fourths';
	} elseif( $count % 6 == 0 ) {
		$class .= ' widget-uneven';
	} elseif( $count % 2 == 0 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

//* Add the flexible footer widget area
add_action( 'genesis_before_footer', 'leadership_isd_footer_widgets' );
function leadership_isd_footer_widgets() {

	genesis_widget_area( 'flex-footer', array(
		'before' => '<div id="footer" class="flex-footer footer-widgets"><h2 class="genesis-sidebar-title screen-reader-text">Footer</h2><div class="flexible-widgets widget-area wrap' . leadership_isd_widget_area_class( 'flex-footer' ) . '">',
		'after'  => '</div></div>',
	) );

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => 'Front Page 1',
	'description' => 'This is the front page 1 section.',
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => 'Front Page 2',
	'description' => 'This is the front page 2 section.',
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => 'Front Page 3',
	'description' => 'This is the front page 3 section.',
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => 'Front Page 4',
	'description' => 'This is the front page 4 section.',
) );
genesis_register_sidebar( array(
	'id'          => 'flex-footer',
	'name'        => 'Flexible Footer',
	'description' => 'This is the footer section.',
) );
