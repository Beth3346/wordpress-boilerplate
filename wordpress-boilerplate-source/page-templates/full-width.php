<?php
// Template Name: Full Width

$elr_post = new ELR_Post;
?>

<?php get_header(); ?>

<main class="main-content">
    <div class="content-holder elr-container-full">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="elr-row">
            <article class="full-width elr-col-full">
                <header><?php $elr_post->post_title(); ?></header>
                <?php $elr_post->post_thumbnail(); ?>
                <?php $elr_post->post_content(); ?>
                <?php $elr_post->link_pages(); ?>
                <footer><?php $elr_post->edit_link(); ?></footer>
            </article>
        </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>