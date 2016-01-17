<?php 
/**
 * Returns the default settings for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @param string    $singular_name  singular form of cpt name
 * @param string    $plural_name    plural form of cpt name
 * @return array
 */

if ( ! function_exists( 'elr_get_default_settings' ) ) {
    function elr_get_default_settings( $singular_name, $plural_name ) {

        $settings = array(
            $singular_name . '_root'      => str_replace( '_' , '-', $plural_name ),
            $singular_name . '_base'      => str_replace( '_' , '-', $plural_name ),
            $singular_name . '_item_base' => '%' . str_replace( '_' , '-', $singular_name ) . '%'
        );

        return $settings;
    }
}