<?php

class ELR_Post {
    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function loop() {
        $elr_cpt = new ELR_CPT;

        if (have_posts()) {

            while (have_posts()) : the_post();

                if ($elr_cpt->is_custom_post_type()) {

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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function archive_link($post_type, $text = 'See More') {

        $cpt_archive = get_post_type_archive_link($post_type);
        $post_name = get_post_type_object($post_type)->label;

        echo '<a href="' . $cpt_archive . '" class="archive-link">' . $text . '</a>';
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function single_loop($archive_link = false, $archive_link_text = null) {
        $elr_cpt = new ELR_CPT;

        while (have_posts()) : the_post();

            if ($elr_cpt->is_custom_post_type()) {

                get_template_part('content/content', get_post_type());

            } else {

                get_template_part('content/content', get_post_format());
            }

            $this->link_pages();

            get_template_part('partials/post-nav');

            if ($elr_cpt->is_custom_post_type() && $archive_link_text) {
                $this->archive_link(get_post_type(), $archive_link_text);
            }

        endwhile;
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function post_category() {
        the_category(', ');
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function post_author() {
        the_author_posts_link();
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function post_tags() {
        the_tags(' <li class="post-tag"><i class="fa fa-tags"></i> ', ', ', '</li>');
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function post_comments() {

        if (comments_open()) {
            comments_popup_link(__('0 Comments', 'elr'), __('1 Comment', 'elr'), __('% Comments', 'elr'));
        }
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function post_meta($id) {
        $elr_time = new ELR_Time;

        echo '<ul class="post-meta elr-inline-list">';
            echo '<li class="post-date"><i class="fa fa-calendar"></i> ';
                $elr_time->post_date();
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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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
}