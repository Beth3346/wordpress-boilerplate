<?php

namespace Framework\Helpers;

use Framework\Helpers\Utility;
use Framework\Helpers\Post;

class Loop
{
    /**
     * Updates the number of posts that display on each archive page
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function setNumberOfCpts($query, $num = -1, $post_types = [], $taxonomies = [])
    {
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

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function cptLoop()
    {
        if (have_posts()) {
            while (have_posts()) : the_post();
                get_template_part('content/content', get_post_type());
            endwhile;
            get_template_part('partials/pagination');
        } else {
            get_template_part('content/content', 'none');
        }
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function loop()
    {
        if (have_posts()) {
            while (have_posts()) : the_post();
                $utility = new Utility;
                if ($utility->isCustomPostType()) {
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

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function pageLoop()
    {
        while (have_posts()) : the_post();
        $post_helper = new PostHelper;
        $content_helper = new ContentHelper;
        echo '<article>';
            $post_helper->pageTitle();
            $post_helper->postThumbnail();
            the_content();
            $content_helper->linkPages();
            $content_helper->editLink();
        echo '</article>';
        endwhile;
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function normalLoop(
        $content_classes = 'content-holder elr-col-two-thirds',
        $sidebar_classes = 'sidebar elr-col-third'
    ) {
        echo '<div class="' . $content_classes . '">';
        $this->loop();
        echo '</div>';
        echo '<aside class="' . $sidebar_classes . '" id="sidebar">';
        get_sidebar();
        echo '</aside>';
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function singleLoop($archive_link = false, $archive_link_text = null)
    {
        while (have_posts()) : the_post();
            $utility = new Utility;
            $content_helper = new ContentHelper;
            $post_helper = new PostHelper;

            if ($utility->isCustomPostType()) {
                get_template_part('content/content', get_post_type());
            } else {
                get_template_part('content/content', get_post_format());
            }

            $content_helper->linkPages();

            get_template_part('partials/post-nav');

            if ($utility->isCustomPostType() && $archive_link_text) {
                $post_helper->archiveLink(get_post_type(), $archive_link_text);
            }

        endwhile;
    }
}