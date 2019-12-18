<?php
/**
 * File class-frontity-plugin-one.php
 *
 * @package Frontity_Plugin_One
 */

/**
 * The plugin entry point.
 *
 * Load all dependencies and setup everything. Extends the class Frontity_Plugin.
 */
class Frontity_Plugin_One extends Frontity_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plugin_namespace' => 'pluginOne',
				'plugin_title'     => 'Plugin One by Frontity',
				'menu_title'       => 'Plugin One',
				'menu_slug'        => 'frontity-plugin-one',
				'script'           => 'frontity_plugin_one_admin_js',
				'enable_param'     => 'plugin_one',
				'option'           => 'frontity_plugin_one_settings',
				'version'          => FRONTITY_PLUGIN_ONE_VERSION,
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
		delete_option( 'frontity_plugin_one_settings' );
	}
}
