<?php
    // Template Name: Full Width
    use Framework\Helpers\Loop;

    $loop = new Loop;

    get_header();
?>

<main class="main-content">
    <div class="content-holder elr-container-full">
        <div class="elr-row">
            <?php $loop->pageLoop(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>