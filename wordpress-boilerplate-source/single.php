<?php
    $framework = new ELR_Framework;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php $framework->single_loop(); ?>
            <h3>Related Posts</h3>
            <?php echo $framework->related_posts('category'); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar"><?php get_sidebar(); ?></aside>
    </div>
</main>
<?php get_footer(); ?>