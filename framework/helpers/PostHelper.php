<?php

namespace Framework\Helpers;
use Framework\Helpers\ContentHelper;
use Framework\Helpers\Query;

class PostHelper
{

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function getPosts(
        $post_type = 'post',
        $num = 3,
        $sort = 'date',
        $thumb = true,
        $excerpt_length = 40,
        $container = 'elr-col-third'
    ) {
        $query_helper = new Query;
        $content_helper = new ContentHelper;
        $query = $query_helper->postQuery($post_type, $num, $sort);

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
                $content .= esc_html($content_helper->trim_content($excerpt_length));
                $content .= '</p><a href="';
                $content .= get_the_permalink();
                $content .= '" class="post-box-learn-more">Read More</a></div></div>';

            endwhile;

            wp_reset_postdata();

            return $content;
        }

        return null;
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function relatedPosts($taxonomy = 'category', $post_type = 'current', $num_posts = 3)
    {
        $query_helper = new Query;
        $loop = $query_helper->getRelatedPosts($taxonomy, $post_type, $num_posts);

        if ($loop->have_posts()) {
            $related_posts = '<ul class="related-category-posts">';

            while ($loop->have_posts()) {
                $loop->the_post();
                $related_posts .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }

            $related_posts .= '</ul>';
            wp_reset_query();

            return $related_posts;
        }

        return null;
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function relatedPostsImages($taxonomy = 'category', $post_type = 'current', $num_posts = 3)
    {
        $query_helper = new Query;
        $loop = $query_helper->getRelatedPosts($taxonomy, $post_type, $num_posts);

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
        }

        return null;
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postThumbnail($holder = 'post-image-holder', $thumbnail_size = array(400, 9999))
    {
        if (has_post_thumbnail()) {
            $caption = get_post(get_post_thumbnail_id())->post_excerpt;
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

                if ($caption) {
                    echo '<figcaption class="post-image-caption">';
                        echo esc_html($caption);
                    echo '</figcaption>';
                }

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

    public function archiveLink($post_type, $text = 'See More')
    {
        $cpt_archive = get_post_type_archive_link($post_type);
        $post_name = get_post_type_object($post_type)->label;

        echo '<a href="' . $cpt_archive . '" class="archive-link">' . $text . '</a>';
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postCategory()
    {
        the_category(', ');
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postAuthor()
    {
        the_author_posts_link();
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postTags()
    {
        the_tags(' <li class="post-tag"><i class="fa fa-tags"></i> ', ', ', '</li>');
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postComments()
    {
        if (comments_open()) {
            comments_popup_link(__('0 Comments', 'elr'), __('1 Comment', 'elr'), __('% Comments', 'elr'));
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

    public function postDate($relative_publish_dates = false)
    {
        if ($relative_publish_dates) {
            echo '<time datetime="';
                the_time('o-m-d');
            echo '" pubdate>';
                echo 'Posted ';
                echo human_time_diff(get_the_time('U'), current_time('timestamp'));
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

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postMeta($id)
    {
        echo '<ul class="post-meta elr-inline-list">';
            echo '<li class="post-date"><i class="fa fa-calendar"></i> ';
                $this->postDate();
            echo '</li>';
            echo '<li class="post-author"><i class="fa fa-user"></i> ';
                $this->postAuthor();
            echo '</li>';
            echo '<li class="post-category"><i class="fa fa-folder"></i> ';
                $this->postCategory();
            echo '</li>';

            $this->postTags();

            if (comments_open()) {
                echo '<li class="post-comment"><i class="fa fa-comment"></i> ';
                $this->postComments();
                echo '</li>';
            }

        echo '</ul>';
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postTitle($tag = 'h1')
    {
        if (is_single() || is_page()) {
            echo '<' . $tag . ' class="post-title" role="heading">';
                the_title();
            echo '</' . $tag . '>';
        } else {
            echo '<' . $tag . ' class="post-title" role="heading"><a href="';
            the_permalink();
            echo '">';
            the_title();
            echo '</a></' . $tag . '>';
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

    public function pageTitle($tag = 'h1')
    {
        echo '<' . $tag . ' class="page-title" role="heading">';
            the_title();
        echo '</' . $tag . '>';
    }

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function postContent($excerpt = true, $num_characters = 100)
    {
        $content = get_the_content();
        $content_helper = new ContentHelper;

        if (is_single()) {
            echo '<div class="post-content">';
                the_content();
            echo '</div>';
        } elseif ($excerpt === true) {
            echo '<div class="post-excerpt">';
            echo $content_helper->trimContent($content, $num_characters);
            echo '</div>';
        } else {
            the_content();
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

    public function postActionsNav($id)
    {
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

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function moreLink($text = 'Read More')
    {
        $link = '<p><a href="';
        $link .= get_the_permalink();
        $link .= '" class="read-more-link">';
        $link .= $text;
        $link .= '</a></p>';

        echo $link;
    }
}