<?php

/**
 * Customizer additions.
 *
 * @package Leadership ISD Theme
 * @author 	Red Blue Concepts
 * @link    http://www.leadershipdisd.org/
 * @license GPL2-0+
 */

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 1.0.0
 *
 * @return string Hex color code for accent color.
 */
function leadership_isd_customizer_get_default_accent_color() {
	return '#ff4800';
}

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

	$wp_customize->add_setting(
		'leadership_isd_accent_color',
		array(
			'default' => leadership_isd_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'leadership_isd_accent_color',
			array(
				'description' => 'Change the default accent color for links, buttons, and more.',
			    'label'       => 'Accent Color',
			    'section'     => 'colors',
			    'settings'    => 'leadership_isd_accent_color',
			)
		)
	);

}
