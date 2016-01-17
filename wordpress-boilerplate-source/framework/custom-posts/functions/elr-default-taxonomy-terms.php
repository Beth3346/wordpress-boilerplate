<?php

/**
 * Adds default terms to taxonomy
 *
 * @since  0.1.0
 * @access public
 * @param  string   $parent taxonomy to receive the terms
 * @param  array    $terms  array of terms to add to $parent
 * @return null
 */

if ( ! function_exists( 'elr_taxonomy_add_default_terms' ) ) {
    function elr_taxonomy_add_default_terms( $parent, $terms ) {
        $parent_term = term_exists( $parent, $parent );
        $parent_term_id = $parent_term['term_id'];

        foreach ( $terms as $term ) {
            if ( !term_exists( $term, $parent ) ) {
                wp_insert_term(
                  $term,
                  $parent,
                  array(
                    'slug' => $term,
                    'parent'=> $parent_term_id
                  )
                );
            }
        }
    }
}