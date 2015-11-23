<article role="article" id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

    <header>
        <?php if ( is_single() || is_page() ) : ?>
            <h1 class="post-title" role="heading"><?php the_title(); ?></h1>
        <?php else : ?>
            <h1 class="post-title" role="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <?php endif; ?>

        <ul class="post-meta">
            <li class="post-date"><i class="fa fa-calendar"></i> <time datetime="<?php the_time('o-m-d'); ?>" pubdate><?php the_time('F j, Y'); ?></time></li>
            <li class="post-author"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></li>
            <li class="post-category"><i class="fa fa-folder"></i> <?php the_category(', '); ?></li>
            <?php the_tags(' <li class="post-tag"><i class="fa fa-tags"></i> ', ', ', '</li>'); ?>
            <?php if ( comments_open() ) {
                echo '<li class="post-comment"><i class="fa fa-comment"></i> ';
                    comments_popup_link( __( '0 Comments', 'elr' ), __( '1 Comment', 'elr' ), __( '% Comments', 'elr' ) );
                echo '</li>';
            } ?>
        </ul>
    </header>

    <!-- if we have a featured image then display it -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-image">
        <?php $thumbnail_size = array( 400, 9999 ); ?>
        <?php if ( is_single() || is_page() ) : ?>
            <?php the_post_thumbnail( $thumbnail_size ); ?>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( $thumbnail_size ); ?></a>
        <?php endif; ?>

        <?php $caption = get_post( get_post_thumbnail_id() )->post_excerpt; ?>
        <?php if ( $caption ) : ?>
            <p class="post-image-caption"><?php echo esc_html( $caption ); ?></p>
        <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- display the post content -->
    <div>
        <div>
        <?php if ( is_single() || is_page() ) : ?>
            <?php the_content(); ?>
        <?php else : ?>
            <div class="post-excerpt <?php echo $id; ?>">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
        </div>
    </div>

    <footer>
        <?php edit_post_link( __( 'Edit', 'elr' ) ); ?>
    </footer>

</article>