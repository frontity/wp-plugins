<?php
/**
 * File class-frontity-headtags-plugin.php
 *
 * @package Frontity_Headtags_Plugin
 */

/**
 * The plugin entry point.
 *
 * Load all dependencies and setup everything. Extends the class Frontity_Plugin.
 */
class Frontity_Headtags_Plugin extends Frontity_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plugin_namespace' => 'headtags',
				'plugin_title'     => 'REST API - Head Tags',
				'menu_title'       => 'REST API - Head Tags',
				'menu_slug'        => 'frontity-headtags',
				'script'           => 'frontity_headtags_admin_js',
				'enable_param'     => 'head_tags',
				'option'           => 'frontity_headtags_settings',
				'default_settings' => array( 'isEnabled' => true ),
			)
		);
	}

	/**
	 * Overrides run function.
	 */
	public function run() {
		parent::run();

		$this->load_dependencies();
		$this->setup_hooks();
		$this->setup_integrations();
		$this->setup_filters();
	}

	/**
	 * Load all dependencies.
	 */
	public function load_dependencies() {
		// Directory name.
		$dirname = dirname( __FILE__ );
		// Main class.
		require_once "$dirname/includes/class-frontity-headtags.php";
		// Hooks.
		require_once "$dirname/includes/hooks/class-frontity-headtags-post-type-hooks.php";
		require_once "$dirname/includes/hooks/class-frontity-headtags-taxonomy-hooks.php";
		require_once "$dirname/includes/hooks/class-frontity-headtags-author-hooks.php";
		// Integrations.
		require_once "$dirname/includes/integrations/class-frontity-headtags-yoast.php";
		require_once "$dirname/includes/integrations/class-frontity-headtags-aioseo.php";
		// Filters.
		require_once "$dirname/includes/filters/class-frontity-headtags-filters.php";
	}

	/**
	 * Register all hooks.
	 */
	public function setup_hooks() {
		// Init main class.
		$headtags = new Frontity_Headtags();
		// Init classes.
		$post_types = new Frontity_Headtags_Post_Type_Hooks( $headtags );
		$taxonomies = new Frontity_Headtags_Taxonomy_Hooks( $headtags );
		$authors    = new Frontity_Headtags_Author_Hooks( $headtags );

		// Init hooks.
		if ( is_admin() ) {
			add_action( 'admin_init', array( $post_types, 'register_admin_hooks' ), 50 );
			add_action( 'admin_init', array( $taxonomies, 'register_admin_hooks' ), 50 );
			add_action( 'admin_init', array( $authors, 'register_admin_hooks' ), 50 );
		} elseif ( $this->is_enabled() ) {
			add_action( 'rest_api_init', array( $post_types, 'register_rest_hooks' ), 50 );
			add_action( 'rest_api_init', array( $taxonomies, 'register_rest_hooks' ), 50 );
			add_action( 'rest_api_init', array( $authors, 'register_rest_hooks' ), 50 );
		}

		// Add AJAX action hooks.
		add_action(
			'wp_ajax_frontity_headtags_clear_cache',
			'Frontity_Headtags_Plugin::clear_cache'
		);
	}

	/**
	 * Load integrations like Yoast, etc.
	 */
	public function setup_integrations() {
		// Setup Yoast integration.
		if ( class_exists( 'WPSEO_Frontend' ) ) {
			new Frontity_Headtags_Yoast();
		}
		// Setup All In One SEO Pack integration.
		if ( class_exists( 'All_in_One_SEO_Pack' ) ) {
			new Frontity_Headtags_AIOSEO();
		}
	}

	/**
	 * Add filters to 'frontity_headtags' hook.
	 */
	public function setup_filters() {
		new Frontity_Headtags_Filters();
	}

	/**
	 * Function that removes all cached head tags.
	 * 
	 * The function clears all the WordPress object cache as well.
	 * It runs when clicking a button in the admin panel or when 
	 * uninstalling the plugin so that's not a problem anyway.
	 *
	 * @return number|false
	 */
	public static function clear_cache() {
		// Get global variables.
		global $wpdb, $wp_object_cache;

		
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.NoCaching

		// Get transient names from database.
		$options = $wpdb->get_results( 
			$wpdb->prepare( 
				"SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s",
				'\_transient\_frontity\_headtags%'
			)
		);
		// phpcs:enable

		// Assume everything is going to be okay.
		$all_deleted = true;

		// Remove all transients.
		foreach ( $options as $option ) {
			$transient   = preg_replace( '/^_transient_/', '', $option->option_name );
			$all_deleted = $all_deleted && delete_transient( $transient );
		}

		// If it didn't failed removing a transient, return the number.
		return $all_deleted ? count( $options ) : false;
	}


	/**
	 * Function to be executed when uninstalling the plugin.
	 */
	public static function uninstall() {
		// Remove settings.
		delete_option( 'frontity_headtags_settings' );

		// Remove all transients.
		self::clear_cache();
	}
}
