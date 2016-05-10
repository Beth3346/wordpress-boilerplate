<?php
    $framework = new ELR_Framework;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <header><?php $framework->post_title(); ?></header>
                <?php $framework->post_thumbnail(); ?>
                <?php $framework->post_content(); ?>
                <?php $framework->link_pages(); ?>
                <footer><?php $framework->edit_link(); ?></footer>
            </article>
            <?php endwhile; ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>