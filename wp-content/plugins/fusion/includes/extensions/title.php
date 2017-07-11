<?php
/**
 * Title Extension.
 *
 * Function for adding title element to Fusion
 *
 * @since 1.0.0
 */

/**
 * Map Shortcode
 */
add_action('init', 'fsn_init_add_title', 12);
function fsn_init_add_title() {

    if (function_exists('fsn_map')) {

        fsn_map(array(
            'name' => __('Title', 'fusion'),
            'shortcode_tag' => 'fsn_title',
            'description' => __('Easy way to add title to the page', 'fusion'),
            'icon' => 'text_fields',
            'params' => array(
                array(
                'type' => 'text',
                'param_name' => 'title_text',
                'label' => __('Title-label', 'fusion'),
                'help' => __('Create title for your page easily', 'fusion'),
                'section' => 'general'
    )
            )
        ));
    }
}

/**
 * Output Shortcode
 */

//OUTPUT SHORTCODE
function fsn_add_title_shortcode($atts, $content) {
    extract(shortcode_atts(array(
        'title_text' => '',
    ), $atts));

    $output = '<div class="fsn-text '. fsn_style_params_class($atts) .'">';
    $output .= !empty($title_text) ? '<h5>'. esc_html($title_text): ':</h5>';
    $output .= '</div>';

    return $output;
}

add_shortcode( 'fsn_title', 'fsn_add_title_shortcode' );