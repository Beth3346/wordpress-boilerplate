<?php get_header(); ?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php // the loop ?>
            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content/content', get_post_format() ); ?>

                <?php endwhile; ?>

                <?php get_template_part( 'partials/pagination' ); ?>

            <?php else : ?>

                <?php get_template_part( 'content/content', 'none' ); ?>

            <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</main>
<?php get_footer(); ?>