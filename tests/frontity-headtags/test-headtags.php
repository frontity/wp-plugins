<?php
/**
 * Class HeadTags
 *
 * @package Frontity_Headtags/Tests
 */

/**
 * Sample test case.
 */
class HeadTags extends WP_UnitTestCase {

	/**
	 * Mocked post id.
	 * 
	 * @var string $post_id
	 */
	protected static $post_id;

	/**
	 * Mocked page id.
	 * 
	 * @var string $page_id
	 */
	protected static $page_id;

	/**
	 * Frontity_Headtags_Plugin instance.
	 * 
	 * @var Frontity_Headtags_Plugin $frontity_headtags_plugin
	 */
	protected static $frontity_headtags_plugin;

	/**
	 * Set up before all tests.
	 * 
	 * @param mixed $factory Factory.
	 */
	public static function wpSetUpBeforeClass( $factory ) {
		// This fixes a problem when running 'redirect_canonical' (/wp-includes/canonical.php).
		$_SERVER['REQUEST_URI'] = '/';

		// Init a test post.
		self::$post_id = $factory->post->create(
			array(
				'post_title' => 'Post Title',
			)
		);
		
		// Init a test page.
		self::$page_id = $factory->post->create(
			array(
				'post_type'  => 'page',
				'post_title' => 'Page Title',
			)
		);

		// Activate plugin.
		self::$frontity_headtags_plugin = new Frontity_Headtags_Plugin();
		self::$frontity_headtags_plugin->activate();
		self::$frontity_headtags_plugin->run();
	}

	/**
	 * Tear down after tests.
	 */
	public static function wpTearDownAfterClass() {
		wp_delete_post( self::$post_id, true );

		// Remove all plugin settings.
		self::$frontity_headtags_plugin->uninstall();
	}
	/**
	 * Title is populated correctly in posts.
	 */
	public function test_post_title() {
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/posts/%d', self::$post_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response = rest_get_server()->dispatch( $request );
		$data     = $response->get_data();
		$this->assertEquals( 'title', $data['head_tags'][0]['tag'] );
		$this->assertEquals( 'Post Title – Test Blog', $data['head_tags'][0]['content'] );
	}

	/**
	 * Title is populated correctly in pages.
	 */
	public function test_page_title() {
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/pages/%d', self::$page_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response = rest_get_server()->dispatch( $request );
		$data     = $response->get_data();
		$this->assertEquals( 'title', $data['head_tags'][0]['tag'] );
		$this->assertEquals( 'Page Title – Test Blog', $data['head_tags'][0]['content'] );
	}

	/**
	 * Transients are saved correctly.
	 */
	public function test_set_transients() {
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/pages/%d', self::$page_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response          = rest_get_server()->dispatch( $request );
		$data              = $response->get_data();
		$transient         = get_option( '_transient_frontity_headtags_page_' . self::$page_id );
		$transient_timeout = get_option( '_transient_timeout_frontity_headtags_page_' . self::$page_id );
		$next_month        = time() + MONTH_IN_SECONDS;
		$this->assertEquals( $data['head_tags'], $transient['head_tags'] );
		$this->assertLessThan( 100, $next_month - $transient_timeout );
	}
	
	/**
	 * Transients are used correctly.
	 */
	public function test_use_transients() {
		// Set current cache token.
		update_option( 'frontity_headtags_cache_token', 'awkgl' );
		// Mock transient.
		$transient = array(
			'head_tags'   => 'mocked_headtags',
			'cache_token' => 'awkgl',
		);
		update_option( '_transient_frontity_headtags_page_' . self::$page_id, $transient );
		// Do the request.
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/pages/%d', self::$page_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response = rest_get_server()->dispatch( $request );
		$data     = $response->get_data();
		$this->assertEquals( $data['head_tags'], $transient['head_tags'] );
	}
	
	/**
	 * Transients are removed correctly.
	 */
	public function test_remove_transients() {
		// Set current cache token.
		update_option( 'frontity_headtags_cache_token', 'awkgl' );
		// Mock transient.
		$transient = array(
			'head_tags'   => 'mocked_headtags',
			'cache_token' => 'awkgl',
		);
		set_transient( 'frontity_headtags_page_' . self::$page_id, $transient, MONTH_IN_SECONDS );
		// Remove cache.
		Frontity_Headtags_Plugin::clear_cache();
		// Do the request.
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/pages/%d', self::$page_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response = rest_get_server()->dispatch( $request );
		$data     = $response->get_data();
		$this->assertNotEquals( $data['head_tags'], $transient['head_tags'] );
		$this->assertEquals( 'title', $data['head_tags'][0]['tag'] );
		$this->assertEquals( 'Page Title – Test Blog', $data['head_tags'][0]['content'] );
		
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.NoCaching
		
		// Check that transients doesn't exist in database.
		global $wpdb;
		$transients = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s",
				'\_transient\_%frontity\_headtags%'
			)
		);
		// phpcs:enable

		$this->assertEmpty( $transients );
	}
}
