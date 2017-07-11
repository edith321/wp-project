<?php
/**
 * @package Fusion_Extension_Copyright
 */
/**
 * Plugin Name: Fusion : Extension - Copyright
 * Plugin URI: http://www.agencydominion.com/fusion/
 * Description: Copyright Extension Package for Fusion.
 * Version: 1.1.2
 * Author: Agency Dominion
 * Author URI: http://agencydominion.com
 * License: GPL2
 */
 
/**
 * FusionExtensionCopyright class.
 *
 * Class for initializing an instance of the Fusion Copyright Extension.
 *
 * @since 1.0.0
 */


class FusionExtensionCopyright	{ 
	public function __construct() {
						
		// Initialize the language files
		load_plugin_textdomain( 'fusion-extension-copyright', false, plugin_dir_url( __FILE__ ) . 'languages' );
		
	}
	
}

$fsn_extension_copyright = new FusionExtensionCopyright();

//EXTENSIONS

//copyright
require_once('includes/extensions/copyright.php');

?>