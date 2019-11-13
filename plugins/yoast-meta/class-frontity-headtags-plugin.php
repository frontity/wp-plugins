<?php
/**
 * File description.
 *
 * @package Frontity_Headtags_Plugin
 */

/**
 * The plugin class, you know.
 */
class Frontity_Headtags_Plugin extends Frontity_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plugin_namespace' => 'headtags',
				'plugin_title'     => 'REST API Head Tags by Frontity',
				'menu_title'       => 'Head Tags',
				'menu_slug'        => 'frontity-headtags',
				'script'           => 'frontity_headtags_admin_js',
				'enable_param'     => 'headtags',
				'option'           => 'frontity_headtags_settings',
				'default_settings' => array( 'isEnabled' => true ),
				'url'              => FRONTITY_HEADTAGS_URL,
				'version'          => FRONTITY_HEADTAGS_VERSION,
			)
		);
	}

	/**
	 * Overrides run function.
	 */
	public function run() {
		parent::run();

		if ( $this->is_enabled() ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-frontity-headtags.php';
			new Frontity_Headtags();
		}
	}
}
