<?php

//////////////////////////////////////////////////////////////////////
// Register Custom Menu Function
//////////////////////////////////////////////////////////////////////

if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus( array(
        'main-nav' => __( 'Main Navigation', 'elr' ),
    ) );
}

if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus( array(
        'footer-nav' => __( 'Footer Navigation', 'elr' ),
    ) );
}