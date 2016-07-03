<?php

namespace Framework\Helpers;

class Comments
{
    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function customThemeComment($comment, $args, $depth)
    {
        echo '<li id="comment-';
        echo get_comment_ID();
        echo '" ';
        echo $this->commentClass();
        echo '>';
        echo '<section>';
        echo $this->author($comment);
        echo $this->commentTime($comment);
        echo $this->editLink();
        echo $this->comment($comment);
        echo $this->replyLink($args, $depth);
        echo '</section>';
    }

    private function commentClass()
    {
        $classes = get_comment_class();
        $comment_class = 'class="';

        foreach ($classes as $class) {
            // print_r($class . '<br>');
            $comment_class .= $class . ' ';
        }

        $comment_class .= '"';

        return $comment_class;
    }

    private function author($comment)
    {
        $comment_author = '<p class="comment-author">';
        $comment_author .= get_avatar($comment,$size='48');
        $comment_author .= '<cite>' . get_comment_author_link() . '</cite><br>';

        return $comment_author;
    }

    private function commentTime($comment)
    {
        $comment_time = '<small class="comment-time"><strong>';
        $comment_time .= comment_date('M d, Y');
        $comment_time .= '</strong>';
        $comment_time .= comment_time('H:i:s');
        $comment_time .= '</small>';

        return $comment_time;
    }

    private function editLink()
    {
        return '<small>' . edit_comment_link(__('Edit', 'elr'),' [',']') . '</small>';
    }

    private function comment($comment)
    {
        $comment_text = '<div class="commententry">';

        if ($comment->comment_approved == '0') {
            $comment_text .= _e('Your comment is awaiting moderation.', 'elr');
        }
        $comment_text .= '<p>' . comment_text() . '</p>';
        $comment_text .= '</div>';

        return $comment_text;
    }

    private function replyLink($args, $depth)
    {
        $reply_link = '<p class="reply">';
        $reply_link .= comment_reply_link(
            array_merge(
                $args, [
                    'add_below' => 'comment',
                    'depth' => $depth,
                    'reply_text' => __('Reply', 'elr'),
                    'max_depth' => $args['max_depth']
                ]
            )
        );
        $reply_link .= '</p>';

        return $reply_link;
    }
}
?>