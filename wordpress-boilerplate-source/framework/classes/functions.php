<?php

function elr_product_options($post_type, $taxonomy, $post_id) {

    $tax_args = array(
        'orderby'           => 'name',
        'order'             => 'ASC',
        'hide_empty'        => true
   );

    $tax_name = ucwords(str_replace('_' , ' ', $taxonomy));
    $terms = get_terms(array($taxonomy), $tax_args);
    $style = wp_get_post_terms($post_id, 'style');
    $style = $style[0];
    $active_class = ($taxonomy == 'color') ? 'active color-swatch' : 'active';
    $rel_terms = elr_get_related_terms($taxonomy, 'product', $style, 'style');

    // if term is in style group add class active

    if ($terms) {
        echo '<nav class="taxonomy-nav">';
        echo '<ul class="taxonomy-menu taxonomy-' . $taxonomy . '">';

            // list all terms
            foreach ($terms as $term) {
                $term_link = get_term_link($term);
                echo '<li class="';
                echo elr_slugify($taxonomy) . '-' . elr_slugify($term->name);
                echo '">';
                    // if term is in the rel_terms array add an active class
                    if (in_array($term->name, $rel_terms, TRUE)) {
                        echo '<span ';
                        // echo '<a href="';
                        // echo esc_url($term_link) . '"';
                        echo 'class="' . $active_class . '"';
                        echo '>';
                        echo(ucwords($term->name));
                        // echo '</a>';
                        echo '</span>';
                    } else {
                        if ($taxonomy == 'color') {
                            echo '<span class="color-swatch inactive">';
                            echo(ucwords($term->name));
                            echo '</span>';
                        } else {
                            echo(ucwords($term->name));
                        }
                    }
                echo '</li>';
            }
        echo '</ul></nav>';
    }
}

function get_products($tax, $term, $num = 5) {
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $num,
        'tax_query' => [
            [
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => $term
            ]
        ]
    ];

    $query = new WP_Query($args);

    return $query;
}

function get_product_terms($tax, $type) {
    $products = get_products('type', $type, -1);
    $terms = [];

    if ($products->have_posts()) {
        while ($products->have_posts()) : $products->the_post();
            global $post;
            $term = get_the_terms($post->ID, $tax);
            $name = $term[0]->name;
            array_push($terms, $name);
        endwhile;
        wp_reset_postdata();

        return array_unique($terms);
    } else {
        return;
    }
}

function get_first_product($tax, $term) {
    return get_products($tax, $term, 1);
}

function get_term_children_num($tax, $term) {
    $products = get_products($tax, $term, -1);

    return $products->post_count;
}