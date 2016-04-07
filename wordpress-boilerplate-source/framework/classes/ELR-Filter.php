<?php

class ELR_Filter_Posts {
    public function filter_taxonomy_scripts() {
        wp_localize_script( 'main', 'elr_vars', array(
                'elr_nonce' => wp_create_nonce( 'elr_nonce' ),
                'elr_ajax_url' => admin_url( 'admin-ajax.php' ),
                'elr_current_term' => strtolower( single_term_title( '', false ) ),
                'elr_current_tax' => 'type'
            )
        );
    }

    // Script for getting posts
    public function filter_taxonomy( $taxonomy ) {

        // Verify nonce
        if ( !isset( $_POST['elr_nonce'] ) || !wp_verify_nonce( $_POST['elr_nonce'], 'elr_nonce' ) ) {
            die('Permission denied');
        }

        $tax_args = array();
        $current_tax = null;

        if ( array_key_exists( 'taxonomy', $_POST ) ) {
            $taxonomy = $_POST['taxonomy'];

            foreach ( $taxonomy as $key => $value ) {
                $arr = array( 'taxonomy' => $key, 'field' => 'slug', 'terms' => array( $value ) );
                array_push( $tax_args, $arr );
            }

            // check if taxonomy page
            if ( $_POST['elr_current_term'] ) {
                $current_tax = $_POST['elr_current_term'];
                $arr = array( 'taxonomy' => 'type', 'field' => 'slug', 'terms' => array( $current_tax ) );
                array_push( $tax_args, $arr );
            }
        }

        if ( array_key_exists( 'num', $_POST ) ) {
            $num = $_POST['num'];
        } else {
            $num = 20;
        }

        if ( array_key_exists( 'post_type', $_POST ) ) {
            $post_type = $_POST['post_type'];
        } else {
            $post_type = 'posts';
        }

        if ( post_type_exists( $post_type ) ) {
            $count_posts = wp_count_posts( $post_type );
            $num_posts = $count_posts->publish;
        } else {
            $num_posts = 0;
        }

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        // WP Query
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $num,
            'tax_query' => $tax_args,
            'paged' => $paged,
            'post_status' => 'publish'
        );

        // If taxonomy is not set, remove key from array and get all posts
        if ( !$taxonomy ) {
            unset( $args['tax_query'] );
        }

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php require( get_template_directory() . '/content/content-' . $post_type . '.php' ); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <h2>No products found</h2>
        <?php endif;

        die();
    }
}

// $elr_filter = new ELR_Filter_Posts;

// add_action( 'wp_enqueue_scripts', [$elr_filter, 'filter_taxonomy_scripts']);
// add_action( 'wp_ajax_filter_taxonomy', [$elr_filter, 'filter_taxonomy']);
// add_action( 'wp_ajax_nopriv_filter_taxonomy', [$elr_filter, 'filter_taxonomy']);