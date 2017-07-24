<?php
/*function dwwp_sample_shortcode($atts, $content = null) { // $atts - you can pass some values from the front end to the function (title, src), $content - when shortcodes are used as open and close tags and you can put content inside
    //return "this is my shortcode"; // shortcodes can't echo, only return!!!, can't output pure html (closing php tags), only as a string with return

    $atts = shortcode_atts(
      array(
        'title' => 'Default title',
        'src' => 'www.google.lt'
      ), $atts
    );
    return '<h1>' . $atts['title'] . '</h1>';
}

add_shortcode('job_listing', 'dwwp_sample_shortcode');*/ // first - name of your shortcode, you come up withit

function dwwp_job_taxonomy_list($atts, $content = null )
{

    $atts = shortcode_atts(
        array(
            'title' => 'Current job openings in...'
        ), $atts
    );
    $locations = get_terms('location'); // returns array with locations that have a post associated with
    if(! empty($locations) && ! is_wp_error($locations)) { // if there are locations and there are no errors excecute the code
        $displayList = '<div id="job-taxonomy-list">';
        $displayList .= '<h4>'. esc_html__($atts['title']) . '</h4>'; // esc_html__() - with a double underscore also localizes the text (ability to translate)
        $displayList .= '<ul>';// .= - works as $displayList + <h4.....  , so the h4 would be add at the end of <div...
        foreach($locations as $location) {
            $displayList .= '<li class="job-location">';
            $displayList .= '<a href="'. esc_url(get_term_link($location)) .'">'; // wp - function creates a link from a termid, which we take from the loop
            $displayList .= esc_html__($location->name) . '</a></li>';
        }
        $displayList .= '</ul></div>';
    }
    return $displayList;
}
add_shortcode('job_location_list', "dwwp_job_taxonomy_list");