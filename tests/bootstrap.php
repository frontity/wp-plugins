<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Frontity/Tests
 */

$frontity_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $frontity_tests_dir ) {
	$frontity_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $frontity_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $frontity_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $frontity_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function frontity_manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/plugins/frontity-headtags/plugin.php';
}
tests_add_filter( 'muplugins_loaded', 'frontity_manually_load_plugin' );

// Start up the WP testing environment.
require $frontity_tests_dir . '/includes/bootstrap.php';
