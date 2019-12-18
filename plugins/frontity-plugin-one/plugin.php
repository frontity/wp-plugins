<?php

define( 'FRONTITY_ONE_VERSION', '0.0.1' );

define( 'FRONTITY_ONE_URL', plugin_dir_url( __FILE__ ) );

if ( ! class_exists( 'Plugin_One' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'class-plugin-one.php';
}

$plugin_one = new Plugin_One();

add_action( 'init', array( $plugin_one, 'should_run' ) );

register_activation_hook( __FILE__, 'Plugin_One::activate' );
register_deactivation_hook( __FILE__, 'Plugin_One::deactivate' );
