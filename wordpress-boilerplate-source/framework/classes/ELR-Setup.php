<?php

class ELR_Setup {
    public function theme_slug_setup() {
        add_theme_support( 'title-tag' );
    }

    public function register_menus(array $menus) {
        foreach ($menus as $menu) {
            $name = $menu;
            $title = str_replace('-', ' ', ucwords($menu));

            register_nav_menus( array(
                $name => __($title, 'elr'),
            ) );
        }
    }

    public function custom_excerpt_length($text, $custom_length = 50) {
        return $custom_length;
    }

    // make read more link to post
    // add a data-post attribute to make it easy for script to find and use
    public function custom_more($more, $read_more = 'Read More') {
        global $post;

        return '...<p><a href="'. get_permalink( get_the_ID() ) . '" class="learn-more-link">' . $read_more . '</a></p>';
    }

    public function register_sidebars(array $sidebars) {
        foreach ($sidebars as $sidebar) {
            $name = $sidebar;
            $title = str_replace('-', ' ', ucwords($sidebar));
            $args = [
                'name' => $title,
                'id' => $name,
                'before_widget' => '<section id="'. $name .'" class="widget sidebar-widget ' . $name . '">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ];

            register_sidebar($args);
        }
    }
}