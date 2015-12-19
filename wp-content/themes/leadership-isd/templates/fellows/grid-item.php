<div class="fellow one-third <?php echo $is_first; ?>">

	<?php

	edit_post_link( 'Edit this member...', '<small style="display:block;">', '</small>' );

    $content = get_the_content();
    $permalink = get_the_permalink();
    $title = get_the_title();

    if ( $content ) {
    	echo '<a href="' . $permalink . '">';
	    	the_post_thumbnail( 'thumbnail' );
    	echo '</a>';
    } else {
	    the_post_thumbnail( 'thumbnail' );
    }

    echo '<div class="entry">';

    	if ( $content ) {
	    	printf( '<h3><a href="%s">%s</a></h3>', $permalink, $title );
	    } else {
	    	printf( '<h3>%s</h3>', $title );
	    }
	   
        the_excerpt();
        
    echo '</div>';
echo '</div>';