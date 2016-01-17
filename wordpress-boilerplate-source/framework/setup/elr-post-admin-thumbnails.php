<?php
/**
 * @package ELR_Post_Admin_Thumbnails
 * @version 0.1
*/

add_filter( 'manage_posts_columns', 'posts_columns', 5 );
add_action( 'manage_posts_custom_column', 'posts_custom_columns', 5, 2 );

function posts_columns( $defaults ){
    $defaults['elr_post_thumbs'] = __( 'Thumbs' );
    return $defaults;
}

function posts_custom_columns( $column_name, $id ){
        if( $column_name === 'elr_post_thumbs' ){
        echo the_post_thumbnail( array( 100, 100 ) );
    }
}