<?php
/**
 * Plugin Name: Theme Bridge
 * Description: Substitute your theme with the response of an external server.
 * Plugin URI: 
 * Version: 0.0.1
 * 
 * Author: Frontity
 * Author URI: https://frontity.org
 * Text Domain: frontity
 * 
 * License: GPLv3
 * Copyright: Worona Labs SL
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

add_filter(
	'template_include',
	function( $template ) {
	  if (!isset($_GET['bypass']))
		return plugin_dir_path( __FILE__ ) . '/includes/template.php';
	  return $template;
	},
	PHP_INT_MAX
  );
