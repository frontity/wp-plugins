<?php
/**
 * Frontity main plugin setup
 *
 * @package Frontity
 */

/**
 * Main Frontity Class
 */
class Main_Plugin {

	public static $plugin_store = 'main';
	public static $plugin_title = 'Main Plugin by Frontity';
	public static $menu_title   = 'Main Plugin';
	public static $menu_slug    = 'frontity-main-plugin';
	public static $settings     = 'frontity_main_plugin_settings';
	public static $script       = 'frontity_main_plugin_admin_js';

	function register_menu() {
		add_menu_page(
			'Main Plugin',
			'Main Plugin',
			'manage_options',
			'main-plugin',
			function () {
				global $frontity_plugin_classes;
				require_once FRONTITY_MAIN_PATH . 'admin/index.php';
			}
		);
	}

	function register_script( $hook ) {
		if ( 'toplevel_page_main-plugin' === $hook ) {
			wp_register_script(
				'frontity_main_admin_js',
				FRONTITY_MAIN_URL . 'admin/build/bundle.js',
				array(),
				FRONTITY_MAIN_VERSION,
				true
			);
			wp_enqueue_script( 'frontity_main_admin_js' );
		}
	}

	function run() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
	}
}
