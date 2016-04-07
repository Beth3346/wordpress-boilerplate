<?php
    $elr_post = new ELR_Post;
    get_header();
?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php while ( have_posts() ) : the_post(); ?>
            <article>
                <header><?php $elr_post->post_title(); ?></header>
                <?php $elr_post->post_thumbnail(); ?>
                <?php $elr_post->post_content(); ?>
                <?php $elr_post->link_pages(); ?>
                <footer><?php $elr_post->edit_link(); ?></footer>
            </article>
            <?php endwhile; ?>
        </div>
        <aside class="sidebar elr-col-third" id="sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>