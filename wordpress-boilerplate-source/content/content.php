<?php $framework = new ELR_Framework; ?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
    <header>
        <?php $framework->post_title(); ?>
        <?php $framework->post_meta(get_the_ID()); ?>
    </header>
    <?php $framework->post_thumbnail(); ?>
    <?php $framework->post_content(); ?>
    <footer><?php $framework->edit_link(); ?></footer>
</article>