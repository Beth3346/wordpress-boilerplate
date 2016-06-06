<?php
    use Framework\Helpers\Archive;
    use Framework\Helpers\Loop;
    $archive = new Archive;
    $loop = new Loop;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <header class="archive-header">
                <h1 class="archive-title"><?php $archive->categoryArchiveTitle(); ?></h1>
                <?php $archive->categoryArchiveDescription(); ?>
            </header>
            <?php $loop->loop(); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>