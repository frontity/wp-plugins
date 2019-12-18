<?php
/**
 * Frontity main plugin setup
 *
 * @package Frontity
 */

/**
 * Main Frontity Class
 */
class Frontity_Main_Plugin {
	/**
	 * Static property with the list of plugin classes.
	 * 
	 * This one needs to be static because is used in the `uninstall`
	 * static method.
	 * 
	 * @var array $plugin_classes List of class names.
	 */
	private static $plugin_classes;

	/**
	 * Object with all the plugin information.
	 *
	 * This variable is used when initializing the plugin. It contains:
	 *   $props['plugin_namespace']
	 *   $props['plugin_title']
	 *   $props['menu_title']
	 *   $props['menu_slug']
	 *   $props['option']
	 *   $props['default_settings']
	 *   $props['script']
	 *   $props['enable_param']
	 *   $props['version']
	 *
	 * @var array $props An object containing the keys above.
	 */
	public $props = array(
		'plugin_namespace' => 'main',
		'plugin_title'     => 'Main Plugin by Frontity',
		'menu_title'       => 'Main Plugin',
		'menu_slug'        => 'frontity-main-plugin',
		'option'           => 'frontity_main_plugin_settings',
		'script'           => 'frontity_main_plugin_admin_js',
	);

	/**
	 * List of plugin instances (by class name).
	 * 
	 * @var array $plugins
	 */
	public $plugins = array();


	/** 
	 * Instantiate plugin and sub plugins.
	 */
	public function __construct() {
		foreach ( self::$plugin_classes as $plugin_class ) {
			$this->plugins[ $plugin_class ] = new $plugin_class();
		}
	}

	/** 
	 * Load and setup the plugin and sub plugins.
	 * 
	 * @param array $plugin_classes List of plugin classes names.
	 */
	public static function install( $plugin_classes ) {
		// Assign passed classes to private static variable.
		self::$plugin_classes = $plugin_classes;

		// Create an instance of this class and add `init` hook.
		$main_instance = new self();
		add_action( 'init', array( $main_instance, 'run' ) );
	
		// Register activation / deactivation hooks for the main plugin.
		register_activation_hook( __FILE__, array( $main_instance, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $main_instance, 'deactivate' ) );
	}
	
	
	/**
	 * Uninstall plugin.
	 */
	public static function uninstall() {
		// Remove settings for this plugin.
		delete_option( 'frontity_main_plugin_settings' );
	
		// Remove settings for the other plugins as well.
		foreach ( self::$plugin_classes as $plugin_class ) {
			$plugin_class::uninstall();
		};
	}

	/**
	 * Activate all sub plugins.
	 */
	public function activate() {
		foreach ( $this->$plugins as $plugin_class => $plugin_instance ) {
			$plugin_instance->activate();
		}
	}

	/**
	 * Deactivate all sub plugins.
	 */
	public function deactivate() {
		foreach ( $this->$plugins as $plugin_class => $plugin_instance ) {
			$plugin_instance->deactivate();
		}
	}

	/**
	 * Run the plugin.
	 */
	public function run() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );

		// Executes `run` method for all sub plugins.
		foreach ( $this->plugins as $plugin_class => $plugin_instance ) {
			$plugin_instance->run();
		}
	}

	/**
	 * Register menu.
	 */
	public function register_menu() {
		add_menu_page(
			$this->props['menu_title'],
			$this->props['menu_title'],
			'manage_options',
			$this->props['menu_slug'],
			array( $this, 'render_admin_page' )
		);
	}

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		$plugin_dir_url = FRONTITY_MAIN_URL;
		$loc            = get_locale();
		?>
<div id='root'></div>
<script>
	window.frontity = window.frontity || {
		locale: <?php echo wp_json_encode( $loc ? $loc : '' ); ?>,
		plugins: {}
	};
		<?php
		foreach ( $this->plugins as $plugin_class => $plugin_instance ) {
			$this->render_plugin_settings( $plugin_instance );
		}
		?>
</script>
		<?php
	}

	/**
	 * Render each plugin settings.
	 * 
	 * @param Frontity_Plugin $plugin_instance A Frontity Plugin instance.
	 */
	public function render_plugin_settings( $plugin_instance ) {
		// Get namespace from plugin.
		$namespace = $plugin_instance->props['plugin_namespace'];

		// Get settings from database.
		$settings         = get_option( $plugin_instance->props['option'] );
		$default_settings = $plugin_instance->props['default_settings'];

		// Create a json representation of the settings.
		$settings_json = array(
			'settings' => $settings ? $settings : new stdClass(),
		);

		// Render settings assign.
		?>
window.frontity.plugins[<?php echo wp_json_encode( $namespace ); ?>] = <?php echo wp_json_encode( $settings_json ); ?>;
		<?php
	}

	/**
	 * Register script.
	 * 
	 * @param string $hook The hook.
	 */
	public function register_script( $hook ) {
		if ( 'toplevel_page_frontity-main-plugin' === $hook ) {
			wp_register_script(
				'frontity_main_admin_js',
				FRONTITY_MAIN_URL . 'admin/build/bundle.js',
				array(),
				FRONTITY_MAIN_VERSION,
				true
			);
			wp_enqueue_script( 'frontity_main_admin_js' );
		}
	}
}

