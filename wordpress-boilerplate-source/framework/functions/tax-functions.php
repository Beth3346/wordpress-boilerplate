<?php

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_get_current_tax( $query ) {

    if ( is_tax() ) {

        $tax_term = $query->queried_object;
        return $tax_term->name;

    } else {

        return null;
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

function elr_tax_nav( $post_type, $taxonomy, $current_term = null ) {

    $tax_args = array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => true
    );

    $tax_name = ucwords( str_replace( '_' , ' ', $taxonomy ) );
    $terms = get_terms( array( $taxonomy ), $tax_args );
    $term_names = array();

    // create an array of term names
    foreach ( $terms as $term ) {
        array_push( $term_names, $term->name );
    }

    if ( $terms ) {
        echo '<nav class="taxonomy-nav">';
        // echo '<h4>' . $tax_name . ': </h4>';
        echo '<ul class="taxonomy-menu" data-tax="' . $taxonomy . '">';

        // if ( $current_term && in_array( $post_type, $term_names, $current_term ) ) {
        //     echo '<li><a href="/' . $post_type . '/" data-term="all">All</a></li>';
        // } else {
        //     echo '<li><a href="/' . $post_type . '/" class="active" data-term="all">All</a></li>';
        // }

            // list all terms
            foreach ( $terms as $term ) {
                $term_link = get_term_link( $term );
                echo '<li>';
                    echo '<a href="';
                    echo esc_url( $term_link ) . '"';

                        if ( $term->name === $current_term ) {
                            echo 'class="active"';
                        }

                        echo 'data-term="' . $term->slug . '"';
                    echo '>';
                    echo $term->name;
                echo '</a></li>';
            }
        echo '</ul></nav>';
    }
}

/**
 * Echos comma separated taxonomy term links
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_taxonomy_terms( $taxonomy, $id ) {
    $terms = get_the_terms( $id, $taxonomy );
    $last_key = array_search( end( $terms ), $terms );

    foreach ( $terms as $key => $value ) {
        $term_link = get_term_link( $value );

        echo '<a href="';
        echo $term_link;
        echo '">';
        echo $value->name;

        if ( $key === $last_key ) {
            echo '</a> ';
        } else {
            echo '</a>, ';
        }
    }
}

function elr_is_parent_term( $term ) {
    if ( $term->parent == 0 ) {
        return true;
    } else {
        return false;
    }
}

function elr_get_parents($taxonomy) {
    $terms = get_terms($taxonomy, 'orderby=count&hide_empty=1&hierarchical=1');
    $parents = [];
    foreach ($terms as $term) {
        if (elr_is_parent_term($term)) {
            array_push($parents, $term);
        }
    }

    return $parents;
}

function elr_term_has_posts($id, $taxonomy) {
    $args = array(
        // 'post_type' => 'post',
        'status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $id
            )
        )
    );
    $term_query =  new WP_Query($args);
    $term_posts_count = $term_query->found_posts;
    if( $term_posts_count>0 ){
        return true;
    } else {
        return false;
    }
}

function elr_get_children($term, $taxonomy) {
    if( elr_is_parent_term( $term ) ) {
        $terms = [];
        $ids = get_term_children( $term->term_id, $taxonomy );

        foreach ($ids as $id) {
            if (elr_term_has_posts($id, $taxonomy)) {
                array_push($terms, get_term($id));
            }
        }
    } else {
        $terms = null;
    }

    return $terms;
}