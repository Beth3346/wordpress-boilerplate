<?php

namespace Framework\Helpers;
use Framework\Helpers\Utility;

class File
{

    /**
     *
     *
     * @since  1.0.0
     * @access public
     * @param
     * @return void
     */

    public function customTemplateInclude($template)
    {
        $utility = new Utility;
        $custom_template_location = '/archives/';
        $cpt_tmp = NULL;
        if ($utility->isCptArchive()) {
            if (is_archive() && !is_tax()) {
                $cpt_tmp = get_stylesheet_directory() . $custom_template_location . 'archive-' . get_post_type() . '.php';
            } else if (is_single()) {
                $cpt_tmp = get_stylesheet_directory() . $custom_template_location . 'single-' . get_post_type() . '.php';
            }

            if (file_exists($cpt_tmp)) {
                return $cpt_tmp;
            }
        }
        return $template;
    }
}