<?php

/**
 * Customizer additions.
 *
 * @package Leadership ISD Theme
 * @author 	Red Blue Concepts
 * @link    http://www.leadershipdisd.org/
 * @license GPL2-0+
 */

add_action( 'customize_register', 'leadership_isd_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function leadership_isd_customizer_register() {

	global $wp_customize;

	$images = apply_filters( 'leadership_isd_images', array( '1', '2' ) );

	$wp_customize->add_section( 'leadership-isd-settings', array(
		'description' => 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1800 pixels wide and 500 pixels tall</strong>.',
		'title'    => 'Front Page Background Images',
		'priority' => 35,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-leadership-isd-image', array(
			'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'     => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $image .'-leadership-isd-image', array(
			'label'    => sprintf( 'Featured Section %s Image:', $image ),
			'section'  => 'leadership-isd-settings',
			'settings' => $image .'-leadership-isd-image',
			'priority' => $image+1,
		) ) );

	}

}
