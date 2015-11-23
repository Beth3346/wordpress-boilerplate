<?php get_header(); ?>
<main class="main-content">
    <div class="content-holder">
        <?php // the loop ?>
        <?php if (have_posts()) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'elr' ), single_tag_title( '', false ) ); ?></h1>

                <?php
                    // Show an optional term description.
                    $term_description = term_description();
                    if ( ! empty( $term_description ) ) :
                        printf( '<div class="taxonomy-description">%s</div>', $term_description );
                    endif;
                ?>
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
</main>
<?php get_footer(); ?>