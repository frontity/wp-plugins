<?php
/**
 * Plugin Name: REST API - Head Tags
 * Description: Adds all the meta tags of the head section to WordPress REST API responses, including the ones generated by SEO plugins like Yoast or All in One SEO.
 * Plugin URI: http://github.com/frontity/wp-plugins
 * Version: 1.1.1
 * 
 * Author: Frontity
 * Author URI: https://frontity.org
 * Text Domain: frontity
 * 
 * License: GPLv3
 * Copyright: Worona Labs SL
 * 
 * @package Frontity_Headtags
 */

define( 'FRONTITY_HEADTAGS_VERSION', '1.1.1' );

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
