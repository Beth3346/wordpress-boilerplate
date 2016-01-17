<?php

$singular_name = 'service';
$plural_name = 'services';

/* Get the administrator role. */
$role = get_role( 'administrator' );

/* If the administrator role exists, add required capabilities for the plugin. */
if ( !empty( $role ) ) {
    $role->add_cap( 'manage_' . $singular_name );
    $role->add_cap( 'create_' . $plural_name );
    $role->add_cap( 'edit_' . $plural_name );
}

/* Register custom post types on the 'init' hook. */
add_action( 'init', function() {
        $cpt_singular_name = 'service';
        $cpt_plural_name = 'services';
        $supports = array( 'title', 'editor', 'thumbnail' );
        $taxonomies = array( 'category', 'post_tag' );
        return elr_register_post_types( $cpt_singular_name, $cpt_plural_name, $supports, $taxonomies );
    }, 12
);

add_action( 'init', function() {
        $tax_singular_name = 'service category';
        $tax_plural_name = 'service categories';
        $cpt_singular = 'service';
        $cpt_plural = 'services';
        $hierarchical = true;
        $terms = array(
            'food', 'home'
        ); // list default terms
        return elr_register_taxonomies( $tax_singular_name, $tax_plural_name, $cpt_singular, $cpt_plural, $hierarchical, $terms );
    }, 12
);

// list all meta keys
$fields = array(
    '_service_field',
);

/* Register meta on the 'init' hook. */
add_action( 'init', function() use ( $fields ) { elr_register_meta( $fields ); }, 12 );
add_action( 'add_meta_boxes', 'elr_add_cpt_cpt_boxes' );
add_action( 'save_post', function() use ( $fields ) { return elr_save_meta( $fields ); }, 12 );

if ( ! function_exists( 'elr_add_cpt_cpt_boxes' ) ) {
    function elr_add_cpt_cpt_boxes() {
        // add meta boxes here
        add_meta_box(
            'elr_cpt_info',
            'Services',
            'elr_cpt_info_cb',
            'cpt',
            'normal',
            'high'
        );
        // create meta box html
        function elr_cpt_cpt_info_cb() {
            global $post;
            $field = get_post_meta( $post->ID, '_service_field', true );


            //implement security
            wp_nonce_field( __FILE__, 'elr_nonce' ); ?>

            <label for="_field">Label: </label>
            <input
                type="text"
                id="_service_field"
                name="_service_field"
                value="<?php echo esc_attr( $field ); ?>"
                class="widefat"
            />
    <?php }
    }
}
?>