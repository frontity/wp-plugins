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

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound
		define( 'AIOSEOP_UNIT_TESTING', true );
	}

	/**
	 * Setup function.
	 */
	public function setup() {
		// The WP Query has changed at this moment, we can check if it's for an author.
		global $wp_query;

		// Add a filter just for authors.
		if ( $wp_query->is_author ) {
			add_filter( 'frontity_headtags_result', array( $this, 'filter_ldjson' ) );
		}
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		// Remove the ld+json filter if it was added.
		remove_filter( 'frontity_headtags_result', array( $this, 'filter_ldjson' ) );
	}

	/**
	 * Filter ld+json tags.
	 *
	 * @param array $headtags All the <head> tags.
	 * @return array All the <head> tags that are not ld+json tags.
	 */
	public function filter_ldjson( $headtags ) {
		$filtered = array_filter( $headtags, array( $this, 'is_not_ldjson' ) );
		return array_values( $filtered );
	}

	/**
	 * Check if a tag is a ld+json tag or a stylesheet.
	 *
	 * @param array $element Object representing a HTML element.
	 * @return bool TRUE if it is NOT a ld+json tag.
	 */
	public function is_not_ldjson( $element ) {
		$is_ldjson = 'script' === $element['tag'] && in_array(
			$element['attributes']['type'],
			array( '', 'text/ld+json', 'application/ld+json' ),
			true
		);

		return ! $is_ldjson;
	}
}
