<?php
/**
 * Load dependencies in development mode.
 * 
 * @package Frontity_Main_Plugin
 */

if ( ! class_exists( 'Frontity_Plugin' ) ) {
	require_once FRONTITY_MAIN_PATH . '../../shared/class-frontity-plugin.php';
}
if ( ! class_exists( 'Frontity_Main_Plugin' ) ) {
	require_once FRONTITY_MAIN_PATH . 'class-frontity-main-plugin.php';
}
if ( ! class_exists( 'Frontity_Plugin_One' ) ) {
	require_once FRONTITY_MAIN_PATH . '../frontity-plugin-one/class-frontity-plugin-one.php';
}
if ( ! class_exists( 'Frontity_Plugin_Two' ) ) {
	require_once FRONTITY_MAIN_PATH . '../frontity-plugin-two/class-frontity-plugin-two.php';
}
if ( ! class_exists( 'Frontity_Yoast_Meta' ) ) {
	require_once FRONTITY_MAIN_PATH . '../frontity-headtags/class-frontity-headtags-plugin.php';
}
