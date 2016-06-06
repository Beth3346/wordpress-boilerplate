<?php

namespace Framework\Helpers;

class Archive
{
    public function authorArchiveTitle()
    {
        the_post();
        printf(__('All posts by %s', 'elr'), get_the_author());
    }

    public function authorArchiveDescription()
    {
        if (get_the_author_meta('description')) {
            echo '<div class="author-description">';
            echo get_the_author_meta('description');
            echo '</div>';
        }
    }

    public function categoryArchiveTitle()
    {
        printf(__('Category: %s', 'elr'), single_cat_title('', false));
    }

    public function categoryArchiveDescription()
    {
        $term_description = term_description();

        if (! empty($term_description)) {
            printf('<div class="taxonomy-description">%s</div>', $term_description);
        }
    }

    public function searchArchiveTitle()
    {
        printf(__('Search Results for: %s', 'elr'), '<span>' . get_search_query() . '</span>');
    }

    public function tagArchiveTitle()
    {
        printf(__('Tag: %s', 'elr'), single_tag_title('', false));
    }

    public function tagArchiveDescription()
    {
        $term_description = term_description();

        if (! empty($term_description)) {
            printf('<div class="taxonomy-description">%s</div>', $term_description);
        }
    }
}