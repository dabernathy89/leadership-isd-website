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

	$version = "201512093";

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300italic,700italic,700,300,400', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'leadership', get_bloginfo( 'stylesheet_directory' ) . '/sass/style.css' );

	wp_enqueue_script( 'leadership-isd-main-js', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery' ), $version, true );
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
add_image_size( 'featured-content-lg', 1200, 350, TRUE );
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
add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Header Navigation Menu', 'secondary' => 'Secondary Navigation Menu' ) );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reposition the navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 5 );

add_action( 'genesis_before_header', 'leadership_isd_header_logo', 5 );
function leadership_isd_header_logo() {
	include_once( get_stylesheet_directory() . '/templates/header-logo.php' );
}

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

	if ( is_singular() && !is_singular('partners') && !is_singular('members') && $image = genesis_get_image( array( 'format' => 'url', 'size' => genesis_get_option( 'image_size' ) ) ) ) {
		printf( '<div class="featured-image"><img src="%s" alt="%s" class="entry-image"/></div>', $image, the_title_attribute( 'echo=0' ) );
	}

}

//* Add Excerpt support to Pages
add_post_type_support( 'page', 'excerpt' );

// Remove default header content
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove default footer content
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Output Excerpt on Pages
add_action( 'genesis_meta', 'leadership_isd_page_description_meta' );
function leadership_isd_page_description_meta() {

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

	if ( is_post_type_archive(array('members','partners'))) {
		remove_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
		remove_action( 'genesis_after_header', 'genesis_do_cpt_archive_title_description', 10 );
		remove_action( 'genesis_after_header', 'leadership_isd_close_after_header', 15 );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );
	}

	if (is_singular('partners') || is_singular('members')) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );
	}

	if (is_singular('partners')) {
		add_action( 'genesis_entry_footer', 'genesis_post_meta', 10 );
	}

	if (is_singular('members')) {
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
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
	'id'          => 'flex-footer',
	'name'        => 'Flexible Footer',
	'description' => 'This is the footer section.',
) );

genesis_register_sidebar( array(
	'id'          => 'events-sidebar',
	'name'        => 'Events Sidebar',
	'description' => 'This is the sidebar for the events/calendar pages.'
) );

function impact_stories_excerpt_length( $length ) {
	if (is_category('impact-stories')) {
		$length = 30;
	}
	return $length;
}
add_filter( 'excerpt_length', 'impact_stories_excerpt_length', 999 );

function lisd_excerpt_read_more( $more ) {
	global $post;
	return '...<br><a class="button read-more" href="' . get_permalink( $post->ID ) . '">Read More</a>';
}
add_filter('excerpt_more', 'lisd_excerpt_read_more');

function lisd_exclude_impact_stories_from_main_blog( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
    	$cat_id = get_category_by_slug('impact-stories');
    	if ($cat_id !== false) {
	        $query->set( 'category__not_in', $cat_id );
	    }
    }
}
add_action( 'pre_get_posts', 'lisd_exclude_impact_stories_from_main_blog' );

function lisd_posts_navigation($custom_query = null, $next_text = 'Older posts', $prev_text = 'Newer posts') {
	$max = is_null($custom_query) ? $GLOBALS['wp_query']->max_num_pages : $custom_query->max_num_pages;

	// Don't print empty markup if there's only one page.
	if ( $max < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<ul class="nav-links pager">

			<?php if ( get_next_posts_link('', $max) ) : ?>
			<li class="previous"><?php next_posts_link($next_text, $max); ?></li>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<li class="next"><?php previous_posts_link($prev_text); ?></li>
			<?php endif; ?>

		</ul><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

function lisd_add_impact_pins_endpoint() {
	add_rewrite_tag( '%get_impact_pins%', '([0-9]+)' );
    add_rewrite_rule( 'retrieve-impact-pins/?', 'index.php?get_impact_pins=1', 'top' );
}
add_action( 'init', 'lisd_add_impact_pins_endpoint' );

function lisd_get_impact_pins() {
    global $wp_query;

    $item_id = $wp_query->get( 'get_impact_pins' );

    if ( ! empty( $item_id ) && $item_id === "1" ) {
    	$pins = array(
    		'type' => 'FeatureCollection',
    		'features' => array()
    	);

        $impact_stories = get_posts(array(
        	'posts_per_page' => -1,
        	'tax_query' => array(
        		array(
        			'taxonomy' => 'category',
        			'field' => 'slug',
        			'terms' => 'impact-stories'
        		)
        	)
        ));

        foreach ($impact_stories as $impact_story) {
        	$lat_lng_string = get_field('impact_story_lat_lng', $impact_story->ID);

        	if ($lat_lng_string) {
	        	$lat_lng = explode(',', $lat_lng_string);
	        	$lat_lng[0] = (float)$lat_lng[0];
	        	$lat_lng[1] = (float)$lat_lng[1];
	        	$lat_lng = array_reverse($lat_lng);
	        } else {
	        	continue;
	        }

	        $infowindow = "<strong>" . get_the_title( $impact_story->ID ) . "</strong>";
	        $infowindow .= "<br>";
	        $infowindow .= '<a href="' . get_permalink($impact_story->ID) . '">Learn more</a>';

        	$pins['features'][] = array(
        		'type' => 'Feature',
        		'geometry' => array(
        			'type' => 'Point',
        			'coordinates' => $lat_lng
        		),
        		'properties' => array(
        			'title' => $infowindow
        		)
        	);
        }

        wp_send_json( $pins );
    }
}
add_action( 'template_redirect', 'lisd_get_impact_pins' );