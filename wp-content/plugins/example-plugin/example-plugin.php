<?php
/*
Plugin Name: Example Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/ (jei yra)
Description: Kiekviena diena po naują sentenciją.
Version:     1.0
Author:      Edita Paulikaitė
Author URI:  https://developer.wordpress.org/ (jeigu yra)
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: example-plugin

Example Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Example Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Example Plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

function dwwp_remove_dashboard_widget(){
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // panaikinam naujienu widget'a, dashboarde, is kur screen? ir context?
}
add_action('wp_dashboard_setup', 'dwwp_remove_dashboard_widget');

function dwwp_add_google_link() {
    global $wp_admin_bar;
    // var_dump($wp_admin_bar); - pasiziurim egzistuojancius meniu punktus

    $wp_admin_bar->add_menu(array( // pridejom google analytics i virsutini toolbara
        'id' => 'google_analytics',
        'title' => 'Google Analytics',
        'href' => 'http://google.com/analytics'
    ));
}
add_action('wp_before_admin_bar_render', 'dwwp_add_google_link');