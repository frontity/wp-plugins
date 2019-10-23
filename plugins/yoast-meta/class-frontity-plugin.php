<?php
/**
 * File containing an abstract class to create Frontity plugins.
 *
 * @package Frontity
 */

/**
 * Abstract class to create Frontity plugins
 *
 * This abstract class is an intent to avoid duplicating code. It implements
 * the basic behavior a plugin would need.
 */
abstract class Frontity_Plugin {

	/**
	 * Object with all the plugin information.
	 *
	 * This variable is used when initializing the plugin. It contains:
	 *   $description['plugin_namespace']
	 *   $description['plugin_title']
	 *   $description['menu_title']
	 *   $description['menu_slug']
	 *   $description['option']
	 *   $description['default_settings']
	 *   $description['script']
	 *   $description['enable_param']
	 *   $description['url']
	 *   $description['version']
	 *
	 * @var description An object containing the keys above.
	 */
	public $description;

	/**
	 * Constructor.
	 *
	 * @param string $description Object with all the plugin information.
	 */
	public function __construct( $description ) {
		$this->description = $description;
	}

	/**
	 * Get a value from description
	 *
	 * @param string $key The key.
	 * @return any The value.
	 */
	public function get( $key ) {
		return $this->description['$key'];
	}

	/**
	 * Method executed when the plugin is activated.
	 */
	public function activate() {
		$settings = get_option( $this->description['option'] );
		if ( ! $settings ) {
			update_option(
				$this->description['option'],
				$this->description['default_settings']
			);
		}
	}

	/**
	 * Method executed when the plugin is deactivated.
	 */
	public function deactivate() {
		delete_option( $this->description['option'] );
	}

	/**
	 * Method that returns if the plugin is "enabled" (do not confuse with activated).
	 *
	 * @return bool If the plugin is enabled or not.
	 */
	public function is_enabled(): bool {

		if ( isset( $_GET[ $this->description['enable_param'] ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			$is_enabled = sanitize_key( $_GET[ $this->description['enable_param'] ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			if ( 'true' === $is_enabled ) {
				return true;
			}

			if ( 'false' === $is_enabled ) {
				return false;
			}
		} else {
			$settings = get_option( $this->description['option'] );
			return (bool) $settings['isEnabled'];
		}
	}

	/**
	 * Method that executes "run" method if it should.
	 */
	public function should_run() {
		if ( ! class_exists( 'Main_Plugin' ) ) {
			add_action( 'admin_menu', array( $this, 'register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
			$this->run();
		} else {
			// Show admin notices.
			if ( class_exists( 'Main_Plugin' ) ) {
				add_action( 'admin_notices', array( $this, 'render_warning' ) );
			}
		};
	}

	/**
	 * Register menu page.
	 */
	public function register_menu() {
		add_options_page(
			$this->description['menu_title'],
			$this->description['menu_title'],
			'manage_options',
			$this->description['menu_slug'],
			function () {
				require_once plugin_dir_path( __FILE__ ) . 'admin/index.php';
			}
		);
	}

	/**
	 * Register scripts.
	 *
	 * @param string $hook The hook.
	 */
	public function register_script( $hook ) {
		if ( 'settings_page_' . $this->description['menu_slug'] === $hook ) {
			wp_register_script(
				$this->description['script'],
				$this->description['url'] . 'admin/build/bundle.js',
				array(),
				$this->description['version'],
				true
			);
			wp_enqueue_script( $this->description['script'] );
		}
	}

	/**
	 * Method to render warnings.
	 */
	public function render_warning() {
		if ( get_current_screen()->id === 'plugins' ) {
			echo '<div class="notice notice-warning">' .
			'<h2>' . esc_html( $this->description['plugin_title'] ) . '</h2>' .
			'<p>' .
			'We noticed that you have enabled <b>Main Plugin</b>, ' .
			'which includes <b>Yoast Meta</b>. ' .
			'</p>' .
			'<p>' .
			'You can safely uninstall this plugin and keep using its functionality from the <b>Main Plugin</b>' .
			'</p>' .
			'</div>';
		}
	}

	/**
	 * Save current settings into the database.
	 */
	public function save_settings() {
		if ( ! isset( $_POST['description'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			return;
		}

		$description = json_decode( stripslashes( $_POST['description'] ), true ); // phpcs:ignore
		if ( $description ) {
			update_option( $this->description['option'], $description );
		}
		wp_send_json( $description );
	}

	/**
	 * Execute the plugin.
	 */
	public function run() {
		add_action( 'wp_ajax_frontity_save_' . $this->description['option'], array( $this, 'save_settings' ) );
	}
}
