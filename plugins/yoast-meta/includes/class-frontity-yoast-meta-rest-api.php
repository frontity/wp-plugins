<?php
/**
 * File description.
 *
 * @package Frontity_Yoast_Meta
 */

/**
 * Class that contains the main behavior.
 */
class Frontity_Yoast_Meta_Rest_Api {

	/**
	 * Variable to store the original WP Query object (needed to restore it).
	 *
	 * @access  private
	 * @var     array
	 */
	private $query_backup = array();

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'define_public_hooks' ) );
	}

	/**
	 * Register all hooks.
	 */
	public function define_public_hooks() {
		// Add head_tags field to all post types and embed type links.
		foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
			$this->register_rest_field( $post_type->name, 'get_post_type_head_tags' );

			// Add type only for posts or post types with archive.
			if ( 'post' === $post_type->name || $post_type->has_archive ) {
				add_filter( 'rest_prepare_' . $post_type->name, array( $this, 'add_type_to_links' ), 10 );
			}
		}

		// Add head_tags field to all taxonomies.
		foreach ( get_taxonomies( array( 'show_in_rest' => true ), 'objects' ) as $taxonomy ) {
			$taxonomy_name = 'post_tag' === $taxonomy->name ? 'tag' : $taxonomy->name;
			$this->register_rest_field( $taxonomy_name, 'get_taxonomy_head_tags' );
		}

		// Add head_tags field to types.
		$this->register_rest_field( 'type', 'get_archive_head_tags' );

		// Add head_tags field to authors.
		$this->register_rest_field( 'user', 'get_author_head_tags' );
	}

	/**
	 * Register rest fields for post types, taxonomies or types.
	 *
	 * @param string $object_type Post type object.
	 * @param string $callback Method to run in get_callback.
	 */
	public function register_rest_field( $object_type, $callback ) {
		register_rest_field(
			$object_type,
			'head_tags',
			array(
				'get_callback' => array( $this, $callback ),
			)
		);
	}

	/**
	 * Add type to links.
	 *
	 * @param WP_Response $response Post type object.
	 *
	 * @return WP_Response Modified response.
	 */
	public function add_type_to_links( $response ) {
		$type      = $response->data['type'];
		$types_url = rest_url( 'wp/v2/types/' . $type );

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
	 * For post type.
	 *
	 * @param WP_Object $post Post type object.
	 */
	public function get_post_type_head_tags( $post ) {
		return $this->get_head_tags(
			array(
				'p'         => $post['id'],
				'post_type' => $post['type'],
			)
		);
	}

	/**
	 * For taxonomy.
	 *
	 * @param WP_Object $taxonomy Post type object.
	 */
	public function get_taxonomy_head_tags( $taxonomy ) {
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
		return $this->get_head_tags( $query );
	}

	/**
	 * For archives.
	 *
	 * @param WP_Object $type Post type object.
	 */
	public function get_archive_head_tags( $type ) {
		$query_vars = array();

		// Add 'post_type' var only for types other than 'post'.
		if ( 'post' !== $type['slug'] ) {
			$query_vars['post_type'] = $type['slug'];
		}

		// Return the head tags.
		return $this->get_head_tags( $query_vars );
	}

	/**
	 * For authors.
	 *
	 * @param WP_Object $author Post type object.
	 */
	public function get_author_head_tags( $author ) {
		return $this->get_head_tags(
			array(
				'author' => $author['id'],
			)
		);
	}

	/**
	 * Fetch yoast meta and possibly json ld and store in transient if needed
	 *
	 * @param string|array $query_vars URL query string or array of vars.
	 * @return array|mixed
	 */
	public function get_head_tags( $query_vars ) {
		$this->backup_query();
		$this->replace_query( $query_vars );

		ob_start();
		do_action( 'wp_head' );
		$html = ob_get_clean();
		$html = html_entity_decode( $html ); // Replaces &hellip; to ...
		$html = preg_replace( '/&(?!#?[a-z0-9]+;)/', '&amp;', $html ); // Replaces & to '&amp;.

		// Parse the xml to create an array of meta items.
		$head_tags = $this->parse( $html );

		$this->restore_query();

		return $head_tags;
	}


	/**
	 * Parse HTML to an array of meta key/value pairs using DOMDocument.
	 *
	 * @param string $html The HTML as generated by Yoast SEO.
	 *
	 * @return array An array containing all meta key/value pairs.
	 */
	private function parse( $html ) {
		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

		$head_tags = array();

		$dom = new DOMDocument();
		$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
		$nodes = $dom->getElementsByTagName( 'head' )[0]->childNodes;
		foreach ( $nodes as $node ) {

			// Ignore comments, texts, etc.
			if ( get_class( $node ) !== 'DOMElement' ) {
				continue;
			}

			// Create the tag object.
			$head_tag = array(
				'tag' => $node->tagName,
			);

			// Add attributes.
			if ( $node->hasAttributes() ) {
				$head_tag['attributes'] = array();
				foreach ( $node->attributes as $attr ) {
					$head_tag['attributes'][ $attr->nodeName ] = $attr->nodeValue;
				}
			}

			// Add content.
			if ( '' !== $node->textContent ) {
				$head_tag['content'] = $node->textContent;
			}

			// Append this tag to response if valid.
			if ( ! (
				$this->is_javascript( $head_tag ) ||
				$this->is_style( $head_tag )
			) ) {
				$head_tags[] = $head_tag;
			}
		}

		return $head_tags;
		// phpcs:enable
	}

	/**
	 * Check if a tag is JavaScript tag.
	 *
	 * @param Array $head_tag Object with the tag data.
	 *
	 * @return bool TRUE if it's a JavaScript script tag.
	 */
	private function is_javascript( $head_tag ) {
		return 'script' === $head_tag['tag'] && (
			! isset( $head_tag['attributes'] ) ||
			! isset( $head_tag['attributes']['type'] ) ||
			( in_array(
				$head_tag['attributes']['type'],
				array( '', 'text/javascript', 'application/javascript' ),
				true
			) )
		);
	}

	/**
	 * Check if a tag is a style tag or a stylesheet.
	 *
	 * @param Array $head_tag Object with the tag data.
	 *
	 * @return bool TRUE if it's a style tag or a stylesheet.
	 */
	private function is_style( $head_tag ) {
		return 'style' === $head_tag['tag'] || (
			'link' === $head_tag['tag'] &&
			'stylesheet' === $head_tag['attributes']['rel']
		);
	}

	/**
	 * Backup current query.
	 *
	 * @access private
	 */
	private function backup_query() {
		global $wp_query, $wp_the_query;
		// Store current values.
		array_push(
			$this->query_backup,
			array(
				'wp_query'     => $wp_query,
				'wp_the_query' => $wp_the_query,
			)
		);

	}

	/**
	 * Replace current query by the given one.
	 *
	 * @param string|array $query_vars URL query string or array of vars.
	 * @access private
	 */
	private function replace_query( $query_vars ) {
		global $wp_query, $wp_the_query;

		// Create an emtpy query.
		$new_query = new WP_Query();

		// Query elements using $query_vars.
		$new_query->query( $query_vars );

		// If $query_vars is empty, that means it's the home query.
		if ( empty( $query_vars ) ) {
			$new_query->is_home = true;
		}

		// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_query     = $new_query;
		$wp_the_query = $new_query;
		// phpcs:enable

		// Init Yoast.
		// Add first actions.
		wpseo_frontend_head_init();
		// Add missing opengraph hooks.
		if ( is_singular() && ! is_front_page() ) {
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'article_author_facebook' ), 15 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'tags' ), 16 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'category' ), 17 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'publish_date' ), 19 );
		}
		// Create a new instance.
		WPSEO_Frontend::get_instance();
	}

	/**
	 * Reset postdata and wp_query to previous values.
	 *
	 * @access private
	 */
	private function restore_query() {
		global $wp_query, $wp_the_query;
		$backup = array_pop( $this->query_backup );
		// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_query     = $backup['wp_query'];
		$wp_the_query = $backup['wp_the_query'];
		// phpcs:enable
		wp_reset_postdata();

		// Create an action and move this to a hook?
		$wp_seo = WPSEO_Frontend::get_instance();
		// Remove wp_seo actions added to 'wp_head' hook.
		remove_action( 'wp_head', array( $wp_seo, 'front_page_specific_init' ), 0 );
		remove_action( 'wp_head', array( $wp_seo, 'head' ), 1 );

		// Remove all actions from WPSEO hooks.
		remove_all_actions( 'wpseo_head' );
		remove_all_actions( 'wpseo_json_ld' );
		remove_all_actions( 'wpseo_opengraph' );

		// Remove WPSEO_Twitter instance.
		WPSEO_Twitter::$instance = null;

		// Reset WPSEO plugin.
		$wp_seo->reset();
	}

}
