<?php

class ELR_Content {

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function trim_title( $title_length = 75 ) {
        $title = get_the_title();

        if ( strlen( $title ) > $title_length ) {

            return substr( $this->remove_quotes( $title ), 0, $title_length ) . '...';

        } else {

            return substr( $this->remove_quotes( $title ), 0, $title_length );
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

    public function trim_content( $content_length = 200 ) {
        $content = get_the_content();

        if ( strlen( $content ) > $content_length ) {

            return wp_trim_words( $this->remove_quotes( $content ), $content_length, "..." );

        } else {

            return $this->remove_quotes( $content );

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

    public function remove_quotes( $content ) {
        return str_ireplace( '"', '', $content );
    }

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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

    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

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
}