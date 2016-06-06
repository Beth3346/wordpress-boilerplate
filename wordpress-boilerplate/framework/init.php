<?php

require 'CptBuilder.php';
require 'CustomFields.php';
// require 'Utilities.php';
require 'ThemeOptions.php';
require 'custom-posts/CptService.php';
require 'Helpers/Admin.php';
require 'Helpers/Archive.php';
require 'Helpers/Comments.php';
require 'Helpers/ContentHelper.php';
require 'Helpers/Date.php';
require 'Helpers/File.php';
require 'Helpers/Loop.php';
require 'Helpers/Navigation.php';
require 'Helpers/PostHelper.php';
require 'Helpers/Query.php';
require 'Helpers/Security.php';
require 'Helpers/Setup.php';
require 'Helpers/Taxonomy.php';
require 'Helpers/Utility.php';

// spl_autoload_register(function ($class)
// {
//     $segments = array_filter(explode('\\', $class));
//     $path = __DIR__ . '/' . implode('/', $segments). '.php';

//     if (file_exists($path))
//     {
//         include $path;
//     }
// });

// use Framework\Utilities;
use Framework\Helpers\Admin;
use Framework\Helpers\File;
use Framework\Helpers\Setup;
use Framework\Helpers\Security;

// $framework = new Utilities;
$admin = new Admin;
$file = new File;
$setup = new Setup;
$security = new Security;
// $elr_fields = new ELR_Custom_Fields;

// Selects Custom Post Type Templates for single and archive pages
add_filter('template_include', [$file, 'customTemplateInclude']);
add_filter('the_generator', [$security, 'removeWpVersion']);

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
add_action('after_setup_theme', [$setup, 'themeSlugSetup']);

// Make theme available for translation
$lang_dir = THEMEROOT . '/languages';
load_theme_textdomain('elr', $lang_dir);

$setup->registerMenus(['main-nav', 'footer-nav', 'social-nav']);
$setup->registerSidebars(['sidebar']);

add_filter('manage_posts_columns', [$admin, 'thumbnailColumn'], 5);
add_action('manage_posts_custom_column', [$admin, 'thumbnailCustomColumn'], 5, 2);
add_action('dashboard_glance_items' , [$admin, 'dashboardCpts']);

add_filter('excerpt_more', [$setup, 'customMore']);

add_filter('excerpt_length', [$setup, 'customExcerptLength']);


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

// $settings_pages = [
//     [
//         'id' => 'social_options',
//         'title' => 'Social Options'
//     ],
//     [
//         'id' => 'general_options',
//         'title' => 'General Options'
//     ]
// ];

// $social_fields = [
//     [
//         'id' => 'facebook_url',
//         'default_value' => 'http://facebook.com',
//         'label' => 'Facebook URL',
//         'input_type' => 'url',
//         'instructions' => 'Provide your Facebook URL'
//     ],
//     [
//         'id' => 'phone_number'
//     ],
//     [
//         'id' => 'description',
//         'default_value' => 'stuff',
//         'input_type' => 'textarea'
//     ],
//     [
//         'id' => 'some_options',
//         'input_type' => 'select',
//         'options' => [
//             'marketing',
//             'service',
//             'technology'
//         ]
//     ]
// ];

// $general_fields = [
//     [
//         'id' => 'business_name'
//     ]
// ];

// function elr_add_theme_menu($settings_title, $settings_pages) {
//     $elr_options = new ELR_Options;
//     return $elr_options->add_theme_menu($settings_title, $settings_pages);
// }

// function elr_initialize_social_options($fields, $subpage_id, $subpage_title, $subpage_description) {
//     $elr_options = new ELR_Options;
//     return $elr_options->initialize_options($fields, $subpage_id, $subpage_title, $subpage_description);
// }

// function elr_initialize_general_options($fields, $subpage_id, $subpage_title, $subpage_description) {
//     $elr_options = new ELR_Options;
//     return $elr_options->initialize_options($fields, $subpage_id, $subpage_title, $subpage_description);
// }

// add_action('admin_menu', function() use ($settings_pages) {
//     elr_add_theme_menu('Theme Settings', $settings_pages);
// }, 12);

// add_action( 'admin_init', function() use ($social_fields) {
//     elr_initialize_social_options($social_fields, 'social_options', 'Social Options', 'Provide social information for your business');
// }, 12);

// add_action( 'admin_init', function() use ($general_fields) {
//     elr_initialize_general_options($general_fields, 'general_options', 'General Options', 'Provide general information for your business');
// }, 12);
