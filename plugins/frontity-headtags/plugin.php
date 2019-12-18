<?php
/**
 * Plugin Name: REST API Head Tags by Frontity
 * Version: 0.1.0
 *
 * @package Frontity_Headtags
 */

define( 'FRONTITY_HEADTAGS_VERSION', '0.1.0' );
define( 'FRONTITY_HEADTAGS_PATH', plugin_dir_path( __FILE__ ) );
define( 'FRONTITY_HEADTAGS_URL', plugin_dir_url( __FILE__ ) );

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once FRONTITY_HEADTAGS_PATH . '../shared/class-frontity-plugin.php';
}

if ( ! class_exists( 'Frontity_Headtags_Plugin' ) ) {
	require_once FRONTITY_HEADTAGS_PATH . 'class-frontity-headtags-plugin.php';
}

// Creates a plugin instance and set activation / deactivation hooks.
Frontity_Headtags_Plugin::install();

// To be run when the plugin is uninstalled.
register_uninstall_hook( __FILE__, 'Frontity_Headtags_Plugin::uninstall' );
