<?php
function dwwp_register_post_type() {
    $singular = __('Job Listing');
    $plural = __('Job listings');

    $labels = array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'add_name'              => __('Add new'),
        'add_new_item'          => __('Add New ') . $singular,
        'edit'                  => __('Edit'),
        'edit_item'             => __('Edit ') . $singular,
        'new_item'              => __('New ') . $singular,
        'view'                  => __('View ') . $singular,
        'view_item'             => __('View ') . $singular,
        'search_item'           => __('Search ') . $plural,
        'parent'                => __('Parent ') . $singular,
        'not_found'             => __('No ') . $plural . __(' found'),
        'not_found_in_trash'    => __('No ') . $plural . __(' in Trash')
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true, // koks turetu buti matomumas sito plugino
        'publicly_queryable'    => true, // Whether queries for this post type can be performed from the front end.
        'exclude_from_search'   => false, // shoud this post type be shown in search results
        'show_in_nav_menus'     => true,  // will it be possible to add job listings to main menu
        'show_ui'               => true, // if set to false, the tag dissappears from dashboard and you are able to create a custom one
        'show_in_menu'          => true, //similar to show_ui
        'show_in_admin_bar'     => true, // when set to true, it is visible ir the top admin menu on +new tag
        'menu_position'         => 10, // controls where your post-type appears in the dashboard
        'menu_icon'             => 'dashicons-businessman', // set the icon for the dashboard tag - dashicon (already included in wp)
        // 'menu_icon' => get_stylesheet_directory_uri() . '/images/super-duper.png', --- custom menu item
        'can_export'            => true, // do you want this post-type to be exportable
        'delete_with_user'      => false, // true - when delete a user, its posts are also being deleted
        'hierarchical'          => false, // true - acts like a page, false - acts like a post
        'has_archive'           => true, // true - able use wp template for archive
        'query_var'             => true, // allows to change url, true - just use the custom value
        'capability_type'       => 'page', // who can have access to this custom post type, post - any user role have access, page - only admistrator and author
        'map_meta_cap'          => true, //
        // 'capabilities'       => array(), -- allows to create custom capabilities for user roles
        'rewrite'               => array(
            'slug'      => 'jobs', // sets permanent link .....lt/jobs/...
            'with_front'=> 'true', // priesdelis, jei yra toks naudojamas
            'pages'     => 'true', // easy pagination set up
            'feeds'     => true, // whether you want it to be in rss feed
        ),
        'supports'               => array( // list of metaboxes you want to see in the post edit screen (default metaboxes), custom ones will be added wth require/inculde
            'title' // we just need the title
           /* 'editor',
            'author',
            'custom-fields'*/
        )
    );
    register_post_type('job', $args);
}
add_action('init', 'dwwp_register_post_type');

function dwwp_register_taxonomy() {

    $plural = __('Locations');
    $singular = __('Location');
    $slug = str_replace( ' ', '_', strtolower( $singular ) );

    $labels = array (
        'name'                       => $plural,
        'singular_name'              => $singular,
        'search_items'               => __('Search ') . $plural,
        'popular_items'              => __('Popular ') . $plural,
        'all_items'                  => __('All ') . $plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit ') . $singular,
        'update_item'                => __('Update ') . $singular,
        'add_new_item'               => __('Add New ') . $singular,
        'new_item_name'              => __('New ') . $singular . __(' Name'),
        'separate_items_with_commas' => __('Separate ') . $plural . __(' with commas'),
        'add_or_remove_items'        => __('Add or remove ') . $plural,
        'choose_from_most_used'      => __('Choose from the most used ') . $plural,
        'not_found'                  => __('No ') . $plural . __(' found.'),
        'menu_name'                  => $plural,

    );

    $args = array(
        'hierarchical'          => true, // true - parent-child connections
        'labels'                => $labels,
        'show_ui'               => true, // if you can see in the dashboard
        'show_admin_column'     => true, // if you can see in the dashboard
        'update_count_callback' => '_update_post_term_count', //
        'query_var'             => true,
        'rewrite'               => array('slug' => $slug), // rewrite slug
    );
    register_taxonomy('location', 'job', $args);
}
add_action('init', 'dwwp_register_taxonomy');

function dwwp_load_templates($original_template) {

    if(get_query_var('post_type') !== 'job'){ // checking if the query post-type equals jobs, exit out of this function
        return;
    }
    if(is_archive() || is_search()) { // checking if we are on an archive or a search page
        if(file_exists(get_stylesheet_directory(). '/archive-job.php')) {
            return get_stylesheet_directory() . '/archive-job.php';
        } else {
            return plugin_dir_path(__FILE__) . 'templates/archive-job.php';
        }
    } else {
        if(file_exists(get_stylesheet_directory(). '/single-job.php')) {
            return get_stylesheet_directory() . '/single-job.php';
        } else {
            return plugin_dir_path(__FILE__) . 'templates/archive-job.php';
        }
    }
    return $original_template;
}
add_action('template_include', 'dwwp_load_templates'); // template_include - safest, best hook




