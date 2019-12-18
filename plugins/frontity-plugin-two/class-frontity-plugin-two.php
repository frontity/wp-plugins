<?php
/**
 * File class-frontity-plugin-two.php
 *
 * @package Frontity_Plugin_Two
 */

/**
 * The plugin entry point.
 *
 * Load all dependencies and setup everything. Extends the class Frontity_Plugin.
 */
class Frontity_Plugin_Two extends Frontity_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plugin_namespace' => 'pluginTwo',
				'plugin_title'     => 'Plugin Two by Frontity',
				'menu_title'       => 'Plugin Two',
				'menu_slug'        => 'frontity-plugin-two',
				'script'           => 'frontity_plugin_two_admin_js',
				'enable_param'     => 'plugin_two',
				'option'           => 'frontity_plugin_two_settings',
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
		delete_option( 'frontity_plugin_two_settings' );
	}
}
