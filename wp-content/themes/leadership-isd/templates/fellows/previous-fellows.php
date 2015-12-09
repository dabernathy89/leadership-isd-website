<div class="wrap previous-fellows">
    <?php $previous_fellows_cats = get_field('fellows_previous'); ?>

    <?php foreach ($previous_fellows_cats as $index => $previous_fellows_cat) : ?>

        <?php
            $prev_fellows = new WP_Query(array(
                'post_type' => 'members',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'member-types',
                        'terms' => $previous_fellows_cat['category']->term_id
                    )
                )
            ));
        ?>

        <?php if ( $prev_fellows->have_posts() ) : ?>
            <div class="one-third fellows-class <?php echo ($index % 3 === 0) ? "first" : ""; ?>">
                <ul>
                <strong><?php echo $previous_fellows_cat['category']->name; ?></strong>
                <?php while ( $prev_fellows->have_posts() ) : $prev_fellows->the_post(); ?>
                    <li><?php the_title(); ?></li>
                <?php endwhile;?>
                </ul>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
</div>