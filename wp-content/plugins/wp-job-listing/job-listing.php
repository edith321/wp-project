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
    $args = array('public' => true, 'label' => 'Job Listing');
    register_post_type('job', $args);
}
add_action('init', 'dwwp_register_post_type');