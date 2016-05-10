<?php
// Custom Post Type Archive Sample
$framework = new ELR_Framework;
?>

<?php get_header(); ?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php $framework->loop(); ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>