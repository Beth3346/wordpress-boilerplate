<?php

namespace Framework\Helpers;

class Archive
{
    /**
     * outputs 
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function authorArchiveTitle($text = 'All posts by')
    {
        the_post();
        $author = get_the_author();
        // printf(__('All posts by %s', 'elr'), get_the_author());
        echo $text . ' ' . $author;
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function authorArchiveDescription()
    {
        if (get_the_author_meta('description')) {
            echo '<div class="author-description">';
            echo get_the_author_meta('description');
            echo '</div>';
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

    public function categoryArchiveTitle()
    {
        printf(__('Category: %s', 'elr'), single_cat_title('', false));
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function categoryArchiveDescription()
    {
        $term_description = term_description();

        if (! empty($term_description)) {
            printf('<div class="taxonomy-description">%s</div>', $term_description);
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

    public function searchArchiveTitle()
    {
        printf(__('Search Results for: %s', 'elr'), '<span>' . get_search_query() . '</span>');
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function tagArchiveTitle()
    {
        printf(__('Tag: %s', 'elr'), single_tag_title('', false));
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function tagArchiveDescription()
    {
        $term_description = term_description();

        if (! empty($term_description)) {
            printf('<div class="taxonomy-description">%s</div>', $term_description);
        }
    }
}