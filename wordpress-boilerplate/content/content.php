<?php
    use Framework\Helpers\PostHelper;
    use Framework\Helpers\ContentHelper;

    $post_helper = new PostHelper;
    $content_helper = new ContentHelper;
?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
    <header>
        <?php $post_helper->postTitle(); ?>
        <?php $post_helper->postMeta(get_the_ID()); ?>
    </header>

    <?php $post_helper->postThumbnail(); ?>
    <?php $post_helper->postContent(); ?>

    <footer>
        <?php $content_helper->editLink(); ?>
    </footer>

    <?php comments_template(); ?>
</article>