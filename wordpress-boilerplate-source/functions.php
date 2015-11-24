<?php

///////////////////////////////////////////////////////////////////////////////////////////
// Define Constants
///////////////////////////////////////////////////////////////////////////////////////////

define( 'THEMEROOT', get_stylesheet_directory_uri() );
define( 'IMAGES', THEMEROOT . '/images' );
define( 'SCRIPTS', THEMEROOT . '/js' );
define( 'FRAMEWORK', get_template_directory() . '/framework' );

///////////////////////////////////////////////////////////////////////////////////////////
// Load framework
///////////////////////////////////////////////////////////////////////////////////////////

require_once( FRAMEWORK . '/init.php' );

///////////////////////////////////////////////////////////////////////////////////////////
// Set Up Content Width Value
///////////////////////////////////////////////////////////////////////////////////////////

if ( ! isset( $content_width ) ) {
    $content_width = 1100;
}

require_once( FRAMEWORK . '/functions/content-helper-functions.php' );
require_once( FRAMEWORK . '/functions/cpt-functions.php' );
require_once( FRAMEWORK . '/functions/date-time-functions.php' );
require_once( FRAMEWORK . '/functions/post-functions.php' );
require_once( FRAMEWORK . '/functions/tax-functions.php' );

require_once( FRAMEWORK . '/security/elr-remove-wp-version.php' );

require_once( FRAMEWORK . '/custom-posts/elr-custom-post-type-archive-folders.php' );

require_once( FRAMEWORK . '/setup/elr-custom-theme-comment.php' );
require_once( FRAMEWORK . '/setup/elr-feed-links.php' );
require_once( FRAMEWORK . '/setup/elr-main-navigation.php' );
require_once( FRAMEWORK . '/setup/elr-page-navigation.php' );
require_once( FRAMEWORK . '/setup/elr-post-thumbnails.php' );
require_once( FRAMEWORK . '/setup/elr-read-more.php' );
require_once( FRAMEWORK . '/setup/elr-register-sidebars.php' );
require_once( FRAMEWORK . '/setup/elr-theme-languages.php' );