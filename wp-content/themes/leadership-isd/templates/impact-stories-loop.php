<article <?php post_class('wrap'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <?php if ($wp_query->current_post % 2 === 1) : ?>
            <div class="featured-image-wrap one-third pull-right">
        <?php else : ?>
            <div class="featured-image-wrap one-third first">
        <?php endif; ?>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
        </div><!-- featured-image-wrap -->
    <?php endif; ?>

    <?php if (has_post_thumbnail() && $wp_query->current_post % 2 === 1) : ?>
        <div class="entry two-thirds first">
    <?php elseif (has_post_thumbnail()) : ?>
        <div class="entry two-thirds">
    <?php else : ?>
        <div class="entry">
    <?php endif; ?>
            <h3 class="title"><?php the_title(); ?></h3>
            <div class="excerpt"><?php the_excerpt(); ?></div>

    </div><!-- entry -->

    <!-- <hr> -->

</article>