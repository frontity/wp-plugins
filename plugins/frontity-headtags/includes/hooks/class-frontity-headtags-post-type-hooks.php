<?php
/**
 * File class-frontity-headtags-post-type-hooks.php
 *
 * @package Frontity_Headtags.
 */

/**
 * Class with REST API hooks for post types.
 */
class Frontity_Headtags_Post_Type_Hooks {

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
	 * Register hooks for post types.
	 */
	public function register_rest_hooks() {
		// Iterate over post types that are shown in the REST API.
		foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
			// 1. Add the post type's 'headtags' field.
			register_rest_field(
				$post_type->name,
				'head_tags',
				array(
					'get_callback' => array( $this, 'get_post_headtags' ),
				)
			);

			// 2. Embed type links only for 'post' or post types with archive.
			if ( 'post' === $post_type->name || $post_type->has_archive ) {
				add_filter( "rest_prepare_{$post_type->name}", array( $this, 'add_type_to_links' ), 10 );
			}
		}

		// 3. Add headtags field to types.
		register_rest_field(
			'type',
			'head_tags',
			array(
				'get_callback' => array( $this, 'get_archive_headtags' ),
			)
		);
	}

	/**
	 * Register hooks for post types.
	 */
	public function register_admin_hooks() {
		// Consider using save_post_{$post->post_type}
		// (see https://developer.wordpress.org/reference/hooks/save_post_post-post_type/).
		add_action( 'save_post', array( $this, 'purge_post_headtags' ) );
		add_action( 'delete_post', array( $this, 'purge_post_headtags' ) );
	}


	/**
	 * For post type.
	 *
	 * @param WP_Object $post Post type object.
	 */
	public function get_post_headtags( $post ) {
		// Get post type and id.
		$post_type = $post['type'];
		$post_id   = $post['id'];

		// Use them to create $key and $query vars.
		$key   = "{$post_type}_{$post_id}";
		$query = array(
			'post_type' => $post_type,
			'p'         => $post_id,
		);
		// Return the head tags.
		return $this->frontity_headtags->get_headtags( $key, $query );
	}

	/**
	 * For archives.
	 *
	 * @param WP_Object $type Post type object.
	 */
	public function get_archive_headtags( $type ) {
		$key   = 'archive_' . $type['slug'];
		$query = array();

		// Add 'post_type' var only for types other than 'post'.
		if ( 'post' !== $type['slug'] ) {
			$query['post_type'] = $type['slug'];
		}

		// Return the head tags.
		return $this->frontity_headtags->get_headtags( $key, $query );
	}

	/**
	 * Add type to links.
	 *
	 * @param WP_Response $response Post type object.
	 * @return WP_Response Modified response.
	 */
	public function add_type_to_links( $response ) {
		$type      = $response->data['type'];
		$types_url = rest_url( "wp/v2/types/$type" );

		$response->add_links(
			array(
				'type' => array(
					'href'       => $types_url,
					'embeddable' => true,
				),
			)
		);

		return $response;
	}

	/**
	 * Add type to links.
	 *
	 * @param string $post_id Post type id.
	 * @return bool True if deleted.
	 */
	public function purge_post_headtags( $post_id ) {
		$post_type = get_post_type( $post_id );
		$key       = "{$post_type}_{$post_id}";

		return $this->frontity_headtags->delete_cached_headtags( $key );
	}

	/**
	 * Add type to links.
	 *
	 * @param string $post_id Post type id.
	 * @return bool True if deleted.
	 */
	public function purge_archive_headtags( $post_id ) {
		$post_type = get_post_type( $post_id );
		$key       = "{$post_type}_{$post_id}";

		return $this->frontity_headtags->delete_cached_headtags( $key );
	}
}
