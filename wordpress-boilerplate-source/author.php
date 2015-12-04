<?php get_header(); ?>
<main class="main-content elr-container-full">
    <div class="elr-row">
        <div class="content-holder elr-col-two-thirds">
            <?php // the loop ?>
            <?php if (have_posts()) : ?>
                <header class="archive-header">
                    <h1 class="archive-title">
                        <?php
                            /*
                             * Queue the first post, that way we know what author
                             * we're dealing with (if that is the case).
                             *
                             * We reset this later so we can run the loop properly
                             * with a call to rewind_posts().
                             */
                            the_post();

                            printf( __( 'All posts by %s', 'elr' ), get_the_author() );
                        ?>
                    </h1>
                    <?php if ( get_the_author_meta( 'description' ) ) : ?>

                        <div class="author-description"><?php the_author_meta( 'description' ); ?></div>

                    <?php endif; ?>
                </header><!-- .archive-header -->

                <?php while (have_posts()) : the_post(); ?>

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