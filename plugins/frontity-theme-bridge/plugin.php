<?php
/**
 * Plugin Name: Frontity Theme Bridge
 * Version: 0.0.1
 *
 * @package Frontity_Theme_Bridge_Plugin
 */

define( 'FRONTITY_THEME_BRIDGE_PLUGIN', '0.0.1' );

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '../../shared/class-frontity-plugin.php';
}

if ( ! class_exists( 'Frontity_Theme_Bridge_Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-frontity-theme-bridge-plugin.php';
}

// Creates a plugin instance and set activation / deactivation hooks.
Frontity_Theme_Bridge_Plugin::install();

// To be run when the plugin is uninstalled.
register_uninstall_hook( __FILE__, 'Frontity_Theme_Bridge_Plugin::uninstall' );
