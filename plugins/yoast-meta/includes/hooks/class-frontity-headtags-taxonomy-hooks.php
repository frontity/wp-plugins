<?php
/**
 * File class-frontity-headtags-taxonomy-hooks.php
 *
 * @package Frontity_Headtags.
 */

/**
 * Class with REST API hooks for taxonomies.
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
	 * @param Frontity_Headtags $frontity_headtags Main class instance.
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
		add_action( 'edited_term', array( $this, 'purge_headtags' ), 10, 3 );
		add_action( 'delete_term', array( $this, 'purge_headtags' ), 10, 3 );
	}


	/**
	 * Get head tags for this taxonomy.
	 *
	 * @param mixed $taxonomy Taxonomy object.
	 */
	public function get_headtags( $taxonomy ) {
		$slug = $taxonomy['taxonomy'];
		$id   = $taxonomy['id'];

		// Build key with the variables above.
		$key   = "{$slug}_{$id}";
		$query = array();

		if ( 'category' === $slug ) {
			$query['cat'] = $id;
		} elseif ( 'post_tag' === $slug ) {
			$query['tag_id'] = $id;
		} else {

		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			$query['tax_query'] = array(
				array(
					'taxonomy' => $slug,
					'terms'    => $id,
				),
			);
		}

		// Return the head tags.
		return $this->frontity_headtags->get_headtags( $key, $query );
	}

	/**
	 * Remove head tags from cache.
	 *
	 * @param int    $term Term Id.
	 * @param int    $tt_id Term Taxonomy Id.
	 * @param string $taxonomy Taxonomy slug.
	 * @return bool True if deleted.
	 */
	public function purge_headtags( $term, $tt_id, $taxonomy ) {
		$key = "{$taxonomy}_{$term}";

		return $this->frontity_headtags->delete_cached_headtags( $key );
	}
}
