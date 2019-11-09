<?php
/**
 * File description.
 *
 * @package Frontity_Yoast_Meta
 */

/**
 * The plugin class, you know.
 */
class Frontity_Yoast_Meta extends Frontity_Plugin {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plugin_namespace' => 'yoast',
				'plugin_title'     => 'REST API Yoast Meta by Frontity',
				'menu_title'       => 'Yoast Meta',
				'menu_slug'        => 'frontity-yoast-meta',
				'script'           => 'frontity_yoast_meta_admin_js',
				'enable_param'     => 'yoast_meta',
				'option'           => 'frontity_yoast_settings',
				'default_settings' => array( 'isEnabled' => true ),
				'url'              => FRONTITY_YOAST_META_URL,
				'version'          => FRONTITY_YOAST_META_VERSION,
			)
		);
	}


	/**
	 * Overrides should_run method.
	 */
	public function should_run() {
		if ( ! class_exists( 'Main_Plugin' ) && class_exists( 'WPSEO_Frontend' ) ) {
			add_action( 'admin_menu', array( $this, 'register_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ) );
			$this->run();
		} else {
			// Show admin notices.
			if ( class_exists( 'Main_Plugin' ) ) {
				add_action( 'admin_notices', array( $this, 'render_warning' ) );
			}
			if ( ! class_exists( 'WPSEO_Frontend' ) ) {
				add_action( 'admin_notices', array( $this, 'render_yoast_not_found_warning' ) );
			}
		};
	}

	/**
	 * Render a warning when Yoast plugin is not installed.
	 */
	public function render_yoast_not_found_warning() {
		if ( get_current_screen()->id === 'plugins' ) {
			echo '<div class="notice notice-warning">' .
			'<h2>' . esc_html( $this->description->plugin_title ) . '</h2>' .
			'<p>' .
			'We noticed that you do not have <b>Yoast SEO</b>, ' .
			' plugin installed.' .
			'</p>' .
			'<p>' .
			'You need to install it first.' .
			'</p>' .
			'</div>';
		}
	}


	/**
	 * Overrides run function.
	 */
	public function run() {
		parent::run();

		if ( $this->is_enabled() ) {
			require_once plugin_dir_path( __FILE__ ) . '/includes/class-frontity-headtags.php';
			new Frontity_Headtags();
		}
	}
}
