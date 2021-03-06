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

/*$dir = plugin_dir_path(__File__);
var_dump($dir); -- see what does plugin_dir_path does
die();*/

require_once (plugin_dir_path(__File__) . 'wp-job-cpt.php'); // plugin_dir_path - makes sure that the file chosen is in the correct directory
require_once (plugin_dir_path(__File__) . 'wp-job-settings.php');
require_once (plugin_dir_path(__File__) . 'wp-job-fields.php');
require_once (plugin_dir_path(__File__) . 'wp-job-shortcode.php');

function dwwp_admin_enqueue_scripts() {
    global $pagenow, $typenow; // $pagenow - returns the file that is being rendered??, $typenow - returns post-type
    // we will be trying to load some scripts and css ONLY on a certain post-type (job) and ONLY when we are on a post-edit screen

    if($typenow == 'job') {
        wp_enqueue_style('dwwp-admin-css', plugins_url('css/admin-jobs.css', __FILE__)); // plugin_url - works like plugin_dir_path
    }
    if(($pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow == 'job') {
        wp_enqueue_script( 'dwwwp-job-js', plugins_url('js/admin-jobs.js',  __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), '20170717', true ); // in_footer - our script appears in the footer (faster loading), version - date, array(jquery) - we don't have to enqueue jquery separately, just have to tell wp that our new js file requires jquery
        wp_enqueue_script('dwwp-custom-quicktags', plugins_url('js/dwwp-quicktags.js', __FILE__ ), array('quicktags'), '20170717', true); //enqueuing quicktags (make text bold, italic etc.)
        wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
    }
    if($pagenow == 'edit.php' && $typenow == 'job'){
        wp_enqueue_script('reorder-js', plugins_url('js/reorder.js', __FILE__ ), array('jquery', 'jquery-ui-sortable'), '20170718', true); // list of handles https://developer.wordpress.org/reference/functions/wp_enqueue_script/
        wp_localize_script('reorder-js', 'WP_JOB_LISTING', array( //for safety, 'reorder-js' - has to be the handle that we mentioned in the line above, 'WP_JOB_LISTING'- just a variable name
            'security' => wp_create_nonce('wp-job-order'), //  'wp-job-order' - jus any name
            //'siteUrl' => get_bloginfo('url'), not necessary this time
            'success' => 'Job sort order has been saved',
            'failure' => 'There was an error saving or you dont have the permission',
        ));
    }
}
add_action('admin_enqueue_scripts', 'dwwp_admin_enqueue_scripts');


