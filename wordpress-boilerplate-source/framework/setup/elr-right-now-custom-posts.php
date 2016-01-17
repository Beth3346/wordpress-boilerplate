<?php
/**
 * @package ELR_Dashboard_CPTs
 * @version 0.1
*/

// Add custom post types to right now dashboard
if ( ! function_exists( 'elr_dashboard_cpts' ) ) {
    function elr_dashboard_cpts() {

        $args = array(
            'public' => true ,
            '_builtin' => false
        );

        $output = 'object';
        $operator = 'and';
        $post_types = get_post_types( $args , $output , $operator );

        foreach( $post_types as $post_type ) {
            $num_posts = wp_count_posts( $post_type->name );
            $num = number_format_i18n( $num_posts->publish );
            $text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );

            if ( current_user_can( 'edit_posts' ) ) {
                $num = "<a href='edit.php?post_type=$post_type->name'>$num";
                $text = "$text</a>";
            }

            echo '<li class="post-count">' . $num . ' ' . $text . '</li>';
        }

        // $taxonomies = get_taxonomies( $args , $output , $operator );

        // foreach( $taxonomies as $taxonomy ) {
        //     $num_terms  = wp_count_terms( $taxonomy->name );
        //     $num = number_format_i18n( $num_terms );
        //     $text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name , intval( $num_terms ));

        //     if ( current_user_can( 'manage_categories' ) ) {
        //         $num = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num";
        //         $text = "$text</a>";
        //     }

        //     echo '<li class="post-count">' . $num . ' ' . $text . '</li>';
        // }
    }
}

add_action( 'dashboard_glance_items' , 'elr_dashboard_cpts' );