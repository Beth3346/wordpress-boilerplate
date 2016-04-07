<?php

class ELR_Archive {
    public function author_archive_title() {
        the_post();
        printf( __( 'All posts by %s', 'elr' ), get_the_author() );
    }

    public function author_archive_description() {
        if ( get_the_author_meta( 'description' ) ) {
            echo '<div class="author-description">';
            echo get_the_author_meta( 'description' );
            echo '</div>';
        }
    }

    public function category_archive_title() {
        printf( __( 'Category: %s', 'elr' ), single_cat_title( '', false ) );
    }

    public function category_archive_description() {
        $term_description = term_description();
        if ( ! empty( $term_description ) ) :
            printf( '<div class="taxonomy-description">%s</div>', $term_description );
        endif;
    }

    public function search_archive_title() {
        printf( __( 'Search Results for: %s', 'elr' ), '<span>' . get_search_query() . '</span>' );
    }

    public function tag_archive_title() {
        printf( __( 'Tag: %s', 'elr' ), single_tag_title( '', false ) );
    }

    public function tag_archive_description() {
        // Show an optional term description.
        $term_description = term_description();
        if ( ! empty( $term_description ) ) :
            printf( '<div class="taxonomy-description">%s</div>', $term_description );
        endif;
    }
}