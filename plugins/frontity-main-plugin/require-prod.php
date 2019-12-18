<?php
/**
 * Load dependencies in production mode.
 * 
 * @package Frontity_Main_Plugin
 */

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once FRONTITY_MAIN_PATH . 'shared/class-frontity-plugin.php';
}
if ( ! class_exists( 'Frontity_Main_Plugin' ) ) {
	require_once FRONTITY_MAIN_PATH . 'class-frontity-main-plugin.php';
}
if ( ! class_exists( 'Frontity_Plugin_One' ) ) {
	require_once FRONTITY_MAIN_PATH . 'plugins/class-frontity-plugin-one.php';
}
if ( ! class_exists( 'Frontity_Plugin_Two' ) ) {
	require_once FRONTITY_MAIN_PATH . 'plugins/class-frontity-plugin-two.php';
}
if ( ! class_exists( 'Frontity_Yoast_Meta' ) ) {
	require_once FRONTITY_MAIN_PATH . 'plugins/class-frontity-headtags-plugin.php';
}
