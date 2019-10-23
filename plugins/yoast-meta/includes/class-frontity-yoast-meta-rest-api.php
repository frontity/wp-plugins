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
	 * @var     \WP_Query
	 */
	private $old_wp_query;

	/**
	 * Variable to store the original WP The Query object (needed to restore it).
	 *
	 * @access  private
	 * @var     \WP_Query
	 */
	private $old_wp_the_query;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {

		$this->register_rest_prepare_hooks();

		add_action( 'rest_api_init', 'wpseo_frontend_head_init' );
		register_rest_field(
			'type',
			'new',
			array(
				'get_callback' => function () {
					return 'hi';
				},
			)
		);
	}

	/**
	 * Add the Yoast meta data to the WP REST output
	 *
	 * @access  public
	 *
	 * @param WP_REST_Response $response The response object.
	 * @param WP_Post          $post Post object.
	 * @param WP_REST_Request  $request Request object.
	 *
	 * @return  WP_REST_Response
	 */
	public function rest_add_yoast( $response, $post, $request ) {

		$yoast_data = $this->get_yoast_data( $post );

		$yoast_meta    = apply_filters( 'wp_rest_yoast_meta_filter_yoast_meta', $yoast_data['meta'] );
		$yoast_json_ld = apply_filters( 'wp_rest_yoast_meta_filter_yoast_json_ld', $yoast_data['json_ld'] );

		$response->data['yoast_meta']    = $yoast_meta;
		$response->data['yoast_json_ld'] = $yoast_json_ld;

		return $response;
	}


	/**
	 * Fetch yoast meta and possibly json ld and store in transient if needed
	 *
	 * @param WP_Post $post Post object.
	 *
	 * @return array|mixed
	 */
	public function get_yoast_data( $post ) {
		$this->setup_postdata_and_wp_query( $post );

		// Add missing opengraph hooks.
		if ( is_singular() && ! is_front_page() ) {
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'article_author_facebook' ), 15 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'tags' ), 16 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'category' ), 17 );
			add_action( 'wpseo_opengraph', array( $GLOBALS['wpseo_og'], 'publish_date' ), 19 );
		}

		ob_start();
		do_action( 'wp_head' );
		$html = ob_get_clean();
		$html = html_entity_decode( $html ); // Replaces &hellip; to ...
		$html = preg_replace( '/&(?!#?[a-z0-9]+;)/', '&amp;', $html ); // Replaces & to '&amp;.

		$this->reset_postdata_and_wp_query();

		// Parse the xml to create an array of meta items.
		$yoast_data = $this->parse( $html );

		return $yoast_data;
	}


	/**
	 * Parse HTML to an array of meta key/value pairs using DOMDocument.
	 *
	 * @param string $html The HTML as generated by Yoast SEO.
	 *
	 * @return array An array containing all meta key/value pairs.
	 */
	private function parse( $html ) {
		$dom = new DOMDocument();

		$internal_errors = libxml_use_internal_errors( true );
		$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );

		$metas       = $dom->getElementsByTagName( 'meta' );
		$yoast_metas = array();
		foreach ( $metas as $meta ) {
			if ( $meta->hasAttributes() ) {
				$yoast_meta = array();
				foreach ( $meta->attributes as $attr ) {
				// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					$yoast_meta[ $attr->nodeName ] = $attr->nodeValue;
				}
				$yoast_metas[] = $yoast_meta;
			}
		}

		$xpath         = new DOMXPath( $dom );
		$yoast_json_ld = array();
		foreach ( $xpath->query( '//script[@type="application/ld+json"]' ) as $node ) {
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$yoast_json_ld[] = json_decode( (string) $node->nodeValue, true );
		}
		libxml_use_internal_errors( $internal_errors );

		return array(
			'meta'    => $yoast_metas,
			'json_ld' => $yoast_json_ld,
		);
	}

	/**
	 * Temporary set up postdata and wp_query to represent the current post (so Yoast will process it correctly)
	 *
	 * @param WP_Post $post Post object.
	 *
	 * @access private
	 */
	private function setup_postdata_and_wp_query( $post ) {
		global $wp_query, $wp_the_query;

		setup_postdata( $post );

		// Store current values.
		$this->old_wp_query     = $wp_query;
		$this->old_wp_the_query = $wp_the_query;

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_query = new WP_Query(
			array(
				'p'         => $post->ID,
				'post_type' => $post->post_type,
			)
		);

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_the_query = $wp_query;
	}

	/**
	 * Reset postdata and wp_query to previous values.
	 *
	 * @access  private
	 */
	private function reset_postdata_and_wp_query() {
		global $wp_query, $wp_the_query;

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_query = $this->old_wp_query;
		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$wp_the_query = $this->old_wp_the_query;
		wp_reset_postdata();
	}

	/**
	 * Register `rest_prepare_{$post_type}` hooks for all post types visible in REST API.
	 */
	public function register_rest_prepare_hooks() {
		foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
			add_filter( 'rest_prepare_' . $post_type->name, array( $this, 'rest_add_yoast' ), 10, 3 );
		}
	}
}