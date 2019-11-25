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
		// Init Yoast.
		// Add first actions.
		wpseo_frontend_head_init();
		// Add missing opengraph hooks.
		if ( is_singular() && ! is_front_page() ) {
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'article_author_facebook' ), 15 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'tags' ), 16 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'category' ), 17 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'publish_date' ), 19 );
		}
		// Create a new instance.
		WPSEO_Frontend::get_instance();
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		// Create an action and move this to a hook?
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
