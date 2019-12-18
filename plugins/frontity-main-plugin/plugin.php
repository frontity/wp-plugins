<?php
/**
 * Plugin Name: Frontity
 * Description: A set of WordPress enchancement to improve the integration with the Frontity Framework
 * Plugin URI: http://github.com/frontity/wp-plugins
 * Version: 1.0.0
 * 
 * Author: Frontity
 * Author URI: https://frontity.org
 * Text Domain: frontity
 * 
 * License: GPLv3
 * Copyright: Worona Labs SL
 * 
 * @package Frontity
 */

define( 'FRONTITY_MAIN_VERSION', '0.0.1' );
define( 'FRONTITY_MAIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'FRONTITY_MAIN_URL', plugin_dir_url( __FILE__ ) );

require_once FRONTITY_MAIN_PATH . 'require-dev.php';


// Creates the plugin instances and set activation / deactivation hooks.
Frontity_Main_Plugin::install(
	array(
		'Frontity_Headtags_Plugin',
		'Frontity_Plugin_One',
		'Frontity_Plugin_Two',
	)
);

// To be run when the plugin is uninstalled.
register_uninstall_hook( __FILE__, 'Frontity_Main_Plugin::uninstall' );
