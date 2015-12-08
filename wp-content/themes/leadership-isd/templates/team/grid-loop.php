<header class="entry-header">
    <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
</header>

<div class="entry-content" itemprop="text">
    <?php the_content(); ?>
</div>

<?php
    $our_team_args = array(
        'post_type' => 'members',
        'posts_per_page' => 12,
        'paged' => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'member-types',
                'field' => 'slug',
                'terms' => 'our-team'
            )
        )
    );

    $our_team = new WP_Query($our_team_args);
?>

<?php if ( $our_team->have_posts() ) : ?>
    <div class="wrap our-team-grid">
        <?php while ( $our_team->have_posts() ) : $our_team->the_post(); ?>

            <?php $is_first = ($our_team->current_post % 2 === 0) ? "first" : ""; ?>

            <?php include( get_stylesheet_directory() . '/templates/fellows/grid-item.php' ); ?>

        <?php endwhile; ?>

        <hr>
    </div>

    <div class="wrap">
        <?php lisd_posts_navigation($our_team, "Next page", "Previous page"); ?>
    </div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>