<?php

namespace Framework\Helpers;

class Archive
{
    /**
     * outputs a title for the Author Archive template
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function authorArchiveTitle($text = 'All posts by ')
    {
        echo $text . get_the_author();
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
            echo '<p class="author-description">';
            echo get_the_author_meta('description');
            echo '</p>';
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

    public function categoryArchiveTitle($text = 'Category: ')
    {
        echo $text . single_cat_title('', false);
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
        $term_description = strip_tags(term_description(), '<br> <span> <strong> <em> <b> <i>');

        if (!empty($term_description)) {
            echo '<p class="taxonomy-description">' . $term_description . '</p>';
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

    public function searchArchiveTitle($text = 'Search Results for: ')
    {
        echo $text . get_search_query();
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function tagArchiveTitle($text = 'Tag: ')
    {
        echo $text . single_tag_title('', false);
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
        $term_description = strip_tags(term_description(), '<br> <span> <strong> <em> <b> <i>');

        if (!empty($term_description)) {
            echo '<p class="taxonomy-description">' . $term_description . '</p>';
        }
    }
}