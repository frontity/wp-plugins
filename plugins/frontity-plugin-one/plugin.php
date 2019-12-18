<?php
/**
 * Plugin Name: Plugin One (example) by Frontity
 * Version: 0.0.1
 *
 * @package Frontity_Plugin_One
 */

define( 'FRONTITY_PLUGIN_ONE_VERSION', '0.0.1' );

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '../../shared/class-frontity-plugin.php';
}

if ( ! class_exists( 'Frontity_Plugin_One' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-frontity-plugin-one.php';
}

// Creates a plugin instance and set activation / deactivation hooks.
Frontity_Plugin_One::install();

// To be run when the plugin is uninstalled.
register_uninstall_hook( __FILE__, 'Frontity_Plugin_One::uninstall' );
