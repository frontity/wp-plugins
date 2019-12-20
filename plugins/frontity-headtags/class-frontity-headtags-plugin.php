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
				'plugin_title'     => 'REST API - Head Tags of SEO Plugins',
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
			$post_types->register_admin_hooks();
			$taxonomies->register_admin_hooks();
			$authors->register_admin_hooks();
		} elseif ( $this->is_enabled() ) {
			$post_types->register_rest_hooks();
			$taxonomies->register_rest_hooks();
			$authors->register_rest_hooks();
		}

		// Add AJAX action hooks.
		add_action( 'wp_ajax_frontity_headtags_clear_cache', array( $headtags, 'clear_cache' ) );
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
	 * Function to be executed when uninstalling the plugin.
	 */
	public static function uninstall() {
		// Remove settings.
		delete_option( 'frontity_headtags_settings' );

		// Remove all transients.
		$transient_list = get_option( 'frontity_headtags_transients', array() );
		foreach ( $transient_list as $transient ) {
			delete_transient( $transient );
		}

		// Remove transients option.
		delete_option( 'frontity_headtags_transients' );
	}
}
