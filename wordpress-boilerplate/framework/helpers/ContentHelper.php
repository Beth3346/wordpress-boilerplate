<?php

namespace Framework\Helpers;

class ContentHelper
{
    public function trimTitle($title_length = 75)
    {
        $title = get_the_title();

        if (strlen($title) > $title_length) {
            return substr($this->removeQuotes($title), 0, $title_length) . '...';
        }

        return substr($this->removeQuotes($title), 0, $title_length);
    }

    public function trimContent($content, $content_length = 200)
    {
        // $content = get_the_content();

        if (strlen($content) > $content_length) {
            return wp_trim_words($this->removeQuotes($content), $content_length, "...");
        } else {
            return $this->removeQuotes($content);
        }
    }

    public function removeQuotes($content)
    {
        return str_ireplace('"', '', $content);
    }

    public function email($email)
    {
        if ($email) {
            $html = '<a href="mailto:';
            $html .= antispambot($email);
            $html .= '">';
            $html .= antispambot($email);
            $html .= '</a>';

            return $html;
        }

        return;
    }
    public function video($video, $width = 560, $height = 349)
    {
        if ($video) {
            $html = '<div class="video-holder">';
            $html .= '<iframe src="//';
            $html .= esc_attr($video);
            $html .= '" width=';
            $html .= $width;
            $html .= "' height='";
            $html .= $height;
            $html .= "' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen>";
            $html .= '</iframe>';
            $html .= '</div>';

            return $html;
        }

        return;
    }

    public function address($address)
    {
        if (array_filter($address)) {
            echo '<ul class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';

            if (array_key_exists('street_address', $address)) {
                echo '<li itemprop="streetAddress">';
                echo esc_html($address['street_address']);
                echo '</li>';
            }

            echo '<li>';

            if (array_key_exists('city', $address)) {
                echo '<span itemprop="addressLocality">';
                echo esc_html($address['city']);
                echo ', </span>';
            }

            if (array_key_exists('state', $address)) {
                echo '<span itemprop="addressRegion">';
                echo esc_html($address['state']);
                echo ', </span>';
            }

            if (array_key_exists('zip_code', $address))
            {
                if ($address['zip_code'])
                {
                    echo '<span itemprop="postalCode">';
                    echo esc_html($address['zip_code']);
                    echo ', </span>';
                }
            }

            if (array_key_exists('country', $address))
            {
                if ($address['country'])
                {
                    echo '<span itemprop="country">';
                    echo esc_html($address['country']);
                    echo '</span><br>';
                }
            }

            echo '</li>';
            echo '</ul>';
        }
    }

    public function breadcrumbs()
    {
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">','</p>');
        }

        return;
    }

    public function editLink($text = 'Edit')
    {
        edit_post_link(__($text, 'elr'));
    }

    public function linkPages()
    {
        wp_link_pages(['before' => '<p><strong>'.__('Pages:','elr').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number']);
    }
}