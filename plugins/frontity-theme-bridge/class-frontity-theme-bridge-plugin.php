<?php
/**
 * File class-frontity-theme-bridge-plugin.php
 *
 * @package Frontity_Theme_Bridge_Plugin
 */

/**
 * The plugin entry point.
 *
 * Load all dependencies and setup everything. Extends the class Frontity_Plugin.
 */
class Frontity_Theme_Bridge_Plugin extends Frontity_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plugin_namespace' => 'themeBridge',
				'plugin_title'     => 'Frontity Theme Bridge',
				'menu_title'       => 'Theme Bridge',
				'menu_slug'        => 'frontity-theme-bridge',
				'script'           => 'frontity_theme_bridge_admin_js',
				'enable_param'     => 'theme_bridge',
				'option'           => 'frontity_theme_bridge_settings',
				'default_settings' => array( 
					'isEnabled' => true,
					'value'     => 1, 
				),
			)
		);
	}

	/**
	 * Function to be executed when uninstalling the plugin.
	 */
	public static function uninstall() {
		// Remove settings.
		delete_option( 'frontity_theme_bridge_settings' );
	}
}
