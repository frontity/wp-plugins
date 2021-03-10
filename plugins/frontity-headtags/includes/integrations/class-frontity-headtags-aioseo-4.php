<?php

/**
 * File class-frontity-headtags-aioseo.php
 *
 * @package Frontity_HeadTags.
 */

/**
 * Class that integrates All In One SEO Pack with this plugin.
 *
 * It adds hooks to the actions that Frontity_Headtags execute just after
 * replacing and restore the main wp_query.
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
		$parsedUrl = wp_parse_url( self::get_archive_url() );
		if ( $parsedUrl ) $wp->request = $parsedUrl['path'];
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		global $wp;

		// Restore the previous `request` value.
		$wp->request = $this->previous_wp_request;
	}

	/**
	 * Get the link of the current requested archive.
	 * 
	 * @return string|null
	 */
	public static function get_archive_url() {
		if ( is_archive() ) {
			$obj = get_queried_object();

			if ( is_category() ) return get_category_link( $obj );
			if ( is_tag() )      return get_tag_link( $obj );
			if ( is_tax() )      return get_term_link( $obj );
			if ( is_author() )   return get_author_posts_url( $obj->id );
			if ( is_post_type_archive() )
			  return get_post_type_archive_link( $obj->name );
		}

		// Return `null` for any other case.
		return null;
	}
}