<?php

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_post_thumbnail( $holder = 'post-image-holder', $thumbnail_size = array( 400, 9999 ) ) {

    if ( has_post_thumbnail() ) {

        echo '<div class="' . $holder . '">';

            if ( is_single() || is_page() ) {
                the_post_thumbnail( $thumbnail_size );

            } else {
                echo '<a href="';
                    the_permalink();
                echo '">';
                    the_post_thumbnail( $thumbnail_size );
                echo '</a>';
            }

            $caption = get_post(get_post_thumbnail_id())->post_excerpt;

            if ( $caption ) {

                echo '<figcaption>';
                    echo esc_html( $caption );
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

function elr_map( $map, $width = 500, $height = 450 ) {
    echo '<iframe src="';
    echo esc_url( $map );
    echo '"width="';
    echo $width;
    echo '" height="';
    echo $height;
    echo '" frameborder="0" style="border:0;"></iframe>';
}

/**
 * TODO: Function Description
 *
 * @since  3.0.0
 * @access public
 * @param
 * @return void
 */

function elr_remove_quotes( $content ) {
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

function elr_trim_title( $title_length = 75 ) {
    $title = get_the_title();

    if ( strlen( $title ) > $title_length ) {

        return substr( elr_remove_quotes( $title ), 0, $title_length ) . '...';

    } else {

        return substr( elr_remove_quotes( $title ), 0, $title_length );
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

function elr_trim_content( $content_length = 200 ) {
    $content = get_the_content();

    if ( strlen( $content ) > $content_length ) {

        return wp_trim_words( elr_remove_quotes( $content ), 30, "..." );

    } else {

        return elr_remove_quotes( $content );
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

function elr_video( $video, $width = 560, $height = 349 ) {

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

function elr_address( $address ) {
    if ( array_filter( $address ) ) {
        echo '<ul class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';

        if ( array_key_exists( 'street_address', $address ) ) {
            if ( $address['street_address'] ) {
                echo '<li class="elr-text-center" itemprop="streetAddress">';
                echo esc_html( $address['street_address'] );
                echo '</li>';
            }
        }

        echo '<li class="elr-text-center">';

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

function elr_email( $email ) {

    if ( $email ) {
        echo '<a href="mailto:';
        echo antispambot( $email );
        echo '">';
        echo antispambot( $email );
        echo '</a>';
    }
}