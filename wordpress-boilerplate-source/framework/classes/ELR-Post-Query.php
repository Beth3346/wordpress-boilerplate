<?php

class ELR_Post_Query {
    public function post_query($post_type = 'post', $num = 3, $sort = 'date') {
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $num,
            'post_status' => 'publish',
            'orderby' => $sort
       );
        $query = new WP_Query($args);

        return $query;
    }

    public function get_posts($post_type = 'post', $num = 3, $sort = 'date', $thumb = true, $excerpt_length = 40, $container = 'elr-col-third') {
        $query = $this->post_query($post_type, $num, $sort);
        if ($query->have_posts()) {
            $content = '';
            while ($query->have_posts()) : $query->the_post();
                global $post;
                $content .= '<div class="';
                $content .= $container;
                $content .= '">';
                $content .= '<div class="post-box post-box-';
                $content .= strtolower(str_replace(' ', '-', $post_type));
                $content .= '">';

                if ($thumb) {
                    $content .= '<figure class="post-box-image"><a href="';
                    $content .= get_the_permalink();
                    $content .= '">';
                    $content .= get_the_post_thumbnail();
                    $content .= '</a></figure>';
                }

                $content .= '<h2 class="post-box-title"><a href="';
                $content .= get_the_permalink();
                $content .= '">';
                $content .= get_the_title();
                $content .= '</a></h2><p class="post-box-excerpt">';
                $content .= esc_html(elr_trim_content($excerpt_length));
                $content .= '</p><a href="';
                $content .= get_the_permalink();
                $content .= '" class="post-box-learn-more">Read More</a></div></div>';
            endwhile;
            wp_reset_postdata();
            return $content;
        } else {
            return null;
        }
    }

    public function get_related_posts($taxonomy = 'category', $post_type = 'current', $num_posts = 3) {
        $id = get_the_ID();

        // config
        if ($taxonomy === 'category') {
            $term_name = $taxonomy;
            $term_id = 'cat_ID';
        } else if ($taxonomy === 'tag') {
            $term_name = 'post_tag';
            $term_id = 'term_id';
        } else {
            $term_name = $taxonomy;
            $term_id = 'term_id';
        }

        if ($post_type == 'current') {
            $post_type = get_post_type();
        }

        $terms = get_the_terms($id, $term_name);
        $related = [];

        // TODO: need to check if term exists
        if (!empty($terms)) {
            foreach($terms as $term) {
                $related[] = $term->$term_id;
            }
        } else {
            return;
        }

        if ($taxonomy == 'category') {
            $loop = new WP_Query(
                array(
                    'posts_per_page' => $num_posts,
                    'category__in' => $related,
                    'post__not_in' => array($id),
                    'post_type' => $post_type
               )
           );
        } else if ($taxonomy == 'tag') {
            $loop = new WP_Query(
                array(
                    'posts_per_page' => $num_posts,
                    'tag__in' => $related,
                    'post__not_in' => array($id),
                    'post_type' => $post_type
               )
           );
        } else {
            $loop = new WP_Query(
                array(
                    'post_type' => $post_type,
                    'post__not_in' => array($id),
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'terms'    => $related,
                            'field'    => 'term_id',
                       ),
                   ),
               )
           );
        }

        return $loop;
    }

    public function related_posts($taxonomy = 'category', $post_type = 'current', $num_posts = 3) {
        $loop = $this->get_related_posts($taxonomy, $post_type, $num_posts);

        if ($loop->have_posts()) {
            $related_posts = '<ul class="related-category-posts">';
            while($loop->have_posts()) {
                $loop->the_post();
                $related_posts .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            $related_posts .= '</ul>';
            wp_reset_query();
        }

        return $related_posts;
    }

    public function related_posts_images($taxonomy = 'category', $post_type = 'current', $num_posts = 3) {
        $loop = $this->get_related_posts($taxonomy, $post_type, $num_posts);

        if ($loop->have_posts()) {
            $related_posts = '<ul class="related-category-posts elr-unstyled-list elr-inline-list">';
            while($loop->have_posts()) {
                $loop->the_post();
                if (has_post_thumbnail()) {
                    $related_posts .= '<li><a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a></li>';
                } else {
                    $related_posts .= '<li><a href="' . get_permalink() . '"><img src="' . IMAGES . '/design-ring.jpg" alt="Ring"></a></li>';
                }
            }
            $related_posts .= '</ul>';
            wp_reset_query();

            return $related_posts;
        } else {
            return;
        }
    }
}