<?php
/**
 * File class-frontity-headtags-yoast.php
 *
 * @package Frontity_HeadTags.
 */

/**
 * Class that integrates Yoast with this plugin.
 *
 * It adds hooks to the actions that Frontity_Headtags execute just after replacing and restore
 * the main wp_query.
 */
class Frontity_Headtags_Yoast {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'frontity_headtags_replace_query', array( $this, 'setup' ) );
		add_action( 'frontity_headtags_restore_query', array( $this, 'reset' ) );
	}

	/**
	 * Setup function.
	 */
	public function setup() {
		// Create a new instance of WPSEO_Frontend if it's not created yet.
		WPSEO_Frontend::get_instance();

		// Call Yoast init function.
		wpseo_frontend_head_init();
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		// Get current instance.
		$wp_seo = WPSEO_Frontend::get_instance();
		// Remove wp_seo actions added to 'wp_head' hook.
		remove_action( 'wp_head', array( $wp_seo, 'front_page_specific_init' ), 0 );
		remove_action( 'wp_head', array( $wp_seo, 'head' ), 1 );

		// Remove all actions from WPSEO hooks.
		remove_all_actions( 'wpseo_head' );
		remove_all_actions( 'wpseo_json_ld' );
		remove_all_actions( 'wpseo_opengraph' );

		// Remove WPSEO_Twitter instance.
		WPSEO_Twitter::$instance = null;

		// Reset WPSEO plugin.
		$wp_seo->reset();
	}
}
