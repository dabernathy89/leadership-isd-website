<section id="front-page-2" class="front-page-2">
    <div class="wrap">
        <div class="inner">
            <?php the_field('home_who_content'); ?>
        </div>
        <div class="fellows">
            <?php $fellows = get_field('home_who_fellows'); ?>

            <?php foreach ($fellows as $post) : ?>
                <?php setup_postdata( $post ); ?>

                <article>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'fellows-square' ); ?>
                        </a>
                    <?php endif; ?>
                    <h4 class="name">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                    <div class="meta">
                        <?php $member_class = get_the_terms( get_the_ID(), 'member-types' ); ?>
                        <?php echo $member_class[0]->name; ?>
                    </div>
                </article>

            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>