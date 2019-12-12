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
 * the basic behavior a plugin would need. This should be placed in a shared folder
 * in order to be used by other frontity plugins.
 */
abstract class Frontity_Plugin {

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
	 *   $props['url']
	 *   $props['version']
	 *
	 * @var props An object containing the keys above.
	 */
	public $props;

	/**
	 * Constructor.
	 *
	 * @param string $props Object with all the plugin information.
	 */
	public function __construct( $props ) {
		$this->props = $props;
	}

	/**
	 * Get a value from props
	 *
	 * @param string $key The key.
	 * @return any The value.
	 */
	public function get( $key ) {
		return $this->props[ $key ];
	}

	/**
	 * Method executed when the plugin is activated.
	 */
	public function activate() {
		$settings = get_option( $this->props['option'] );
		if ( ! $settings ) {
			update_option(
				$this->props['option'],
				$this->props['default_settings']
			);
		}
	}

	/**
	 * Method executed when the plugin is deactivated.
	 */
	public function deactivate() {
		delete_option( $this->props['option'] );
	}

	/**
	 * Method that returns if the plugin is "enabled" (do not confuse with activated).
	 *
	 * @return bool If the plugin is enabled or not.
	 */
	public function is_enabled() {

		if ( isset( $_GET[ $this->props['enable_param'] ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			$is_enabled = sanitize_key( $_GET[ $this->props['enable_param'] ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

			if ( 'true' === $is_enabled ) {
				return true;
			}

			if ( 'false' === $is_enabled ) {
				return false;
			}
		} else {
			$settings = get_option( $this->props['option'] );
			return $settings && $settings['isEnabled'];
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
			$this->props['menu_title'],
			$this->props['menu_title'],
			'manage_options',
			$this->props['menu_slug'],
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
		if ( 'settings_page_' . $this->props['menu_slug'] === $hook ) {
			wp_register_script(
				$this->props['script'],
				$this->props['url'] . 'admin/build/bundle.js',
				array(),
				$this->props['version'],
				true
			);
			wp_enqueue_script( $this->props['script'] );
		}
	}

	/**
	 * Method to render warnings.
	 */
	public function render_warning() {
		if ( get_current_screen()->id === 'plugins' ) {
			echo '<div class="notice notice-warning">' .
			'<h2>' . esc_html( $this->props['plugin_title'] ) . '</h2>' .
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
		if ( ! isset( $_POST['data'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			return;
		}

		$data = json_decode( stripslashes( $_POST['data'] ), true ); // phpcs:ignore
		if ( $data ) {
			update_option( $this->props['option'], $data );
		}
		wp_send_json( $data );
	}

	/**
	 * Execute the plugin.
	 */
	public function run() {
		add_action( 'wp_ajax_frontity_save_' . $this->props['option'], array( $this, 'save_settings' ) );
	}

	/**
	 * Function to be executed when uninstalling the plugin.
	 *
	 * To be implemented by each plugin class.
	 */
	abstract public static function uninstall();
}
