<?php get_header(); ?>

<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content/content', get_post_format() ); ?>

            <?php get_template_part( 'partials/post-nav' ); ?>

            <?php comments_template(); ?>

        <?php endwhile; ?>

        </div>
        <!-- /#content -->
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>