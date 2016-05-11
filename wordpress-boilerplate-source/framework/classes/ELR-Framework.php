<?php

class ELR_Framework {
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

    public function author_archive_title() {
        the_post();
        printf( __( 'All posts by %s', 'elr' ), get_the_author() );
    }

    public function author_archive_description() {
        if ( get_the_author_meta( 'description' ) ) {
            echo '<div class="author-description">';
            echo get_the_author_meta( 'description' );
            echo '</div>';
        }
    }

    public function category_archive_title() {
        printf( __( 'Category: %s', 'elr' ), single_cat_title( '', false ) );
    }

    public function category_archive_description() {
        $term_description = term_description();
        if ( ! empty( $term_description ) ) :
            printf( '<div class="taxonomy-description">%s</div>', $term_description );
        endif;
    }

    public function search_archive_title() {
        printf( __( 'Search Results for: %s', 'elr' ), '<span>' . get_search_query() . '</span>' );
    }

    public function tag_archive_title() {
        printf( __( 'Tag: %s', 'elr' ), single_tag_title( '', false ) );
    }

    public function tag_archive_description() {
        // Show an optional term description.
        $term_description = term_description();
        if ( ! empty( $term_description ) ) :
            printf( '<div class="taxonomy-description">%s</div>', $term_description );
        endif;
    }

    public function custom_theme_comment($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
       ?>

        <li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
        <section>
            <p class="comment-author">
                <?php echo get_avatar($comment,$size='48'); ?> <?php printf('<cite>%s</cite>', get_comment_author_link()) ?><br />
                <small class="comment-time"><strong>
                <?php comment_date('M d, Y'); ?>
                </strong> @
                <?php comment_time('H:i:s'); ?>
                <?php edit_comment_link( __('Edit', 'elr'),' [',']') ?>
                </small>
            </p>
            <div class="commententry">
                <?php if ($comment->comment_approved == '0') : ?>
                <p>
                    <em><?php _e('Your comment is awaiting moderation.', 'elr') ?></em>
                </p>
                <?php endif; ?>
                <?php comment_text() ?>
            </div>
            <p class="reply">
                <?php comment_reply_link(
                    array_merge(
                        $args, array(
                            'add_below' => 'comment',
                            'depth' => $depth,
                            'reply_text' => __( 'Reply', 'elr' ),
                            'max_depth' => $args['max_depth']
                        )
                    )
                ) ?>
            </p>
        </section>

    <?php }

    public function trim_title( $title_length = 75 ) {
        $title = get_the_title();

        if ( strlen( $title ) > $title_length ) {

            return substr( $this->remove_quotes( $title ), 0, $title_length ) . '...';

        } else {

            return substr( $this->remove_quotes( $title ), 0, $title_length );
        }

    }

    public function trim_content( $content_length = 200 ) {
        $content = get_the_content();

        if ( strlen( $content ) > $content_length ) {

            return wp_trim_words( $this->remove_quotes( $content ), $content_length, "..." );

        } else {

            return $this->remove_quotes( $content );

        }
    }

    public function remove_quotes( $content ) {
        return str_ireplace( '"', '', $content );
    }

    public function video( $video, $width = 560, $height = 349 ) {

        if ( $video ) {
            echo '<div class="video-holder">';
            echo '<iframe src="//';
            echo esc_attr( $video );
            echo '" width=';
            echo $width;
            echo "' height='";
            echo $height;
            echo "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen>";
            echo '</iframe>';
            echo '</div>';
        }
    }

    public function address( $address ) {
        if ( array_filter( $address ) ) {
            echo '<ul class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';

            if ( array_key_exists( 'street_address', $address ) ) {
                if ( $address['street_address'] ) {
                    echo '<li itemprop="streetAddress">';
                    echo esc_html( $address['street_address'] );
                    echo '</li>';
                }
            }

            echo '<li>';

            if ( array_key_exists( 'city', $address ) ) {
                if ( $address['city'] ) {
                    echo '<span itemprop="addressLocality">';
                    echo esc_html( $address['city'] );
                    echo ', </span>';
                }
            }

            if ( array_key_exists( 'state', $address ) ) {
                if ( $address['state'] ) {
                    echo '<span itemprop="addressRegion">';
                    echo esc_html( $address['state'] );
                    echo ', </span>';
                }
            }

            if ( array_key_exists( 'zip_code', $address ) ) {
                if ( $address['zip_code'] ) {
                    echo '<span itemprop="postalCode">';
                    echo esc_html( $address['zip_code'] );
                    echo ', </span>';
                }
            }

            if ( array_key_exists( 'country', $address ) ) {
                if ( $address['country'] ) {
                    echo '<span itemprop="country">';
                    echo esc_html( $address['country'] );
                    echo '</span><br>';
                }
            }

            echo '</li>';
            echo '</ul>';
        }
    }

