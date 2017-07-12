<?php

function dwwp_add_custom_metabox() {
    add_meta_box(
        'dwwp_meta',
        'Job Listing',
        'dwwp_meta_callback', // what should fill the metabox
        null, // screens on which to show the box
        'normal', // where should metabox be (center or side)
        'core'// how high should the metabox be
    );
}
add_action('add_meta_boxes', 'dwwp_add_custom_metabox');

