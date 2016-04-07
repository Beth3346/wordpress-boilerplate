<?php
$service_builder = new ELR_CPT_Builder;
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
add_action( 'init', function() use ( $service_builder ) {
        $cpt_singular_name = 'service';
        $cpt_plural_name = 'services';
        $supports = ['title', 'editor', 'thumbnail'];
        $taxonomies = ['category', 'post_tag'];
        return $service_builder->register_post_types( $cpt_singular_name, $cpt_plural_name, $supports, $taxonomies );
    }, 12
);

add_action( 'init', function() use ( $service_builder ) {
        $tax_singular_name = 'service category';
        $tax_plural_name = 'service categories';
        $cpt_singular = 'service';
        $cpt_plural = 'services';
        $hierarchical = true;
        $default_terms = [];
        return $service_builder->register_taxonomies( $tax_singular_name, $tax_plural_name, $cpt_singular, $cpt_plural, $hierarchical, $default_terms );
    }, 12
);

// list all meta keys
$fields = array(
    '_service_field',
);

/* Register meta on the 'init' hook. */
add_action( 'init', function() use ( $fields, $service_builder ) { $service_builder->register_meta( $fields ); }, 12 );
add_action( 'add_meta_boxes', 'add_cpt_service_boxes' );
add_action( 'save_post', function() use ( $fields, $service_builder ) { return $service_builder->save_meta( $fields ); }, 12 );

if ( ! function_exists( 'add_cpt_service_boxes' ) ) {
    function add_cpt_service_boxes() {
        // add meta boxes here
        add_meta_box(
            'service_info',
            'Services',
            'service_cpt_info_cb',
            'cpt',
            'normal',
            'high'
        );
        // create meta box html
        function service_cpt_info_cb() {
            global $post;
            $field = get_post_meta( $post->ID, '_service_field', true );


            //implement security
            wp_nonce_field( __FILE__, 'cpt_nonce' ); ?>

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