    public function email( $email ) {

        if ( $email ) {
            echo '<a href="mailto:';
            echo antispambot( $email );
            echo '">';
            echo antispambot( $email );
            echo '</a>';
        }
    }

    public function breadcrumbs() {
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">','</p>');
        }
    }

    /**
     * Test to see if the page is a date based archive page cpt archive
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return boolean
     */

    public function is_cpt_archive() {
        if (is_category() || is_author() || is_tag() || is_date() || is_front_page() || is_home()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Test to find out if post type is cpt
     *
     * @since  3.0.0
     * @access public
     * @param  string $post post to test optional
     * @return void
     */

    public function is_custom_post_type($post = NULL) {
        $all_custom_post_types = get_post_types(array ('_builtin' => FALSE));

        // there are no custom post types
        if (empty ($all_custom_post_types)) {
            return FALSE;
        }

        $custom_types = array_keys($all_custom_post_types);
        $current_post_type = get_post_type($post);

        // could not detect current type
        if (! $current_post_type) {
            return FALSE;
        }

        return in_array($current_post_type, $custom_types);
    }

    /**
     * Updates the number of posts that display on each archive page
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function number_of_cpts($query, $num = -1, $post_types = [], $taxonomies = []) {

        if ($query->is_main_query()) {

            foreach ($post_types as $post_type) {
                if (is_post_type_archive($post_type, $num)) {
                    $query->set('posts_per_page', $num);
                }
            }

            foreach ($taxonomies as $tax) {
                if (is_tax($tax)) {
                    $query->set('posts_per_page', $num);
                }
            }

            return $query;
        }
    }

    public function cpt_loop() {

        if (have_posts()) {

            while (have_posts()) : the_post();

                get_template_part('content/content', get_post_type());

            endwhile;

            get_template_part('partials/pagination');

        } else {

            get_template_part('content/content', 'none');
        }
    }

    public function get_post_count($post_type = 'post') {
        $posts = wp_count_posts($post_type);
        return $posts->publish;
    }

    public function cpt_filters($taxonomies, $post_archive, $tax_term) {
        foreach ($taxonomies as $tax) {
            $this->tax_nav_filter($post_archive, $tax, $tax_term);
        }
    }

    public function cpt_limit_filters($post_archive) {
        echo '<nav class="num-results-nav">';
        echo '<ul class="elr-inline-list num-results-menu">';
        echo '<li><a class="active" href="/' . $post_archive . '/" data-num="5">5</a></li>';
        echo '<li><a href="/' . $post_archive . '/" data-num="10">10</a></li>';
        echo '<li><a href="/' . $post_archive . '/" data-num="-1">All</a></li>';
        echo '</ul>';
        echo '</nav>';
    }

    public function post_count($query, $num_posts) {
        echo '<p class="post-count">Showing '. $query->post_count . ' of ' . $num_posts . '</p>';
    }

    public function cpt_grid($query, $post_type = 'post', $taxonomies = [], $show_count = false, $show_limit = false) {
        $tax_term = $this->get_current_tax($query);

        // make sure post type actually exists
        if (post_type_exists($post_type)) {
            $num_posts = $this->get_post_count($post_type);
            $post_archive = strtolower(get_post_type_object($post_type)->labels->name);

            // if project archive or project custom taxonomy show grid
            if ($this->is_cpt_archive() || is_tax()) {
                echo '<div class="cpt-grid elr-row">';
                if ($show_limit || !empty($taxonomies)) {
                    echo '<div class="cpt-grid-nav elr-col-full">';

                    if ($show_limit) {
                        echo '<h3 class="filter-heading">Limit Results:</h3>';
                        $this->cpt_limit_filters($post_archive);
                    }

                    if (!empty($taxonomies)) {
                        echo '<h3 class="filter-heading">Filter Results:</h3>';
                        $this->cpt_filters($taxonomies, $post_archive, $tax_term);
                    }
                    echo '</div>';
                }

                echo '<div class="cpt-grid-content elr-row" data-post-type="' . $post_type . '">';
                elr_loop();

                if ($show_count) {
                    $this->post_count($query, $num_posts);
                }

                echo '</div>';
                echo '</div>';
            } else {
                // if category/tag/author/date archive show normal loop
                elr_normal_loop();
            }
        } else {
            $num_posts = 0;
            echo '<p>This post type does not exist</p>';
        }
    }

    /**
     * Check if a post is a custom post type.
     * @param  mixed $post Post object or ID
     * @return boolean
     */

    public function custom_template_include($template) {
        $custom_template_location = '/archives/';
        $cpt_tmp = NULL;
        if ($this->is_cpt_archive()) {

            if (is_archive() && !is_tax()) {
                $cpt_tmp = get_stylesheet_directory() . $custom_template_location . 'archive-' . get_post_type() . '.php';
            } else if (is_single()) {
                $cpt_tmp = get_stylesheet_directory() . $custom_template_location . 'single-' . get_post_type() . '.php';
            }

            if (file_exists($cpt_tmp)) {
                return $cpt_tmp;
            }
        }
        return $template;
    }

    public function filter_taxonomy_scripts() {
        wp_localize_script( 'main', 'elr_vars', array(
                'elr_nonce' => wp_create_nonce( 'elr_nonce' ),
                'elr_ajax_url' => admin_url( 'admin-ajax.php' ),
                'elr_current_term' => strtolower( single_term_title( '', false ) ),
                'elr_current_tax' => 'type'
            )
        );
    }

    // Script for getting posts
    public function filter_taxonomy( $taxonomy ) {

        // Verify nonce
        if ( !isset( $_POST['elr_nonce'] ) || !wp_verify_nonce( $_POST['elr_nonce'], 'elr_nonce' ) ) {
            die('Permission denied');
        }

        $tax_args = array();
        $current_tax = null;

        if ( array_key_exists( 'taxonomy', $_POST ) ) {
            $taxonomy = $_POST['taxonomy'];

            foreach ( $taxonomy as $key => $value ) {
                $arr = array( 'taxonomy' => $key, 'field' => 'slug', 'terms' => array( $value ) );
                array_push( $tax_args, $arr );
            }

            // check if taxonomy page
            if ( $_POST['elr_current_term'] ) {
                $current_tax = $_POST['elr_current_term'];
                $arr = array( 'taxonomy' => 'type', 'field' => 'slug', 'terms' => array( $current_tax ) );
                array_push( $tax_args, $arr );
            }
        }

        if ( array_key_exists( 'num', $_POST ) ) {
            $num = $_POST['num'];
        } else {
            $num = 20;
        }

        if ( array_key_exists( 'post_type', $_POST ) ) {
            $post_type = $_POST['post_type'];
        } else {
            $post_type = 'posts';
        }

        if ( post_type_exists( $post_type ) ) {
            $count_posts = wp_count_posts( $post_type );
            $num_posts = $count_posts->publish;
        } else {
            $num_posts = 0;
        }

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        // WP Query
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $num,
            'tax_query' => $tax_args,
            'paged' => $paged,
            'post_status' => 'publish'
        );

        // If taxonomy is not set, remove key from array and get all posts
        if ( !$taxonomy ) {
            unset( $args['tax_query'] );
        }

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php require( get_template_directory() . '/content/content-' . $post_type . '.php' ); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <h2>No products found</h2>
        <?php endif;

        die();
    }

    public function is_blog_page() {
        if ( is_front_page() && is_home() ) {
            return true;
        } elseif ( is_front_page() ) {
            return false;
        } elseif ( is_home() ) {
            return true;
        } else {
            return false;
        }
    }

    public function slugify($str) {
        return str_replace(' ', '-', strtolower($str));
    }

    public function page_nav($before = '', $after = '') {
        global $wpdb, $wp_query;

        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;

        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
        $pages_to_show = apply_filters('elr_filter_pages_to_show', 8);
        $pages_to_show_minus_1 = $pages_to_show-1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
        if($start_page <= 0) {
            $start_page = 1;
        }
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }

        if ($max_page > 1) {
            echo $before.'<div class="page-nav">';
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = "&laquo;";
                echo '<a href="'.get_pagenum_link().'" title="'.$first_page_text.'" class="number">'.$first_page_text.'</a>';
            }
            //previous_posts_link('&lt;');
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    echo ' <span class="number current">'.$i.'</span> ';
                } else {
                    echo ' <a href="'.get_pagenum_link($i).'" class="number">'.$i.'</a> ';
                }
            }
            //next_posts_link('&gt;');
            if ($end_page < $max_page) {
                $last_page_text = "&raquo;";
                echo '<a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'" class="number">'.$last_page_text.'</a>';
            }
            echo '</div>'.$after;
        }
    }

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

    public function loop() {

        if (have_posts()) {

            while (have_posts()) : the_post();

                if ($this->is_custom_post_type()) {

                    get_template_part('content/content', get_post_type());

                } else {

                    get_template_part('content/content', get_post_format());
                }

            endwhile;

            get_template_part('partials/pagination');

        } else {

            get_template_part('content/content', 'none');
        }
    }

    public function page_loop() {
        while (have_posts()) : the_post();
        echo '<article>';
            $this->page_title();
            $this->post_thumbnail();
            the_content();
            $this->link_pages();
            $this->edit_link();
        echo '</article>';
        endwhile;
    }

    public function normal_loop() {
        echo '<div class="content-holder elr-col-two-thirds">';
        $this->loop();
        echo '</div>';
        echo '<aside class="sidebar elr-col-third" id="sidebar">';
        get_sidebar();
        echo '</aside>';
    }

    public function post_thumbnail($holder = 'post-image-holder', $thumbnail_size = array(400, 9999)) {

        if (has_post_thumbnail()) {

            echo '<div class="' . $holder . '">';

                if (is_single() || is_page()) {
                    the_post_thumbnail($thumbnail_size);

                } else {
                    echo '<a href="';
                        the_permalink();
                    echo '">';
                        the_post_thumbnail($thumbnail_size);
                    echo '</a>';
                }

                $caption = get_post(get_post_thumbnail_id())->post_excerpt;

                if ($caption) {

                    echo '<figcaption class="post-image-caption">';
                        echo esc_html($caption);
                    echo '</figcaption>';
                }

            echo '</div>';
        }
    }

    public function archive_link($post_type, $text = 'See More') {
        $cpt_archive = get_post_type_archive_link($post_type);
        $post_name = get_post_type_object($post_type)->label;

        echo '<a href="' . $cpt_archive . '" class="archive-link">' . $text . '</a>';
    }

    public function single_loop($archive_link = false, $archive_link_text = null) {

        while (have_posts()) : the_post();

            if ($this->is_custom_post_type()) {

                get_template_part('content/content', get_post_type());

            } else {

                get_template_part('content/content', get_post_format());
            }

            $this->link_pages();

            get_template_part('partials/post-nav');

            if ($this->is_custom_post_type() && $archive_link_text) {
                $this->archive_link(get_post_type(), $archive_link_text);
            }

        endwhile;
    }

    public function post_category() {
        the_category(', ');
    }

    public function post_author() {
        the_author_posts_link();
    }

    public function post_tags() {
        the_tags(' <li class="post-tag"><i class="fa fa-tags"></i> ', ', ', '</li>');
    }

    public function post_comments() {

        if (comments_open()) {
            comments_popup_link(__('0 Comments', 'elr'), __('1 Comment', 'elr'), __('% Comments', 'elr'));
        }
    }

    public function post_meta($id) {
        echo '<ul class="post-meta elr-inline-list">';
            echo '<li class="post-date"><i class="fa fa-calendar"></i> ';
                $this->post_date();
            echo '</li>';
            echo '<li class="post-author"><i class="fa fa-user"></i> ';
                $this->post_author();
            echo '</li>';
            echo '<li class="post-category"><i class="fa fa-folder"></i> ';
                $this->post_category();
            echo '</li>';
            $this->post_tags();
            if (comments_open()) {
                echo '<li class="post-comment"><i class="fa fa-comment"></i> ';
                $this->post_comments();
                echo '</li>';
            }
        echo '</ul>';
    }

    public function post_title() {

        if (is_single() || is_page()) {
            echo '<h1 class="post-title" role="heading">';
                the_title();
            echo '</h1>';
        } else {
            echo '<h1 class="post-title" role="heading"><a href="';
            the_permalink();
            echo '">';
            the_title();
            echo '</a></h1>';
        }
    }

    public function page_title() {
        echo '<h1 class="page-title" role="heading">';
            the_title();
        echo '</h1>';
    }

    public function post_content($excerpt = true) {

        if (is_single() || is_page()) {
            echo '<div class="post-content">';
                the_content();
            echo '</div>';
        } elseif ($excerpt === true) {
            echo '<div class="post-excerpt">';
                the_excerpt();
            echo '</div>';
        } else {
            the_content();
        }
    }

    public function post_actions_nav($id) {
        echo '<div class="post-actions">';
        edit_post_link(__('<i class="fa fa-pencil-square-o"></i>', 'elr'));

        if (current_user_can('publish_posts')) {
            echo ' <a href="/wp-admin/post-new.php?post_type=';
            echo get_post_type();
            echo '"><i class="fa fa-plus"></i></a> ';
        }

        if (current_user_can('delete_posts')) {
            echo '<a href="';
            echo get_delete_post_link($id);
            echo '"><i class="fa fa-trash-o"></i></a>';
        }
        echo '</div>';
    }

    public function edit_link($text = 'Edit') {
        edit_post_link(__($text, 'elr'));
    }

    public function link_pages() {
        wp_link_pages(array('before' => '<p><strong>'.__('Pages:','elr').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
    }

    public function remove_wp_version() {
       return '';
    }

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

    public function term_list($taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ));

        $list = '';

        foreach ($terms as $term) {
            $list .= '<li>';
            $list .= '<a href="';
            $list .= get_term_link($term->term_id);
            $list .= '">';
            $list .= $term->name;
            $list .= '</a></li>';
        }

        echo $list;
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
                    echo $this->slugify($taxonomy) . '-' . $this->slugify($term->name);
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
                        echo $this->slugify($taxonomy) . '-' . $this->slugify($term->name);
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

    public function post_date($relative_publish_dates = false) {
        if ( $relative_publish_dates ) {
            echo '<time datetime="';
                the_time('o-m-d');
            echo '" pubdate>';
                echo 'Posted ';
                echo human_time_diff( get_the_time('U'), current_time('timestamp') );
                echo ' ago ';
            echo '</time>';
        } else {
            echo '<time datetime="';
                the_time('o-m-d');
            echo '" pubdate>';
            the_time('F j, Y');
            echo '</time>';
        }
    }

    public function time_diff( $datetime ) {
        $current_time = current_time('timestamp') ;

        if ( $datetime ) {

            $datetime = strtotime( $datetime );
            echo '<span>';

            if ( $datetime > $current_time ) {

                echo 'in about ' . human_time_diff( $datetime, current_time('timestamp') );

            } else if ( $datetime = $current_time ) {

                echo 'Right Now';

            } else {

                echo 'about ' . human_time_diff( $datetime, current_time('timestamp') ) . ' ago';
            }

            echo '</span>';
        }
    }

    public function start_end( $start_date, $start_time, $end_date, $end_time ) {

        if ( $start_date === $end_date ) {

            echo '<p>';
                echo mysql2date( 'l, F j, Y', $start_date );
                echo '</span>';
                echo mysql2date( 'g:i a', $start_time );
                echo '</span> to ';
                echo mysql2date( 'g:i a', $end_time );
                echo '</span>';
            echo '</p>';

        } else {

            echo '<p>';
                echo mysql2date( 'l, F j, Y', $start_date );
                echo '</span> at ';
                echo mysql2date( 'g:i a', $start_time );
                echo '</span> to ';
                echo mysql2date( 'l, F j, Y', $end_date );
                echo '</span> at ';
                echo mysql2date( 'g:i a', $end_time );
                echo '</span>';
            echo '</p>';
        }
    }

    public function is_expired( $datetime = null ) {
        $current_time = strtotime( current_time( 'Y-m-d H:i' ) );

        if ( $datetime ) {
            $datetime = strtotime( $datetime );
            return $datetime >= $current_time ? false : true;

        } else {

            return false;
        }
    }


    public $validation_errors = array();

    public function validate($data, $rules) {

        $valid = TRUE;

        // extracts callback from $rule

        foreach ($rules as $fieldname => $rule) {
            // Extract rules as callbacks

            $callbacks = explode('|', $rule);

            // Call the validation callback

            foreach ($callbacks as $callback) {
                $value = isset($data[$fieldname]) ? $data[$fieldname] : NULL;

                $params = $this->parseParam($callback);

                $callback = $this->parseCallback($callback);

                if ($this->$callback($value, $fieldname, $params) == FALSE) {
                    $valid = FALSE;
                }
            }
        }

        return $valid;
    }

    private function validate_parseCallback($callback) {
        $colon = strpos($callback, ':');
        $length = strlen($callback);

        if ($colon == FALSE) {
            $rule = $callback;
        } else {
            $rule = substr($callback , 0, $length - ($length - $colon));
        }

        return $rule;
    }

    // extracts $params array from $rule

    private function validate_parseParam($callback) {
        $param_list = NULL;
        $colon = strpos($callback, ':');
        $params = array();

        if ($colon == FALSE) {
            $param = NULL;
        } else {
            $param_list = substr($callback , $colon + 1);
        }

        if ($param_list != NULL) {
            $params = explode(':', $param_list);
        }

        return $params;
    }

    // checks that a value is numeric

    private function validate_numeric($value, $fieldname) {

        $pattern = '/^[0-9.,]*$/';

        if (preg_match($pattern, $value)) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "Please provide a valid number $fieldname";
        }

        return $valid;
    }

    // checks that a value is currency

    private function validate_currency($value, $fieldname) {
        $pattern = '/^[0-9.,$]*$/';

        if (preg_match($pattern, $value)) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "Please provide a valid number $fieldname";
        }

        return $valid;
    }

    // checks that a value is an integer

    private function validate_integer($value, $fieldname) {
        $valid = filter_var($value, FILTER_VALIDATE_INT);

        if ($valid == FALSE) {
            $this->validation_errors[] = "Please provide a whole number for $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks for an integer that is less than a max value

    private function validate_max($value, $fieldname, $params) {
        $options = array (
            'options' => array(
                'max_range' => $params[0]
           )
       );

        $valid = filter_var($value, FILTER_VALIDATE_INT, $options);

        if ($valid == FALSE) {
            $this->validation_errors[] = "Please provide a whole number less than $params[0] for $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks for an integer that is greater than a min value

    private function validate_min($value, $fieldname, $params) {
        $options = array (
            'options' => array(
                'min_range' => $params[0]
           )
       );

        $valid = filter_var($value, FILTER_VALIDATE_INT, $options);

        if ($valid == FALSE) {
            $this->validation_errors[] = "Please provide a whole number greater than $params[0] for $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks for an integer that falls within a specified range

    private function validate_range($value, $fieldname, $params) {
        $options = array (
            'options' => array(
                'min_range' => $params[0],
                'max_range' => $params[1]
           )
       );

        $valid = filter_var($value, FILTER_VALIDATE_INT, $options);

        if ($valid == FALSE) {
            $this->validation_errors[] = "Please provide a whole number between $params[0] and $params[1] for $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // most form values are at least 3 characters long
    // automatically rejects any value that is less than 3 characters in length

    private function validate_short($value, $fieldname) {
        $value = trim($value);

        if (strlen($value) > 3) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "$fieldname should be more than two characters";
        }

        return $valid;
    }

    // checks that a value is alpha characters only

    private function validate_alpha($value, $fieldname) {
        $pattern = '/^[a-z]*$/i';

        if (preg_match($pattern, $value)) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "Please provide a valid $fieldname";
        }

        return $valid;
    }

    // checks a value for a minimum string length

    private function validate_minLength($value, $fieldname, $params) {
        $value = trim($value);

        if (strlen($value) > $params[0]) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "$fieldname should be more than $params[0] characters";
        }

        return $valid;
    }

    // checks a value for a maximum string length

    private function validate_maxLength($value, $fieldname, $params) {
        $value = trim($value);

        if (strlen($value) < $params[0]) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "$fieldname should be less than $params[0] characters";
        }

        return $valid;
    }

    // checks a value for an exact string length

    private function validate_length($value, $fieldname, $params) {
        $value = trim($value);

        if (strlen($value) == $params[0]) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "$fieldname should be exactly $params[0] characters";
        }

        return $valid;
    }

    // checks a value for a string length range

    private function validate_betweenLength($value, $fieldname, $params) {
        $value = trim($value);
        $str_len = strlen($value);
        $min = $params[0];
        $max = $params[1];

        if ($str_len >= $min and $str_len <= $max) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "$fieldname should be between $min and $max characters";
        }

        return $valid;
    }

    // accepts alpha characters, ' ', and '.'
    // Does not ensure that value is actually a first name and last name
    // Only looks for acceptable chararacters that would appear in a person's full name
    // Examples: John Q. Public, John, John Doe

    private function validate_fullName($value, $fieldname) {

        $pattern = '/^[a-z.,\s]*$/i';

        if (preg_match($pattern, $value)) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "Please provide a valid $fieldname";
        }

        return $valid;
    }

    // validates that a ten digit phone number with an optional extension is provided
    // only validates US phone numbers for now

    private function validate_phone($value, $fieldname) {

        function cleanPhone($value) {

            // remove whitespace
            $value = trim($value);

            // look for extension followed by 'x'
            // split phone number and extension into two seperate strings
            if (strpos($value, 'x') != FALSE) {
                $complete_phone = preg_split('/[x]/i', $value);

                $value = $complete_phone[0];
            }

            // strip spaces and everything that is not a number
            $value = preg_replace('/[^0-9]*/', '', $value);

            // strip leading 1
            $value = preg_replace('/\b[1]/', '', $value);

            return $value;
        }

        // no bad area codes or toll free / pay per call
        // BAD_AREA_CODES = open('bad-area-codes.txt', 'r').read().split('\n');

        // make sure phone number is exactly 10 digits

        if (strlen($value) < 10) {
            $valid = FALSE;
            $this->validation_errors[] = "Too short! Please provide a valid phone number for $fieldname";
        } else {
            $phone = cleanPhone($value);

            if (strlen($phone) != 10) {
                $valid = FALSE;
                $this->validation_errors[] = "Please provide a valid phone number for $fieldname";
            } else {
                $valid = TRUE;
            }
        }

        return $valid;
    }

    // checks for a valid email

    private function validate_email($value, $fieldname) {
        $valid = filter_var($value, FILTER_VALIDATE_EMAIL);

        if ($valid == FALSE) {
            $this->validation_errors[] = "Please provide a valid email address for $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks for a valid url

    private function validate_url($value, $fieldname) {
        $valid = filter_var($value, FILTER_VALIDATE_URL);

        if ($valid == FALSE) {
            $this->validation_errors[] = "Please provide a valid url for $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks a string to see if it contains any urls

    private function validate_nourl($value, $fieldname) {
        $pattern = '/(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?/i'; // url

        if (preg_match($pattern, $value)) {
            $valid = FALSE;
            $this->validation_errors[] = "Invalid $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks a string to see if it contains any html tags

    private function validate_notags($value, $fieldname) {
        $pattern = '/[<>]/'; // tags

        if (preg_match($pattern, $value)) {
            $valid = FALSE;
            $this->validation_errors[] = "$fieldname cannot contain html";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks to see that any required fields are not null

    private function validate_required($value, $fieldname) {
        $valid = !empty($value);

        if ($valid == FALSE) {
            $this->validation_errors[] = "The $fieldname is required";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // checks for header attack attempts

    private function validate_attacks($value, $fieldname) {
        $pattern = '/Content-Type:|Bcc:|Cc:/i';

        if (preg_match($pattern, $value)) {
            $valid = FALSE;
            $this->validation_errors[] = "Invalid $fieldname";
        } else {
            $valid = TRUE;
        }

        return $valid;
    }

    // honeypot

    private function validate_honeypot($value, $fieldname) {

        if ((!$value)) {
            $valid = TRUE;
        } else {
            $valid = FALSE;
            $this->validation_errors[] = "There was an error processing your message";
        }

        return $valid;
    }
}
?>