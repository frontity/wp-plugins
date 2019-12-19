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
	 * A single example test.
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
	 * Another single example test.
	 */
	public function test_page_title() {
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/pages/%d', self::$page_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response = rest_get_server()->dispatch( $request );
		$data     = $response->get_data();
		$this->assertEquals( 'title', $data['head_tags'][0]['tag'] );
		$this->assertEquals( 'Page Title – Test Blog', $data['head_tags'][0]['content'] );
	}
}
