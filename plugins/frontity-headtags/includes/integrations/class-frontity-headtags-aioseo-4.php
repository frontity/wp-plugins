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
class Frontity_Headtags_AIOSEO_4 {

	/**
	 * Store the previous `$wp->request` value.
	 */
	private $previous_wp_request = "";

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
		global $wp;
		$this->previous_wp_request = $wp->request;

		// Replace the `request` value with the expected path.

		$id = get_queried_object_id();
		$link = null;
		
		if ( is_singular() ) return;
		else if ( is_author() )   $link = get_author_posts_url( $id );
		else if ( is_category() ) $link = get_category_link( $id );
		else if ( is_tag() )      $link = get_tag_link( $id );
		else if ( is_tax() )      $link = get_term_link( $id );

		$parsed = wp_parse_url( $link );
		if ( !$parsed ) return;
		
		$wp->request = $parsed['path'];
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		global $wp;
		$wp->request = $this->previous_wp_request;
	}
}