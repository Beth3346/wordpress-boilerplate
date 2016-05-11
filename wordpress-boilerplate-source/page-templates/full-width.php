<?php
// Template Name: Full Width
$framework = new ELR_Framework;
?>

<?php get_header(); ?>

<main class="main-content">
    <div class="content-holder elr-container-full">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="elr-row">
            <article class="full-width elr-col-full">
                <header><?php $framework->post_title(); ?></header>
                <?php $framework->post_thumbnail(); ?>
                <?php $framework->post_content(); ?>
                <?php $framework->link_pages(); ?>
                <footer><?php $framework->edit_link(); ?></footer>
            </article>
        </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>