<section id="front-page-4" class="front-page-4">
    <div class="wrap">
        <div class="inner">
            <?php the_field('home_section_4_content'); ?>
        </div>

        <?php
            $blog_args = array(
                'post_type' => 'post',
                'posts_per_page' => 4,
                'paged' => ( get_query_var('paged') ) ? get_query_var('paged') : 1,
                'ignore_sticky_posts' => true
            );

            $blog = new WP_Query($blog_args);
        ?>

        <?php if ( $blog->have_posts() ) : ?>
            <?php while ( $blog->have_posts() ) : $blog->the_post(); ?>

                <article class="post one-half <?php echo ($blog->current_post % 2 === 0) ? 'first' : ''; ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>

                    <div class="entry">
                        <time class="entry-date published" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <h4 class="blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                </article>

            <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</section>