<?php
/**
 * Plugin Name: Plugin Two (example) by Frontity
 * Version: 0.0.1
 *
 * @package Frontity_Plugin_Two
 */

define( 'FRONTITY_PLUGIN_TWO_VERSION', '0.0.1' );

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '../../shared/class-frontity-plugin.php';
}

if ( ! class_exists( 'Frontity_Plugin_Two' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-frontity-plugin-two.php';
}

// Creates a plugin instance and set activation / deactivation hooks.
Frontity_Plugin_Two::install();

// To be run when the plugin is uninstalled.
register_uninstall_hook( __FILE__, 'Frontity_Plugin_Two::uninstall' );
