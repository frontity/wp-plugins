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

if ( ! class_exists( 'Frontity_Headtags_Plugin' ) ) {
	require_once FRONTITY_HEADTAGS_PATH . 'class-frontity-plugin.php';
	require_once FRONTITY_HEADTAGS_PATH . 'class-frontity-headtags-plugin.php';
}

$frontity_headtags_plugin = new Frontity_Headtags_Plugin();

add_action( 'init', array( $frontity_headtags_plugin, 'should_run' ) );

register_activation_hook( __FILE__, array( $frontity_headtags_plugin, 'activate' ) );
register_deactivation_hook( __FILE__, array( $frontity_headtags_plugin, 'deactivate' ) );


// To be run when the plugin is uninstalled.
register_uninstall_hook(
	__FILE__,
	function() {
		// Remove settings.
		delete_option( 'frontity_headtags_settings' );

		// Remove all transients.
		$transient_list = get_option( 'frontity_headtags_transients', array() );
		foreach ( $transient_list as $transient ) {
			delete_transient( $transient );
		}

		// Remove transients option.
		delete_option( 'frontity_headtags_transients' );
	}
);
