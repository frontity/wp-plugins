<?php
/**
 * Plugin Name: REST API Head Tags by Frontity
 * Version: 0.0.1
 *
 * @package Frontity_Headtags
 */

define( 'FRONTITY_HEADTAGS_VERSION', '0.0.1' );

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '../../shared/class-frontity-plugin.php';
}

if ( ! class_exists( 'Frontity_Headtags_Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-frontity-headtags-plugin.php';
}

// Creates a plugin instance and set activation / deactivation hooks.
Frontity_Headtags_Plugin::install();

// To be run when the plugin is uninstalled.
register_uninstall_hook( __FILE__, 'Frontity_Headtags_Plugin::uninstall' );
