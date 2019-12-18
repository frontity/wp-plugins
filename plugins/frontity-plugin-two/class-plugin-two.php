<?php

class Plugin_Two {

	public static $plugin_store = 'pluginTwo';
	public static $plugin_title = 'Plugin Two by Frontity';
	public static $menu_title   = 'Plugin Two';
	public static $menu_slug    = 'frontity-plugin-two';
	public static $settings     = 'frontity_plugin_two_settings';
	public static $script       = 'frontity_plugin_two_admin_js';

	static function activate() {     }

	static function deactivate() {   }

	function should_run() {
		if ( ! class_exists( 'Main_Plugin' ) ) {
			add_action( 'admin_menu', array( $this, 'register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
			$this->run();
		} else {
			add_action( 'admin_notices', array( $this, 'show_warning' ) );
		};
	}

	function register_menu() {
		add_options_page(
			'Plugin Two',
			'Plugin Two',
			'manage_options',
			'plugin-two',
			function () {
				require_once FRONTITY_ONE_PATH . 'admin/index.php';
			}
		);
	}

	function register_script( $hook ) {
		if ( 'settings_page_plugin-two' === $hook ) {
			wp_register_script(
				'frontity_two_admin_js',
				FRONTITY_TWO_URL . 'admin/build/bundle.js',
				array(),
				FRONTITY_TWO_VERSION,
				true
			);
			wp_enqueue_script( 'frontity_two_admin_js' );
		}
	}

	function show_warning() {
		if ( get_current_screen()->id === 'plugins' ) {
			echo '<div class="notice notice-warning">' .
			'<h2>' . 'Plugin Two' . '</h2>' .
			'<p>' .
			'We noticed that you have activated <b>Main Plugin</b>, ' .
			'which includes <b>Plugin Two</b>. ' .
			'</p>' .
			'<p>' .
			'You can safely uninstall this plugin and keep using its functionality from the <b>Main Plugin</b>' .
			'</p>' .
			'</div>';
		}
	}

	function run() {     }
}
