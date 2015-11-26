<?php

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_sidebar', 'lisd_event_archive_sidebar');

function lisd_event_archive_sidebar() {
    genesis_widget_area('events-sidebar');
}

genesis();