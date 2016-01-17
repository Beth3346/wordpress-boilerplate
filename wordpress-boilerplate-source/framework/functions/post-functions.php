<?php

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_thumbnail( $holder = 'post-image-holder', $thumbnail_size = array( 400, 9999 ) ) {

    if ( has_post_thumbnail() ) {

        echo '<div class="' . $holder . '">';

            if ( is_single() || is_page() ) {
                the_post_thumbnail( $thumbnail_size );

            } else {
                echo '<a href="';
                    the_permalink();
                echo '">';
                    the_post_thumbnail( $thumbnail_size );
                echo '</a>';
            }

            $caption = get_post(get_post_thumbnail_id())->post_excerpt;

            if ( $caption ) {

                echo '<figcaption class="post-image-caption">';
                    echo esc_html( $caption );
                echo '</figcaption>';
            }

        echo '</div>';
    }
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_archive_link( $post_type, $text = 'See More' ) {

    $cpt_archive = get_post_type_archive_link( $post_type );
    $post_name = get_post_type_object( $post_type )->label;

    echo '<a href="' . $cpt_archive . '" class="archive-link">' . $text . '</a>';
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_get_single_loop($archive_link = false, $archive_link_text = 'See More') {

    while ( have_posts() ) : the_post();

        if ( function_exists( 'elr_is_custom_post_type' ) ) {

            if ( elr_is_custom_post_type() ) {

                get_template_part( 'content/content', get_post_type() );

            } else {

                get_template_part( 'content/content', get_post_format() );
            }

        } else {

            get_template_part( 'content/content', get_post_format() );
        }

        wp_link_pages(array('before' => '<p><strong>'.__('Pages:','elr').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));

        get_template_part( 'partials/post-nav' );

        if ( elr_is_custom_post_type() ) {
            elr_archive_link( get_post_type(), $archive_link_text );
        }

        if ( comments_open() ) {
            comments_template();
        }

    endwhile;
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_category() {
    the_category(', ');
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_author() {
    the_author_posts_link();
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_tags() {
    the_tags(' <li class="post-tag"><i class="fa fa-tags"></i> ', ', ', '</li>');
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_comments() {

    if ( comments_open() ) {
        comments_popup_link( __( '0 Comments', 'elr' ), __( '1 Comment', 'elr' ), __( '% Comments', 'elr') );
    }
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_meta( $id ) {

    echo '<ul class="post-meta elr-inline-list">';
        echo '<li class="post-date"><i class="fa fa-calendar"></i> ';
            elr_post_date();
        echo '</li>';
        echo '<li class="post-author"><i class="fa fa-user"></i> ';
            elr_post_author();
        echo '</li>';
        echo '<li class="post-category"><i class="fa fa-folder"></i> ';
            elr_post_category();
        echo '</li>';
        elr_post_tags();
        if ( comments_open() ) {
            echo '<li class="post-comment"><i class="fa fa-comment"></i> ';
            elr_post_comments();
            echo '</li>';
        }
    echo '</ul>';
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_title() {

    if ( is_single() || is_page() ) {
        echo '<h1 class="post-title" role="heading">';
            the_title();
        echo '</h1>';

    } else {

        echo '<h1 class="post-title" role="heading"><a href="';
        the_permalink();
        echo '">';
        the_title();
        echo '</a></h1>';
    }
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_content( $id, $excerpt = true ) {

    if ( is_single() || is_page() ) {
        the_content();
    } elseif ( $excerpt === true ) {
        echo '<div class="post-excerpt-' . $id . '">';
            the_excerpt();
        echo '</div>';
    } else {
        the_content();
    }
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_actions_nav( $id ) {
    edit_post_link( __( '<i class="fa fa-pencil-square-o"></i>', 'elr' ) );

    if ( current_user_can( 'publish_posts' ) ) {
        echo ' <a href="/wp-admin/post-new.php?post_type=';
        echo get_post_type();
        echo '"><i class="fa fa-plus"></i></a> ';
    }

    if ( current_user_can( 'delete_posts' ) ) {
        echo '<a href="';
        echo get_delete_post_link( $id );
        echo '"><i class="fa fa-trash-o"></i></a>';
    }
}

function elr_edit_link($text = 'Edit') {
    edit_post_link( __( $text, 'elr' ) );
}