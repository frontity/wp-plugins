<?php

class Plugin_One {

	public static $plugin_store = 'pluginOne';
	public static $plugin_title = 'Plugin One by Frontity';
	public static $menu_title   = 'Plugin One';
	public static $menu_slug    = 'frontity-plugin-one';
	public static $settings     = 'frontity_plugin_one_settings';
	public static $script       = 'frontity_plugin_one_admin_js';

	static function activate() {
		$settings = get_option( self::$settings );
		if ( ! $settings ) {
			update_option(
				self::$settings,
				array(
					'value' => 1,
				)
			);
		}
	}

	static function deactivate() {
		$settings          = get_option( self::$settings );
		$settings['value'] = 0;
		update_option( self::$settings, $settings );
	}

	function should_run() {
		if ( ! class_exists( 'Main_Plugin' ) ) {
			add_action( 'admin_menu', array( $this, 'register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
			$this->run();
		} else {
			add_action( 'admin_notices', array( $this, 'render_warning' ) );
		};
	}

	function register_menu() {
		add_options_page(
			'Plugin One',
			'Plugin One',
			'manage_options',
			'plugin-one',
			function () {
				require_once plugin_dir_path( __FILE__ ) . 'admin/index.php';
			}
		);
	}

	function register_script( $hook ) {
		if ( 'settings_page_plugin-one' === $hook ) {
			wp_register_script(
				'frontity_one_admin_js',
				FRONTITY_ONE_URL . 'admin/build/bundle.js',
				array(),
				FRONTITY_ONE_VERSION,
				true
			);
			wp_enqueue_script( 'frontity_one_admin_js' );
		}
	}

	function render_warning() {
		if ( get_current_screen()->id === 'plugins' ) {
			echo '<div class="notice notice-warning">' .
			'<h2>' . 'Plugin One' . '</h2>' .
			'<p>' .
			'We noticed that you have activated <b>Main Plugin</b>, ' .
			'which includes <b>Plugin One</b>. ' .
			'</p>' .
			'<p>' .
			'You can safely uninstall this plugin and keep using its functionality from the <b>Main Plugin</b>' .
			'</p>' .
			'</div>';
		}
	}

	function save_settings() {
		$data = json_decode( stripslashes( $_POST['data'] ), true );
		if ( $data ) {
			update_option( self::$settings, $data );
		}
		wp_send_json( $data );
	}

	function run() {
		add_action( 'wp_ajax_frontity_save_' . self::$settings, array( $this, 'save_settings' ) );
	}
}
