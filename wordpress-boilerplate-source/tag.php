<?php
    $elr_archive = new ELR_Archive;
    $elr_post = new ELR_Post;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <header class="archive-header">
                <h1 class="archive-title"><?php $elr_archive->tag_archive_title(); ?></h1>
                <?php $elr_archive->tag_archive_description(); ?>
            </header>
            <?php $elr_post->loop(); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>