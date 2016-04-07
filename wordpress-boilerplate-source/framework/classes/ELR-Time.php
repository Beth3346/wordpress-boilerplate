<?php

class ELR_Time {
    /**
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function post_date($relative_publish_dates = false) {

        if ( $relative_publish_dates ) {
            echo '<time datetime="';
                the_time('o-m-d');
            echo '" pubdate>';
                echo 'Posted ';
                echo human_time_diff( get_the_time('U'), current_time('timestamp') );
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
     * TODO: Function Description
     *
     * @since  3.0.0
     * @access public
     * @param
     * @return void
     */

    public function time_diff( $datetime ) {
        $current_time = current_time('timestamp') ;

        if ( $datetime ) {

            $datetime = strtotime( $datetime );
            echo '<span>';

            if ( $datetime > $current_time ) {

                echo 'in about ' . human_time_diff( $datetime, current_time('timestamp') );

            } else if ( $datetime = $current_time ) {

                echo 'Right Now';

            } else {

                echo 'about ' . human_time_diff( $datetime, current_time('timestamp') ) . ' ago';
            }

            echo '</span>';
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

    public function start_end( $start_date, $start_time, $end_date, $end_time ) {

        if ( $start_date === $end_date ) {

            echo '<p>';
                echo mysql2date( 'l, F j, Y', $start_date );
                echo '</span>';
                echo mysql2date( 'g:i a', $start_time );
                echo '</span> to ';
                echo mysql2date( 'g:i a', $end_time );
                echo '</span>';
            echo '</p>';

        } else {

            echo '<p>';
                echo mysql2date( 'l, F j, Y', $start_date );
                echo '</span> at ';
                echo mysql2date( 'g:i a', $start_time );
                echo '</span> to ';
                echo mysql2date( 'l, F j, Y', $end_date );
                echo '</span> at ';
                echo mysql2date( 'g:i a', $end_time );
                echo '</span>';
            echo '</p>';
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

    public function is_expired( $datetime = null ) {
        $current_time = strtotime( current_time( 'Y-m-d H:i' ) );

        if ( $datetime ) {
            $datetime = strtotime( $datetime );
            return $datetime >= $current_time ? false : true;

        } else {

            return false;
        }
    }
}