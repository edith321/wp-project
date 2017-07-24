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

function dwwp_list_job_by_location( $atts, $content = null) {

    if(!isset($atts['location'])) {
        return '<p class="job-error">You must provide a location for this shortcode to work</p>';
    }
    $atts = shortcode_atts( array(
        'title' => 'Current Job Openings in',
        'count' => 5,
        'location' => '',
        'pagination' => false, // here we made, that user can choose by himself whether he wants to paginate
    ), $atts );

    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type'     => 'job',
        'post_status'   => 'publish', // only published posts
        'no_found_rows' => $atts['pagination'], // here we made, that user can choose by himself whether he wants to paginate
        'posts_per_page'=> $atts['count'],
        'paged'         => $paged,
        'tax_query'     => array( // multidimensional array setup
            array(
                'taxonomy' => 'location',
                'field'    => 'slug',
                'terms'    => $atts['location'], // we allow the user to determine this
            ),
        )
    );

    $jobs_by_location = new WP_Query($args); // $jobs_by.. - just a given name

    if($jobs_by_location->have_posts()) :
        $location = str_replace('_', ' ', $atts['location']);

        $display_by_location = '<div id="jobs-by-location">';
        $display_by_location .= '<h4>' . esc_html__($atts['title']) . '&nbsp' . esc_html__(ucwords($location)) . '</h4>'; // ucwords() - first letter uppercase
        $display_by_location .= '<ul>';

        while($jobs_by_location->have_posts()) : $jobs_by_location->the_post();  // while we have posts we want to do smthng,  have_posts()/the_post() - wp functions
            global $post; // this var exists in wp

            $deadline = get_post_meta(get_the_ID(), 'aplication_deadline', true); // our fields are being saved as post meta, so if we want to get them, we need get_post_meta() - wp function
            $title = get_the_title();
            $slug = get_permalink();
            $display_by_location .= '<li class="job-listing">';
            $display_by_location .= sprintf( '<a href="%s">%s</a>&nbsp&nbsp', esc_url( $slug ), esc_html__( $title ) );
            $display_by_location .= '<span>' . esc_html( $deadline ) . '</span>'; // will output deadline date
            $display_by_location .= '</li>';

            endwhile;
        $display_by_location .= '</ul>';
        $display_by_location .= '</div>';

    endif;

    wp_reset_postdata();

    return $display_by_location;

}
add_shortcode('jobs_by_location', 'dwwp_list_job_by_location');