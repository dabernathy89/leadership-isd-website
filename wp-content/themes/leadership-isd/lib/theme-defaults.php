<?php

//* Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'leadership_isd_theme_defaults' );
function leadership_isd_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = '';
	$defaults['image_size']                = 'featured-content-lg';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'sidebar-content';

	return $defaults;

}

//* Theme Setup
add_action( 'after_switch_theme', 'leadership_isd_theme_setting_defaults' );
function leadership_isd_theme_setting_defaults() {

	if( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => '',
			'image_size'                => 'featured-content-lg',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'sidebar-content',
		) );

	}

	update_option( 'posts_per_page', 6 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'leadership_isd_social_default_styles' );
function leadership_isd_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'aligncenter',
		'background_color'       => '#000000',
		'background_color_hover' => '#222222',
		'border_radius'          => 4,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 40,
		);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}