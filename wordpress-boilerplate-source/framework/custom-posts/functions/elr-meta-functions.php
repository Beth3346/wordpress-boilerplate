<?php

/**
 * Registers custom metadata for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $fields Array of fields to register
 * @return void
 */

if ( ! function_exists( 'elr_register_meta' ) ) {
    function elr_register_meta( $fields ) {
        foreach ( $fields as $field ) {
            register_meta( 'post', $field, 'elr_sanitize_meta', '__return_true' );
        }
    }
}

/**
 * Saves custom metadata for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $fields Array of fields to save
 * @return void
 */

if ( ! function_exists( 'elr_save_meta' ) ) {
    function elr_save_meta( $fields ) {
        global $post;

        foreach ( $fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post->ID, $field, $_POST[ $field ] );
            }
        }
    }
}

/**
 * Callback function for sanitizing meta when add_metadata() or update_metadata() is called by WordPress.
 * If a developer wants to set up a custom method for sanitizing the data, they should use the
 * "sanitize_{$meta_type}_meta_{$meta_key}" filter hook to do so.
 *
 * @since  0.1.0
 * @access public
 * @param  mixed  $meta_value The value of the data to sanitize.
 * @param  string $meta_key   The meta key name.
 * @param  string $meta_type  The type of metadata (post, comment, user, etc.)
 * @return mixed  $meta_value
 */

if ( ! function_exists( 'elr_sanitize_meta' ) ) {
    function elr_sanitize_meta( $meta_value, $meta_key, $meta_type ) {
        // if meta key has url then sanitize url
        // if meta key has email then sanitize email
        return strip_tags( $meta_value );
    }
}