<?php
/*
Plugin Name: Job Listing
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/ (jei yra)
Description: Plugin that lists jobs
Version:     1.0
Author:      Edita Paulikaitė
Author URI:  https://developer.wordpress.org/ (jeigu yra)
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: job-listing

Editos Pluginas is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Editos Pluginas is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Editos Pluginas. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


// Exit if accessed directly
if(!defined('ABSPATH')) {
    exit;
}
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
        'supports'               => array( // lists things you want to see in the post edit screen
            'title',
            'editor',
            'author',
            'custom-fields'
        )
        );
    register_post_type('job', $args);
}
add_action('init', 'dwwp_register_post_type');

function dwwp_register_taxonomy() {

        $args = array(
            'hierarchical'          => true,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array('slug' => 'location'),
        );
        register_taxonomy('location', 'job', $args);
}
add_action('init', 'dwwp_register_taxonomy');