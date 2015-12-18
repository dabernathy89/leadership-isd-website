<div class="wrap">
    <header class="entry-header">
        <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
    </header>

    <div class="entry-content" itemprop="text">
        <?php the_content(); ?>
    </div>
</div>

<?php

    // Pull in the category from the selection
    $category = get_post_meta( get_the_ID(), 'rb_category', true );

    // Take the selection (which is a number), and pull the full category object
    $category = get_term_by( 'id', $category, 'member-types' );

    $our_team_args = array(
        'post_type' => 'members',
        'posts_per_page' => 12,
        'paged' => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'member-types',
                'field' => 'slug',
                'terms' => $category
            )
        )
    );

    $our_team = new WP_Query($our_team_args);
?>

<?php if ( $our_team->have_posts() ) : ?>
    <div class="wrap our-team-grid">
        
        <?php
        while ( $our_team->have_posts() ) : $our_team->the_post();
        
            $is_first = ($our_team->current_post % 3 === 0) ? "first" : "";

            include( get_stylesheet_directory() . '/templates/team/grid-item.php' );

        endwhile;
        ?>

    </div>

    <div class="wrap">
        <?php lisd_posts_navigation($our_team, "Next page", "Previous page"); ?>
    </div>

<?php 
endif;
wp_reset_postdata(); 
?>