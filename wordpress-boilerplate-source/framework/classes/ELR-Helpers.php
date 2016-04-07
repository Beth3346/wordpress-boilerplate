<?php

class ELR_Helpers {
    public function is_blog_page() {
        if ( is_front_page() && is_home() ) {
            return true;
        } elseif ( is_front_page() ) {
            return false;
        } elseif ( is_home() ) {
            return true;
        } else {
            return false;
        }
    }

    public function slugify($str) {
        return str_replace(' ', '-', strtolower($str));
    }

}