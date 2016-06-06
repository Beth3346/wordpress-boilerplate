<?php

namespace Framework\Helpers;

class Setup
{
    public function themeSlugSetup()
    {
        add_theme_support('title-tag');
    }

    public function registerMenus(array $menus)
    {
        foreach ($menus as $menu) {
            $name = $menu;
            $title = str_replace('-', ' ', ucwords($menu));

            register_nav_menus([
                $name => __($title, 'elr')
            ]);
        }
    }

    public function customExcerptLength($text, $custom_length = 50)
    {
        return $custom_length;
    }

    // make read more link to post
    // add a data-post attribute to make it easy for script to find and use
    public function customMore($more, $read_more = 'Read More')
    {
        global $post;

        return '...<p><a href="'. get_permalink(get_the_ID()) . '" class="learn-more-link">' . $read_more . '</a></p>';
    }

    public function registerSidebars(array $sidebars, $title_tag = 'h3')
    {
        foreach ($sidebars as $sidebar) {
            $name = $sidebar;
            $title = str_replace('-', ' ', ucwords($sidebar));
            $args = [
                'name' => $title,
                'id' => $name,
                'before_widget' => '<section id="'. $name .'" class="widget sidebar-widget ' . $name . '">',
                'after_widget' => '</section>',
                'before_title' => '<' . $title_tag . ' class="widget-title">',
                'after_title' => '</' . $title_tag . '>',
            ];

            register_sidebar($args);
        }
    }
}