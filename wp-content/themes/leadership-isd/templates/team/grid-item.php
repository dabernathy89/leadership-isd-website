<div class="team-member one-half <?php echo $is_first; ?>">
    <?php the_post_thumbnail('medium'); ?>
    <div class="entry">
        <h3><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a></h3>
        <?php the_excerpt(); ?>
    </div>
</div>