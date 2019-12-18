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
	 * The namespace for this plugin in the @frontity / connect store.
	 * 
	 * @var $plugin_store Namespace.
	 */ 
	public static $plugin_namespace = 'main';

	/**
	 * Title that will appear in the admin pages.
	 * 
	 * @var $plugin_title Title.
	 */ 
	public static $plugin_title = 'Main Plugin by Frontity';

	/**
	 * Title that will appear in the menu.
	 * 
	 * @var $menu_title Title.
	 */ 
	public static $menu_title = 'Main Plugin';

	/**
	 * Slug of the admin page.
	 * 
	 * @var $menu_slug Title.
	 */ 
	public static $menu_slug = 'frontity-main-plugin';

	/**
	 * Name of the settings stored in database.
	 * 
	 * @var $settings Option name.
	 */ 
	public static $settings = 'frontity_main_plugin_settings';

	/**
	 * Name of generated JavaScript file for the admin page.
	 * 
	 * @var $script Script name.
	 */ 
	public static $script = 'frontity_main_plugin_admin_js';

	/**
	 * Register menu.
	 */
	public function register_menu() {
		add_menu_page(
			'Main Plugin',
			'Main Plugin',
			'manage_options',
			'main-plugin',
			function () {
				global $frontity_plugin_classes;
				require_once FRONTITY_MAIN_PATH . 'admin/index.php';
			}
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
		foreach ( $frontity_plugin_classes as $plugin_class ) {
			// Get the plugin URL.
			$url = wp_json_encode( $plugin_dir_url ? $plugin_dir_url : '' );

			// Get settings from database.
			$settings = get_option( $plugin_class->props['option'] );
			$settings = wp_json_encode( $settings ? $settings : new stdClass() );

			// Return code to add the plugin's settings.
			echo esc_html(
				'window.frontity.plugins.' . $plugin_class->props['plugin_namespace'] . '= { url:' .
				$url . ', settings:' . $settings . ' };'
			);
		}
		?>
		</script>
		<?php
	}

	/**
	 * Register script.
	 * 
	 * @param string $hook The hook.
	 */
	public function register_script( $hook ) {
		if ( 'toplevel_page_main-plugin' === $hook ) {
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

	/**
	 * Run the plugin.
	 */
	public function run() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
	}
}
