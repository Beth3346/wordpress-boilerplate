<?php

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level
 * 'Theme Settings' menu.
 */
if ( ! function_exists( 'elr_theme_menu' ) ) {
    function elr_theme_menu() {

            add_theme_page(
                'Theme Settings',                                  // The title to be displayed in the browser window for this page.
                'Theme Settings',                                        // The text to be displayed for this menu item
                'administrator',                                        // Which type of users can see this menu item
                'elr_theme_options',                        // The unique ID - that is, the slug - for this menu item
                'elr_theme_display'                         // The name of the function to call when rendering this menu's page
            );

            add_menu_page(
                'Theme Settings',            // The value used to populate the browser's title bar when the menu page is active
                'Theme Settings',                                        // The text of the menu in the administrator's sidebar
                'administrator',                                        // What roles are able to access the menu
                'elr_theme_menu',                                // The ID used to bind submenu items to this menu
                'elr_theme_display'                                // The callback function used to render this menu
            );

            add_submenu_page(
                'elr_theme_menu',
                __( 'Social Options', 'elr' ),
                __( 'Social Options', 'elr' ),
                'administrator',
                'elr_theme_social_options',
                create_function( null, 'elr_theme_display( "social_options" );' )
            );


    } // end elr_theme_menu
}
add_action( 'admin_menu', 'elr_theme_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */

if ( ! function_exists( 'elr_theme_display' ) ) {
    function elr_theme_display( $active_tab = '' ) {
    ?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">

            <div id="icon-themes" class="icon32"></div>
            <h2><?php _e( 'Eye Center of  Texas Theme Settings Options', 'elr' ); ?></h2>
            <?php settings_errors(); ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=elr_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'elr' ); ?></a>
            </h2>

            <form method="post" action="options.php">
            <?php
                settings_fields( 'elr_theme_social_options' );
                do_settings_sections( 'elr_theme_social_options' );
                submit_button();
            ?>
            </form>

        </div><!-- /.wrap -->
    <?php
    } // end elr_theme_display
}

require_once( FRAMEWORK . '/theme-options/elr-theme-social-options.php' );