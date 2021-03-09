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
class Frontity_Headtags_AIOSEO_3 {
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
		if ( ! defined( 'AIOSEOP_UNIT_TESTING' ) ) {
			// This constant allows $aioseop->wp_head() to be executed more than once.
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound
			define( 'AIOSEOP_UNIT_TESTING', true );
		}

		// Run AIOSEOP logic.
		// This code is based on the `template_redirect` method of the
		// `All_in_One_SEO_Pack` class (aioseop_class.php).
		global $aiosp, $aioseop_options;

		// Change title if page is included.
		$aiosp->get_queried_object();
		if ( $aiosp->is_page_included() ) {
			// Get `force_rewrites` value from AIOSEOP options.
			$force_rewrites = isset( $aioseop_options['aiosp_force_rewrites'] )
				? $aioseop_options['aiosp_force_rewrites']
				: 1;
	
			// Add the appropriate filter to change the title.
			if ( $force_rewrites ) {
				// NOTE: the AIOSEOP plugin uses `ob_start` in this line, passing a 
				// callback that replaces the title at the end of the PHP call.
				// Here, that callback is passed to a filter that runs when the <head>
				// content is computed.
				add_filter( 'frontity_headtags_html', array( $aiosp, 'rewrite_title' ) );
			} else {
				add_filter( 'wp_title', array( $aiosp, 'wp_title' ), 20 );
			}
		}

		// The WP Query has changed at this moment, we can check if it's for an author.
		global $wp_query;

		// Add the ld+json tag filter just for authors.
		// This property is not being generated well so it's being removed.
		if ( $wp_query->is_author ) {
			add_filter( 'frontity_headtags_result', array( $this, 'filter_ldjson' ) );
		}
	}

	/**
	 * Reset function.
	 */
	public function reset() {
		// Remove AIOSEOP filters (if they were added).
		global $aiosp;
		remove_filter( 'frontity_headtags_html', array( $aiosp, 'rewrite_title' ) );
		remove_filter( 'wp_title', array( $aiosp, 'wp_title' ), 20 );

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
