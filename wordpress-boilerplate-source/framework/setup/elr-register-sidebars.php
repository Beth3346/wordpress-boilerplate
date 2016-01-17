<?php

///////////////////////////////////////
// Register Widgets
///////////////////////////////////////

if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar',
        'before_widget' => '<section id="%1$s" class="widget sidebar-widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}