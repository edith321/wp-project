<?php
function dwwp_sample_shortcode($atts, $content = null) { // $atts - you can pass some values from the front end to the function (title, src), $content - when shortcodes are used as open and close tags and you can put content inside
    //return "this is my shortcode"; // shortcodes can't echo, only return!!!, can't output pure html (closing php tags), only as a string with return

    $atts = shortcode_atts(
      array(
        'title' => 'Default title',
        'src' => 'www.google.lt'
      ), $atts
    );
    return '<h1>' . $atts['title'] . '</h1>';
}

add_shortcode('job_listing', 'dwwp_sample_shortcode'); // first - name of your shortcode, you come up withit