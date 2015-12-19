<header class="entry-header">
    <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
</header>

<div class="entry-content" itemprop="text">
    <?php the_content(); ?>
</div>

<?php

    $fellows_cat = get_field('fellows_current');

    $fellows_args = array(
        'post_type' => 'members',
        'posts_per_page' => 12,
        'paged' => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'member-types',
                'field' => 'slug',
                'terms' => 'fellows'
            )
        )
    );

    if (!empty($fellows_cat) && property_exists($fellows_cat[0], 'term_id')) {
        $fellows_args['tax_query'] = array(
            array(
                'taxonomy' => 'member-types',
                'terms' => $fellows_cat[0]->term_id
            )
        );
        $fellows_section_title = $fellows_cat[0]->name;
    }

    $fellows = new WP_Query($fellows_args);
?>

<?php if ( $fellows->have_posts() ) : ?>
    <div class="wrap fellows-grid">

        <?php if (isset($fellows_section_title)) : ?>
            <h2><?php echo $fellows_section_title; ?></h2>
        <?php endif; ?>

        <?php while ( $fellows->have_posts() ) : $fellows->the_post(); ?>

            <?php $is_first = ($fellows->current_post % 3 === 0) ? "first" : ""; ?>

            <?php include( get_stylesheet_directory() . '/templates/fellows/grid-item.php' ); ?>

        <?php endwhile; ?>

    </div>

    <div class="wrap">
        <?php lisd_posts_navigation($fellows, "Next page", "Previous page"); ?>
    </div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>