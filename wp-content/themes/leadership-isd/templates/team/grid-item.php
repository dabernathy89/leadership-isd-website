<div class="team-member one-third <?php echo $is_first; ?>">
    <?php the_post_thumbnail('medium'); ?>
    <div class="entry">
        <h3><?php the_title(); ?></h3>
        <p class="title">
            <?php echo get_post_meta( get_the_ID(), '_rbm_members_title', true ); ?>
        </p>
        <a class="button" href="<?php the_permalink(); ?>">Read bio</a>
    </div>
</div>