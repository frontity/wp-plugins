<?php
/**
 * File class-frontity-headtags-filters.php
 *
 * @package Frontity_Headtags
 */

/**
 * Head tags filters.
 *
 * It adds hooks to the actions that Frontity_Headtags execute just after replacing and restore
 * the main wp_query .
 */
class Frontity_Headtags_Filters {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'frontity_headtags_result', array( $this, 'filter_javascript' ) );
		add_filter( 'frontity_headtags_result', array( $this, 'filter_styles' ) );
	}

	/**
	 * Filter JavaScript tags.
	 *
	 * @param array $headtags All the <head> tags.
	 * @return array All the <head> tags that are not JavaScript tags.
	 */
	public function filter_javascript( $headtags ) {
		$filtered = array_filter( $headtags, array( $this, 'is_not_javascript' ) );
		return array_values( $filtered );
	}

	/**
	 * Check if it's JavaScript element.
	 *
	 * @param array $element Object representing a HTML element.
	 * @return bool TRUE if it is NOT a JavaScript script element.
	 */
	public function is_not_javascript( $element ) {
		$is_javascript = 'script' === $element['tag'] && (
			empty( $element['attributes'] ) ||
			empty( $element['attributes']['type'] ) ||
			in_array(
				$element['attributes']['type'],
				array( '', 'text/javascript', 'application/javascript' ),
				true
			)
		);
		return ! $is_javascript;
	}

	/**
	 * Filter style tags.
	 *
	 * @param array $headtags All the <head> tags.
	 * @return array All the <head> tags that are not styles.
	 */
	public function filter_styles( $headtags ) {
		$filtered = array_filter( $headtags, array( $this, 'is_not_style' ) );
		return array_values( $filtered );
	}

	/**
	 * Check if a tag is a <style> tag or a stylesheet.
	 *
	 * @param array $element Object representing a HTML element.
	 * @return bool TRUE if it is NOT a style tag or a stylesheet.
	 */
	public function is_not_style( $element ) {
		$is_style = 'style' === $element['tag'] || (
			'link' === $element['tag'] &&
			'stylesheet' === $element['attributes']['rel']
		);
		return ! $is_style;
	}
}
