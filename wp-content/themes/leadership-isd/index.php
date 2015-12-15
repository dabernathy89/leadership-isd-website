<?php

//* Customize the post info function
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_date] [post_comments] [post_edit]';
	return $post_info;
}}

// Force content-sidebar layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

// Remove entry meta from entry footer
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();