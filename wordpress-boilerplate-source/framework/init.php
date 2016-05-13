<?php

require 'classes/ELR-CPT-Builder.php';
require 'classes/ELR-Custom-Fields.php';
require 'classes/ELR-Framework.php';

$framework = new ELR_Framework;
// $elr_fields = new ELR_Custom_Fields;

// Selects Custom Post Type Templates for single and archive pages
add_filter('template_include', [$framework, 'custom_template_include']);
add_filter('the_generator', [$framework, 'remove_wp_version']);

function theme_queue_js(){
    if ((!is_admin()) && is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_print_scripts', 'theme_queue_js');

// Enable WordPress feature image
add_theme_support('post-thumbnails');

// RSS Support
add_theme_support('automatic-feed-links');

// Page Title Support for compatibility with SEO plugins
add_action('after_setup_theme', [$framework, 'theme_slug_setup']);

// Make theme available for translation
$lang_dir = THEMEROOT . '/languages';
load_theme_textdomain('elr', $lang_dir);

$framework->register_menus(['main-nav', 'footer-nav', 'social-nav']);
$framework->register_sidebars(['sidebar']);

add_filter('manage_posts_columns', [$framework, 'thumbnail_column'], 5);
add_action('manage_posts_custom_column', [$framework, 'thumbnail_custom_column'], 5, 2);
add_action('dashboard_glance_items' , [$framework, 'dashboard_cpts']);

add_filter('excerpt_more', [$framework, 'custom_more']);

add_filter('excerpt_length', [$framework, 'custom_excerpt_length']);


// $service_fields = [
//     [
//         'id' => '_service_name',
//         'label' => 'Service'
//     ],
//     [
//         'id' => '_service_type',
//         'label' => 'Type',
//         'type' => 'textarea'
//     ],
//     [
//         'id' => '_service_area',
//         'label' => 'Area',
//         'type' => 'select',
//         'options' => [
//             'marketing',
//             'service',
//             'technology'
//         ]
//     ]
// ];

// function elr_register_service_fields($service_fields) {
//     $elr_fields = new ELR_Custom_Fields;
//     return $elr_fields->meta_fields_register($service_fields);
// }

// function elr_save_service_fields($service_fields) {
//     global $post;
//     $elr_fields = new ELR_Custom_Fields;

//     if ($post) {
//         return $elr_fields->meta_box_save($post->ID, $service_fields);
//     } else {
//         return;
//     }
// }

// function elr_add_meta_service_box($service_fields) {
//     $elr_fields = new ELR_Custom_Fields;
//     return $elr_fields->meta_box_add('service_box', 'Services', 'page', $service_fields);
// }

// add_action('init', function() use ($service_fields) { elr_register_service_fields($service_fields); }, 12);
// add_action('save_post', function() use ($service_fields) { elr_save_service_fields($service_fields); }, 12);
// add_action('add_meta_boxes', function() use ($service_fields) { elr_add_meta_service_box($service_fields); }, 12);

$settings_pages = [
    [
        'id' => 'social_options',
        'title' => 'Social Options'
    ]
];

$settings_fields = [
    [
        'id' => 'facebook_url',
        'default_value' => 'http://facebook.com',
        'label' => 'Facebook URL',
        'input_type' => 'url',
        'instructions' => 'Provide your Facebook URL'
    ],
    [
        'id' => 'phone_number'
    ],
    [
        'id' => 'description',
        'default_value' => 'stuff',
        'input_type' => 'textarea'
    ],
    [
        'id' => 'some_options',
        'input_type' => 'select',
        'options' => [
            'marketing',
            'service',
            'technology'
        ]
    ]
];

function elr_add_theme_menu($settings_title, $settings_pages) {
    $elr_options = new ELR_Options;
    return $elr_options->add_theme_menu($settings_title, $settings_pages);
}

function elr_initialize_social_options($fields, $subpage_id, $subpage_title, $subpage_description) {
    $elr_options = new ELR_Options;
    return $elr_options->initialize_options($fields, $subpage_id, $subpage_title, $subpage_description);
}

add_action('admin_menu', function() use ($settings_pages) {
    elr_add_theme_menu('Theme Settings', $settings_pages);
}, 12);

add_action( 'admin_init', function() use ($settings_fields) {
    elr_initialize_social_options($settings_fields, 'social_options', 'Social Options', 'Provide social information for your business');
}, 12);
