<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta name="robots" content="index, follow" />
    <!-- saved from url=(0014)about:internet-->

<?php

    //register styles and scripts

    function elr_register_stuff() {
        wp_register_script( 'respond', '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js', array(), null );
        wp_register_script( 'main', SCRIPTS . '/wordpress-boilerplate.1.0.0.js', array( 'jquery' ), null, true );
        wp_register_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), null );
        wp_register_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), null, 'screen' );
        wp_register_style( 'style', get_template_directory_uri() . '/style.css', array(), null, 'screen' );
        wp_register_style( 'lato', 'https://fonts.googleapis.com/css?family=Lato:400,300,700,900', array(), null, 'screen' );
        // register any google fonts
    }

    add_action( 'wp_enqueue_scripts', 'elr_register_stuff' );

    function elr_enqueue_stuff() {
        wp_enqueue_script( 'respond' );
        wp_enqueue_script( 'modernizr' );
        wp_enqueue_script( 'main' );
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style( 'lato' );
        wp_enqueue_style( 'style' );
    }

    add_action( 'wp_enqueue_scripts', 'elr_enqueue_stuff' );
?>

<!-- wp_header -->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="wrapper">
    <header class="main-header elr-container-full" role="banner">
        <div class="elr-row">
            <div class="elr-col-third">
                <!-- add logo background image images/logo.png -->
                <p class="site-name"><a href="<?php bloginfo( 'url' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            </div>
            <div class="navigation-holder elr-col-two-thirds">
                <nav class="main-nav" role="navigation">
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'main-nav',
                            'fallback_cb' => 'default_main_nav',
                            'container'  => 'main-nav-wrapper',
                            'menu_id' => 'main-menu',
                            'menu_class' => 'main-menu elr-inline-list'
                        )
                    ); ?>
                </nav>
            </div>
        </div>
    </header>