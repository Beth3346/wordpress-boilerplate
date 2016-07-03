<?php
    use Framework\Helpers\Loop;
    use Framework\Helpers\PostHelper;
    $loop = new Loop;
    $post_helper = new PostHelper;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php $loop->singleLoop(); ?>
            <h3>Related Posts</h3>
            <?php echo $post_helper->relatedPosts('category'); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar"><?php get_sidebar(); ?></aside>
    </div>
</main>
<?php get_footer(); ?>