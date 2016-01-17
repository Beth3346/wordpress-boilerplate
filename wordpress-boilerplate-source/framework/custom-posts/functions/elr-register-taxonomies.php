<?php
/**
 * Register taxonomies for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @param  string   $singular_name    singular form of taxonomy name
 * @param  string   $plural_name      plural form of taxonomy name
 * @param  string   $cpt_singular     singular form of cpt name
 * @param  string   $cpt_plural       plural form of cpt name
 * @param  boolean  $hierarchical     whether or not taxonomy is hierarchical
 * @param  array    $terms            default taxonomy terms
 * @return void.
 */

if ( ! function_exists( 'elr_register_taxonomies' ) ) {
    function elr_register_taxonomies( $singular_name, $plural_name, $cpt_singular, $cpt_plural, $hierarchical = true, $default_terms ) {
        $text_domain = 'elr-' . str_replace( '_' , '-', $singular_name );

        /* Get the plugin settings. */
        $settings = get_option( 'plugin_elr_' . $cpt_plural, elr_get_default_settings( $cpt_singular, $cpt_plural ) );

        /* Set up the arguments for the priority taxonomy. */
        $args = array(
            'public'            => true,
            'show_ui'           => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
            'hierarchical'      => $hierarchical,
            'query_var'         => $singular_name,

            /* Only 2 caps are needed: 'manage_announcement' and 'edit_announcement'. */
            'capabilities' => array(
                'manage_terms' => 'manage_' . $cpt_singular,
                'edit_terms'   => 'manage_' . $cpt_singular,
                'delete_terms' => 'manage_' . $cpt_singular,
                'assign_terms' => 'edit_' . $cpt_plural,
            ),

            /* Labels used when displaying taxonomy and terms. */
            'labels' => array(
                'name'                       => __( ucwords( str_replace( '_' , ' ', $plural_name ) ),                      $text_domain ),
                'singular_name'              => __( ucwords( str_replace( '_' , ' ', $singular_name ) ),                    $text_domain ),
                'menu_name'                  => __( ucwords( str_replace( '_' , ' ', $plural_name ) ),                      $text_domain ),
                'name_admin_bar'             => __( ucwords( str_replace( '_' , ' ', $singular_name ) ),                    $text_domain ),
                'search_items'               => __( 'Search ' . ucwords( str_replace( '_' , ' ', $plural_name ) ),          $text_domain ),
                'popular_items'              => __( 'Popular ' . ucwords( str_replace( '_' , ' ', $plural_name ) ),         $text_domain ),
                'all_items'                  => __( 'All ' . ucwords( str_replace( '_' , ' ', $plural_name ) ),             $text_domain ),
                'edit_item'                  => __( 'Edit ' . ucwords( str_replace( '_' , ' ', $singular_name ) ),          $text_domain ),
                'view_item'                  => __( 'View ' . ucwords( str_replace( '_' , ' ', $singular_name ) ),          $text_domain ),
                'update_item'                => __( 'Update ' . ucwords( str_replace( '_' , ' ', $singular_name ) ),        $text_domain ),
                'add_new_item'               => __( 'Add New ' . ucwords( str_replace( '_' , ' ', $singular_name ) ),       $text_domain ),
                'new_item_name'              => __( 'New ' . ucwords( str_replace( '_' , ' ', $singular_name ) ) . ' Name', $text_domain ),
                'add_or_remove_items'        => __( 'Add or remove ' . str_replace( '_' , ' ', $plural_name ),              $text_domain ),
                'choose_from_most_used'      => __( 'Choose from the most used ' . str_replace( '_' , ' ', $plural_name ),  $text_domain ),
                'separate_items_with_commas' => __( 'Separate ' . str_replace( '_' , ' ', $plural_name ) . 'with commas',   $text_domain ),
            )
        );

        // Register the taxonomy
        register_taxonomy( $singular_name, array( $cpt_singular ), $args );

        // add default terms
        elr_taxonomy_add_default_terms( $singular_name, $default_terms );
    }
}