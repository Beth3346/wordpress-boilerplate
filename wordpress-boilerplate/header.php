<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta name="robots" content="index, follow" />
    <!-- saved from url=(0014)about:internet-->

<?php

    //register styles and scripts

    function elr_register_stuff()
    {
        wp_register_script('respond', '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js', [], null);
        wp_register_script('main', SCRIPTS . '/main.2.0.0.min.js', ['jquery'], null, true);
        wp_register_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', [], null);
        wp_register_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', [], null, 'screen');
        wp_register_style('style', get_template_directory_uri() . '/style.css', [], null, 'screen');
        wp_register_style('lato', 'https://fonts.googleapis.com/css?family=Lato:400,300,700,900', [], null, 'screen');
        // register any google fonts
    }

    add_action('wp_enqueue_scripts', 'elr_register_stuff');

    function elr_enqueue_stuff()
    {
        wp_enqueue_script('respond');
        wp_enqueue_script('modernizr');
        wp_enqueue_script('main');
        wp_enqueue_style('font-awesome');
        wp_enqueue_style('lato');
        wp_enqueue_style('style');
    }

    add_action('wp_enqueue_scripts', 'elr_enqueue_stuff');
?>

<!-- wp_header -->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php get_template_part('partials/header'); ?>