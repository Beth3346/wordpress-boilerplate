<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
    <header>
        <?php elr_post_title(); ?>
        <?php elr_post_meta( get_the_ID ); ?>
    </header>
    <?php elr_post_thumbnail(); ?>
    <div><?php elr_post_content( get_the_ID ); ?></div>
    <footer><?php elr_edit_link(); ?></footer>
</article>