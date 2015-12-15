<?php

// Force sidebar-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

// Remove the post image (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'leadership_isd_featured_photo', 5 );

// add_action( 'genesis_entry_header', 'test_func', 8 );
// function test_func() {
// 	echo 'hello!';
// }

genesis();
