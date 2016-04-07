<?php $elr_post = new ELR_Post; ?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
    <header>
        <?php $elr_post->post_title(); ?>
        <?php $elr_post->post_meta(get_the_ID()); ?>
    </header>
    <?php $elr_post->post_thumbnail(); ?>
    <?php $elr_post->post_content(); ?>
    <footer><?php $elr_post->edit_link(); ?></footer>
</article>