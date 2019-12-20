<?php
/**
 * File class-frontity-headtags-aioseo.php
 *
 * @package Frontity_HeadTags.
 */

/**
 * Class that integrates All In One SEO Pack with this plugin.
 *
 * It adds hooks to the actions that Frontity_Headtags execute just after replacing and restore
 * the main wp_query.
 */
class Frontity_Headtags_AIOSEO {
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
		// Create an instance and add hooks.
		$aiosp = new All_in_One_SEO_Pack();
		$aiosp->add_hooks();
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		// Do nothing at this moment.
	}
}
