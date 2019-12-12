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

	protected static $post_id;
	protected static $frontity_headtags_plugin;

	public static function wpSetUpBeforeClass( $factory ) {
		self::$post_id = $factory->post->create();

		// Activate plugin.
		self::$frontity_headtags_plugin = new Frontity_Headtags_Plugin();
		self::$frontity_headtags_plugin->activate();
		self::$frontity_headtags_plugin->run();
	}

	public static function wpTearDownAfterClass() {
		wp_delete_post( self::$post_id, true );

		// Remove all plugin settings.
		self::$frontity_headtags_plugin->uninstall();
	}
	/**
	 * A single example test.
	 */
	public function test_context_param() {
		$request = new WP_REST_Request( 'GET', sprintf( '/wp/v2/posts/%d', self::$post_id ) );
		$request->set_query_params( array( 'head_tags' => 'true' ) );
		$response = rest_get_server()->dispatch( $request );
		$data     = $response->get_data();
		$this->assertEquals( 'title', $data['head_tags'][0]['tag'] );
		$this->assertEquals( 'Post title 18 – Test Blog', $data['head_tags'][0]['content'] );
	}
}
