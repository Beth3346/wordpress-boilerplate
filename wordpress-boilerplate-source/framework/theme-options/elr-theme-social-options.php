<?php

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

/**
 * Provides default values for the Social Options.
 */
function elr_theme_default_social_options() {

    $defaults = array(
        'lasik_phone' => '',
        'medical_appt_phone' => '',
        'facebook_url' => '',
        'twitter_url' => '',
        'youtube_url' => ''
    );

    return apply_filters( 'elr_theme_default_social_options', $defaults );

} // end elr_theme_default_social_options

function elr_theme_intialize_social_options() {

    if( false == get_option( 'elr_theme_social_options' ) ) {
        add_option( 'elr_theme_social_options', apply_filters( 'elr_theme_default_social_options', elr_theme_default_social_options() ) );
    } // end if

    add_settings_section(
        'social_settings_section',            // ID used to identify this section and with which to register options
        __( 'Social Options', 'elr' ),        // Title to be displayed on the administration page
        'elr_social_options_callback',        // Callback used to render the description of the section
        'elr_theme_social_options'            // Page on which to add this section of options
    );

    add_settings_field(
        'lasik_phone',
        'Lasik Appointment Phone:',
        'elr_lasik_phone_callback',
        'elr_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'medical_appt_phone',
        'Medical Appointment Phone:',
        'elr_medical_appt_phone_callback',
        'elr_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'facebook_url',
        'Facebook URL:',
        'elr_facebook_url_callback',
        'elr_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'twitter_url',
        'Twitter URL:',
        'elr_twitter_url_callback',
        'elr_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'youtube_url',
        'YouTube URL:',
        'elr_youtube_url_callback',
        'elr_theme_social_options',
        'social_settings_section'
    );

    register_setting(
        'elr_theme_social_options',
        'elr_theme_social_options'
        //'elr_theme_validate_social_options'
    );

} // end elr_theme_intialize_social_options
add_action( 'admin_init', 'elr_theme_intialize_social_options' );

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the Social Options page.
 *
 * It's called from the 'elr_theme_intialize_social_options' function by being passed as a parameter
 * in the add_settings_section function.
 */

function elr_social_options_callback() {
    echo '<p>' . __( 'Provide social information for your business', 'elr' ) . '</p>';
} // end elr_social_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function renders the interface elements for toggling the visibility of the header element.
 *
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */

function elr_lasik_phone_callback() {

    // First, we read the social options collection
    $options = get_option( 'elr_theme_social_options' );

    if ( !empty( $options['lasik_phone'] ) ) {
        $value = $options['lasik_phone'];
    } else {
        $value = null;
    }

    // Render the output ?>
    <input
        type="tel"
        class="widefat"
        id="lasik_phone"
        placeholder="713-123-4567"
        name="elr_theme_social_options[lasik_phone]"
        value="<?php echo esc_attr( $value ); ?>"
    />

    <small>Provide your Facebook URL</small>

<?php }

function elr_medical_appt_phone_callback() {

    // First, we read the social options collection
    $options = get_option( 'elr_theme_social_options' );

    if ( !empty( $options['medical_appt_phone'] ) ) {
        $value = $options['medical_appt_phone'];
    } else {
        $value = null;
    }

    // Render the output ?>
    <input
        type="tel"
        class="widefat"
        id="medical_appt_phone"
        placeholder="713-123-4567"
        name="elr_theme_social_options[medical_appt_phone]"
        value="<?php echo esc_attr( $value ); ?>"
    />

    <small>Provide your Facebook URL</small>

<?php }

function elr_facebook_url_callback() {

    // First, we read the social options collection
    $options = get_option( 'elr_theme_social_options' );

    if ( !empty( $options['facebook_url'] ) ) {
        $value = $options['facebook_url'];
    } else {
        $value = null;
    }

    // Render the output ?>
    <input
        type="url"
        class="widefat"
        id="facebook_url"
        placeholder="Facebook URL"
        name="elr_theme_social_options[facebook_url]"
        value="<?php echo esc_attr( $value ); ?>"
    />

    <small>Provide your Facebook URL</small>

<?php }

function elr_twitter_url_callback() {

    // First, we read the social options collection
    $options = get_option( 'elr_theme_social_options' );

    if ( !empty( $options['twitter_url'] ) ) {
        $value = $options['twitter_url'];
    } else {
        $value = null;
    }

    // Render the output ?>

    <input
        type="url"
        class="widefat"
        id="twitter_url"
        placeholder="Twitter URL"
        name="elr_theme_social_options[twitter_url]"
        value="<?php echo esc_attr( $value ); ?>"
    />

    <small>Provide your Twitter URL</small>

<?php }

function elr_youtube_url_callback() {

    // First, we read the social options collection
    $options = get_option( 'elr_theme_social_options' );

    if ( !empty( $options['youtube_url'] ) ) {
        $value = $options['youtube_url'];
    } else {
        $value = null;
    }

    // Render the output ?>

    <input
        type="url"
        class="widefat"
        id="youtube_url"
        placeholder="YouTube URL"
        name="elr_theme_social_options[youtube_url]"
        value="<?php echo esc_attr( $value ); ?>"
    />

    <small>Provide your YouTube URL</small>

<?php }