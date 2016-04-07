<?php
    $elr_archive = new ELR_Archive;
    $elr_post = new ELR_Post;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <h1 class="page-title"><?php $elr_archive->search_archive_title(); ?></h1>
            <?php $$elr_archive->post->loop(); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>