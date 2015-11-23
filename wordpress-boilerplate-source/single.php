<?php get_header(); ?>

<main class="main-content">
    <div class="content-holder">

    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content/content', get_post_format() ); ?>

        <?php get_template_part( 'partials/post-nav' ); ?>

        <?php comments_template(); ?>

    <?php endwhile; ?>

    </div>  
    <!-- /#content -->
    <?php get_sidebar(); ?>

</main>

<?php get_footer(); ?>