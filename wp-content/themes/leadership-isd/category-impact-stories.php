<?php

add_action( 'genesis_meta', 'lisd_cat_page_description_meta' );

function lisd_cat_page_description_meta() {
    remove_action( 'genesis_after_header', 'leadership_isd_open_after_header', 5 );
    add_action( 'genesis_after_header', 'lisd_cat_open_after_header', 5 );

    remove_action( 'genesis_loop', 'genesis_do_loop' );
    add_action( 'genesis_loop', 'lisd_impact_stories_loop' );
}

function lisd_cat_open_after_header() {

    $cat_id = (string)get_query_var('cat');
    $cat_bg = get_field('cat_archive_background_image', "category_$cat_id");
    echo '<div class="after-header" data-bg="' . $cat_bg . '"><div class="wrap">';

}

function lisd_impact_stories_loop() {
    global $wp_query;

    if ( have_posts() ) :

        do_action( 'genesis_before_endwhile' );

        while ( have_posts() ) : the_post();

            include( get_stylesheet_directory() . '/templates/impact-stories-loop.php' );

        endwhile;

        echo '<div class="wrap pagination-wrap">';
            do_action( 'genesis_after_endwhile' );
        echo '</div>';

    else :
        do_action( 'genesis_loop_else' );
    endif;
}

genesis();