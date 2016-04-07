<?php

class ELR_Tax {
    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function get_current_tax( $query ) {

        if ( is_tax() ) {

            $tax_term = $query->queried_object;
            return $tax_term->name;

        } else {

            return null;
        }
    }

    /**
     * Echos comma separated taxonomy term links
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function taxonomy_terms( $taxonomy, $id ) {
        $terms = get_the_terms( $id, $taxonomy );
        $last_key = array_search( end( $terms ), $terms );

        foreach ( $terms as $key => $value ) {
            $term_link = get_term_link( $value );

            echo '<a href="';
            echo $term_link;
            echo '">';
            echo $value->name;

            if ( $key === $last_key ) {
                echo '</a> ';
            } else {
                echo '</a>, ';
            }
        }
    }

    public function get_related_terms($taxonomy, $type, $terms, $term_tax) {
        $rel_terms = [];
        $query = new WP_Query(
            [
                'post_type' => $type,
                'posts_per_page' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => $term_tax,
                        'terms'    => $terms,
                        'field'    => 'slug',
                   ],
               ],
           ]
       );

        $items = $query->get_posts();

        foreach($items as $item) {
            $term = wp_get_post_terms($item->ID, $taxonomy);
            array_push($rel_terms, $term[0]->name);
        }

        return array_unique($rel_terms);
    }

    public function get_term_names($terms) {
        $term_names = [];

        // create an array of term names
        foreach ($terms as $term) {
            array_push($term_names, $term->name);
        }

        return $term_names;
    }

    public function is_parent_term( $term ) {
        if ( $term->parent == 0 ) {
            return true;
        } else {
            return false;
        }
    }

    public function get_parents($taxonomy) {
        $terms = get_terms($taxonomy, 'orderby=count&hide_empty=1&hierarchical=1');
        $parents = [];
        foreach ($terms as $term) {
            if (elr_is_parent_term($term)) {
                array_push($parents, $term);
            }
        }

        return $parents;
    }

    public function term_has_posts($id, $taxonomy) {
        $args = array(
            'status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $id
                )
            )
        );
        $term_query =  new WP_Query($args);
        $term_posts_count = $term_query->found_posts;
        if( $term_posts_count > 0 ){
            return true;
        } else {
            return false;
        }
    }

    public function get_children($term, $taxonomy) {
        if( $this->is_parent_term( $term ) ) {
            $terms = [];
            $ids = get_term_children( $term->term_id, $taxonomy );

            foreach ($ids as $id) {
                if ($this->term_has_posts($id, $taxonomy)) {
                    array_push($terms, get_term($id));
                }
            }
        } else {
            $terms = null;
        }

        return $terms;
    }

    public function tax_nav($query, $post_type, $taxonomy, $type, $term_tax, $current_term = null) {
        $elr_query = new ELR_Post_Query;
        $elr_helpers = new ELR_Helpers;

        $tax_args = array(
            'orderby'           => 'name',
            'order'             => 'ASC',
            'hide_empty'        => true
       );

        $tax_name = ucwords(str_replace('_' , ' ', $taxonomy));
        $terms = get_terms(array($taxonomy), $tax_args);
        $term_names = $this->get_term_names($terms);
        $rel_terms = $elr_query->get_related_terms($taxonomy, $post_type, $type, $term_tax);

        if ($terms) {
            echo '<nav class="taxonomy-nav">';
            echo '<ul class="taxonomy-menu taxonomy-' . $taxonomy . '">';

            // list all terms
            foreach ($terms as $term) {
                if (in_array($term->name, $rel_terms, TRUE)) {
                    $term_link = get_term_link($term);

                    if ($term->name === $current_term && $taxonomy == 'color') {
                        $class = 'active color-swatch';
                    } else if ($term->name === $current_term) {
                        $class = 'active';
                    } else if ($taxonomy == 'color') {
                        $class = 'color-swatch inactive';
                    } else {
                        $class = 'inactive';
                    }

                    echo '<li class="';
                    echo $elr_helpers->slugify($taxonomy) . '-' . $elr_helpers->slugify($term->name);
                    echo '">';
                        echo '<a href="';
                        echo esc_url($term_link) . '"';
                            echo 'class="' . $class . '"';
                            echo 'data-term="' . $term->slug . '"';
                        echo '>';
                        echo(ucwords($term->name));
                        echo '</a>';
                    echo '</li>';
                }
            }

            echo '</ul></nav>';
        }
    }

    public function tax_dropdown($post_type, $taxonomy, $current_term = null) {

        $tax_args = array(
            'orderby'           => 'name',
            'order'             => 'ASC',
            'hide_empty'        => true
        );

        $tax_name = ucwords(str_replace('_' , ' ', $taxonomy));
        $terms = get_terms(array($taxonomy), $tax_args);
        $term_names = $this->get_term_names($terms);

        if ($terms) {
            echo '<select class="taxonomy-dropdown">';
            echo '<option value="" selected>Select ' . ucwords($taxonomy) . '</option>';

                // list all terms
                foreach ($terms as $term) {
                    $term_link = get_term_link($term);
                    echo '<option ';
                        echo 'value="';
                        echo esc_url($term_link);
                        echo '">';
                        echo(ucwords($term->name));
                    echo '</option>';
                }
            echo '</select>';
        }
    }

    public function tax_nav_filter($query, $post_type, $taxonomy, $type, $term_tax, $current_term = null) {
        $elr_helpers = new ELR_Helpers;

        $tax_args = array(
            'orderby'           => 'name',
            'order'             => 'ASC',
            'hide_empty'        => true
       );

        $tax_name = ucwords(str_replace('_' , ' ', $taxonomy));
        $terms = get_terms(array($taxonomy), $tax_args);
        $term_names = $this->get_term_names($terms);
        $rel_terms = $this->get_related_terms($taxonomy, $post_type, $type, $term_tax);

        if ($terms) {
            echo '<nav class="taxonomy-nav taxonomy-filter">';
            echo '<ul class="taxonomy-menu taxonomy-' . $taxonomy . '" data-tax="' . $taxonomy . '" data-type="' . $type . '">';

                if ($current_term && in_array($term_names, $current_term)) {
                    echo '<li class="filter-all"><a href="/' . $post_type . '/" data-term="all">All</a></li>';
                } else {
                    echo '<li class="filter-all"><a href="/' . $post_type . '/" class="active" data-term="all">All</a></li>';
                }

                // list all terms
                foreach ($terms as $term) {
                    if (in_array($term->name, $rel_terms, TRUE)) {
                        $term_link = get_term_link($term);

                        if ($term->name === $current_term && $taxonomy == 'color') {
                            $class = 'active color-swatch';
                        } else if ($term->name === $current_term) {
                            $class = 'active';
                        } else if ($taxonomy == 'color') {
                            $class = 'color-swatch inactive';
                        } else {
                            $class = 'inactive';
                        }

                        echo '<li class="';
                        echo $elr_helpers->slugify($taxonomy) . '-' . $elr_helpers->slugify($term->name);
                        echo '">';
                            echo '<a href="';
                            echo esc_url($term_link) . '"';
                                echo 'class="' . $class . '"';
                                echo 'data-term="' . $term->slug . '"';
                            echo '>';
                            echo(ucwords($term->name));
                            echo '</a>';
                        echo '</li>';
                    }
                }
            echo '</ul></nav>';
        }
    }

    public function tax_dropdown_filter($post_type, $taxonomy, $current_term = null) {

        $tax_args = array(
            'orderby'           => 'name',
            'order'             => 'ASC',
            'hide_empty'        => true
        );

        $tax_name = ucwords(str_replace('_' , ' ', $taxonomy));
        $terms = get_terms(array($taxonomy), $tax_args);
        $term_names = $this->get_term_names($terms);
        $active_class = ($taxonomy == 'color') ? 'active color-swatch' : 'active';

        if ($terms) {
            echo '<select class="taxonomy-dropdown taxonomy-dropdown-filter" data-tax="' . $taxonomy . '">';
            echo '<option value="all" selected>Select ' . ucwords($taxonomy) . '</option>';
            echo '<option value="all">All</option>';

                // list all terms
                foreach ($terms as $term) {
                    $term_link = get_term_link($term);
                    echo '<option ';
                        echo 'value="';
                        echo $term->slug;
                        echo '">';
                        echo(ucwords($term->name));
                    echo '</option>';
                }
            echo '</select>';
        }
    }
}