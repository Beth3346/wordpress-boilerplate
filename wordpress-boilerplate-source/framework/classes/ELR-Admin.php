<?php

class ELR_Admin {
    public function admin_column($column_name, $title) {
        $defaults[$column_name] = __($title);

        return $defaults;
    }

    public function meta_custom_column($column_name, $meta_field, $id) {
        if ($column_name === $column_name) {
            $column_name = get_post_meta($id, $meta_field, true);
            echo $column_name;
        }
    }

    public function thumbnail_column($defaults) {
        $defaults['elr_post_thumbs'] = __('Thumbs');

        return $defaults;
    }

    public function thumbnail_custom_column($column_name, $id) {
        if ($column_name === 'elr_post_thumbs') {
            echo the_post_thumbnail(array(100, 100));
        }
    }

    // Add custom post types to right now dashboard
    public function dashboard_cpts() {

        $args = array(
            'public' => true ,
            '_builtin' => false
       );

        $output = 'object';
        $operator = 'and';
        $post_types = get_post_types($args , $output , $operator);

        foreach($post_types as $post_type) {
            $num_posts = wp_count_posts($post_type->name);
            $num = number_format_i18n($num_posts->publish);
            $text = _n($post_type->labels->singular_name, $post_type->labels->name , intval($num_posts->publish));

            if (current_user_can('edit_posts')) {
                $num = "<a href='edit.php?post_type=$post_type->name'>$num";
                $text = "$text</a>";
            }

            echo '<li class="post-count">' . $num . ' ' . $text . '</li>';
        }
    }

    public function dashboard_taxonomies() {
        $taxonomies = get_taxonomies($args , $output , $operator);

        foreach($taxonomies as $taxonomy) {
            $num_terms  = wp_count_terms($taxonomy->name);
            $num = number_format_i18n($num_terms);
            $text = _n($taxonomy->labels->singular_name, $taxonomy->labels->name , intval($num_terms));

            if (current_user_can('manage_categories')) {
                $num = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num";
                $text = "$text</a>";
            }

            echo '<li class="post-count">' . $num . ' ' . $text . '</li>';
        }
    }
}