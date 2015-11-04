<?php

/**
 * Customizer additions.
 *
 * @package Workstation Pro
 * @author  StudioPress
 * @link    http://my.studiopress.com/themes/workstation/
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
function workstation_customizer_get_default_accent_color() {
	return '#ff4800';
}

add_action( 'customize_register', 'workstation_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function workstation_customizer_register() {

	global $wp_customize;

	$images = apply_filters( 'workstation_images', array( '1', '2' ) );

	$wp_customize->add_section( 'workstation-settings', array(
		'description' => __( 'Use the included default images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1800 pixels wide and 500 pixels tall</strong>.', 'workstation' ),
		'title'    => __( 'Front Page Background Images', 'workstation' ),
		'priority' => 35,
	) );

	foreach( $images as $image ){

		$wp_customize->add_setting( $image .'-workstation-image', array(
			'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'type'     => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $image .'-workstation-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'workstation' ), $image ),
			'section'  => 'workstation-settings',
			'settings' => $image .'-workstation-image',
			'priority' => $image+1,
		) ) );

	}

	$wp_customize->add_setting(
		'workstation_accent_color',
		array(
			'default' => workstation_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'workstation_accent_color',
			array(
				'description' => __( 'Change the default accent color for links, buttons, and more.', 'workstation' ),
			    'label'       => __( 'Accent Color', 'workstation' ),
			    'section'     => 'colors',
			    'settings'    => 'workstation_accent_color',
			)
		)
	);

}
