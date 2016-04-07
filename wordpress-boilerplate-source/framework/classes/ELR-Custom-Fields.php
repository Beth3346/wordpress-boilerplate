<?php

class ELR_Custom_Fields {
    public function meta_fields_register($fields) {

        foreach ($fields as $field) {
            register_meta('post', [$field]['id'], [$this, 'meta_fields_sanitize'], '__return_true');
        }
    }

    private function meta_fields_sanitize($meta_value) {
        // if meta key has url then sanitize url
        // if meta key has email then sanitize email
        return strip_tags($meta_value, '<a><span><strong><em><br><i><b>');
    }

    public function meta_box_save($post_id, $fields) {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        //security check - nonce
        if (isset($_POST['nonce']) && $_POST && !wp_verify_nonce($_POST['nonce'], __FILE__)) {
            return;
        }

        // if our current user can't edit this post, bail
        // if (!current_user_can('edit_item')) return;

        global $post;

        foreach ($fields as $field) {
            $id = $field['id'];
            if (isset($_POST[$id])) {
                update_post_meta($post_id, $id, $_POST[$id]);
            }
        }
    }

    public function meta_box_add($box_id, $box_title, $post_type, $fields) {
        global $post;

        add_meta_box(
            $box_id,
            $box_title,
            [$this, 'meta_box_cb'],
            $post_type,
            'normal',
            'high',
            ['fields' => $fields]
        );
    }

    private function meta_field_input($field) {
        global $post;
        $value = get_post_meta($post->ID, $field['id'], true);

        $label = '<label for="' . $field['id'] . '">' . $field['label'] . ': </label>';
        $input = '<input type="text" id="' . $field['id'] . '" name="' . $field['id'] . '"value="' . esc_attr($value) . '"class="widefat"/>';

        $meta_field = $label . $input;

        return $meta_field;
    }

    private function meta_field_select($field) {
        global $post;
        $value = get_post_meta($post->ID, $field['id'], true);

        $label = '<label for="' . $field['id'] . '">' . $field['label']. ': </label>';

        $select = '<select class="widefat" name="' . $field['id'] . '" id="' . $field['id'] . '">';

        // Create default value
        $select .= '<option value="">Choose ' . $field['label']. '</option>';

        foreach ($field['options'] as $option) {
            if ($value == $option) {
                $select .= '<option selected value="' . $option . '">' . $option . '</option>';
            } else {
                $select .= '<option value="' . $option . '">' . $option . '</option>';
            }
        }

        $select .= '</select>';

        $meta_field = $label . $select;

        return $meta_field;
    }

    private function meta_field_textarea($field) {
        global $post;
        $value = get_post_meta($post->ID, $field['id'], true);

        $label = '<label for="' . $field['id'] . '">' . $field['label'] . ': </label>';
        $input = '<textarea class="widefat" id="' . $field['id'] . '" name="' . $field['id'] . '">' . esc_attr($value) . '</textarea>';

        $meta_field = $label . $input;

        return $meta_field;
    }

    public function meta_box_cb($post, $fields) {
        wp_nonce_field(__FILE__, 'nonce');

        $inputs = '';

        foreach ($fields['args'] as $field => $values) {
            foreach ($values as $value) {
                $type = $value['type'];

                if ($type == 'textarea') {
                    echo $this->meta_field_textarea($value);
                } elseif ($type == 'select') {
                    echo $this->meta_field_select($value);
                } else {
                    echo $this->meta_field_input($value);
                }
            }
        }
    }
}