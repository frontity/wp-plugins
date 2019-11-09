<?php
/**
 * Hooks for taxonomies.
 *
 * @package Frontity_HeadTags.
 */

/**
 * Class with hooks for taxonomies.
 */
class Frontity_Headtags_Taxonomy_Hooks {

	/**
	 * Main class instance.
	 *
	 * @var Frontity_Headtags $frontity_headtags Main class instance.
	 */
	private $frontity_headtags;

	/**
	 * Constructor.
	 *
	 * @param Frontity_Headtags $frontity_headtags Main class.
	 */
	public function __construct( $frontity_headtags ) {
		$this->frontity_headtags = $frontity_headtags;
	}

	/**
	 * Register hooks for taxonomies.
	 */
	public function register_rest_hooks() {
		foreach ( get_taxonomies( array( 'show_in_rest' => true ), 'objects' ) as $taxonomy ) {
			// Get taxonomy name (fixing it for tags).
			$taxonomy_name = 'post_tag' === $taxonomy->name ? 'tag' : $taxonomy->name;

			// Register rest field.
			$field_callbacks = array( 'get_callback' => array( $this, 'get_headtags' ) );
			register_rest_field( $taxonomy_name, 'headtags', $field_callbacks );
		}
	}

	/**
	 * Register hooks for taxonomies.
	 */
	public function register_admin_hooks() {
		foreach ( get_taxonomies( array( 'show_in_rest' => true ), 'objects' ) as $taxonomy ) {
			$taxonomy_name = 'post_tag' === $taxonomy->name ? 'tag' : $taxonomy->name;
			add_action( "edited_$taxonomy_name", array( $this, 'purge_headtags' ), 10, 2 );
			add_action( "deleted_$taxonomy_name", array( $this, 'purge_headtags' ) );
		}
	}


	/**
	 * For taxonomies.
	 *
	 * @param WP_Object $taxonomy Taxonomy object.
	 */
	public function get_headtags( $taxonomy ) {
		$key   = $taxonomy['taxonomy'] . '_' . $taxonomy['id'];
		$query = array();

		if ( 'category' === $taxonomy['taxonomy'] ) {
			$query['cat'] = $taxonomy['id'];
		} elseif ( 'post_tag' === $taxonomy['taxonomy'] ) {
			$query['tag_id'] = $taxonomy['id'];
		} else {

		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			$query['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy['taxonomy'],
					'terms'    => $taxonomy['id'],
				),
			);
		}

		// Return the head tags.
		return $this->frontity_headtags->get_headtags( $key, $query );
	}

	/**
	 * Add type to links.
	 *
	 * @param string $unknown Post type id.
	 * @return bool True if deleted.
	 */
	public function purge_headtags( $unknown ) {
		// TODO: check what comes from $unknown.
		return $this->frontity_headtags->delete_cached_headtags( $key );
	}
}
