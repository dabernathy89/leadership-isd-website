<?php
/* Template Name: Our Team */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'lisd_our_team_archive_loop' );

function lisd_our_team_archive_loop() {

    include( get_stylesheet_directory() . '/templates/team/grid-loop.php' );

}

genesis();