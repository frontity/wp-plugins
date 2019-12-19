<?php
/**
 * File class-frontity-headtags-author-hooks.php
 *
 * @package Frontity_Headtags.
 */

/**
 * Class with REST API hooks for authors.
 */
class Frontity_Headtags_Author_Hooks {

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
	 * Register hooks for authors.
	 */
	public function register_rest_hooks() {
		// Register rest field.
		$field_callbacks = array( 'get_callback' => array( $this, 'get_headtags' ) );
		register_rest_field( 'user', 'head_tags', $field_callbacks );
	}

	/**
	 * Register hooks for authors.
	 */
	public function register_admin_hooks() {
		add_action( 'profile_update', array( $this, 'purge_headtags' ) );
		add_action( 'delete_user', array( $this, 'purge_headtags' ) );
	}


	/**
	 * Get head tags for this author.
	 *
	 * @param mixed $author Author object.
	 */
	public function get_headtags( $author ) {
		$key   = "author_{$author['id']}";
		$query = array( 'author' => $author['id'] );

		// Return the head tags.
		return $this->frontity_headtags->get_headtags( $key, $query );
	}

	/**
	 * Remove head tags from cache.
	 *
	 * @param string $id User id.
	 * @return bool True if deleted.
	 */
	public function purge_headtags( $id ) {
		$key = "author_$id";

		return $this->frontity_headtags->delete_cached_headtags( $key );
	}
}
