<?php
    $elr_posts = new ELR_Post;
    $elr_query = new ELR_Post_Query;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php $elr_posts->single_loop(); ?>
            <h3>Related Posts</h3>
            <?php echo $elr_query->related_posts('category'); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar"><?php get_sidebar(); ?></aside>
    </div>
</main>
<?php get_footer(); ?>