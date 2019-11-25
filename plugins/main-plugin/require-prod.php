<?php

if ( ! class_exists( 'Main_Plugin' ) ) {
	require_once FRONTITY_MAIN_PATH . 'class-main-plugin.php';
}
if ( ! class_exists( 'Plugin_One' ) ) {
	require_once FRONTITY_MAIN_PATH . 'plugins/class-plugin-one.php';
}
if ( ! class_exists( 'Plugin_Two' ) ) {
	require_once FRONTITY_MAIN_PATH . 'plugins/class-plugin-two.php';
}
if ( ! class_exists( 'Frontity_Yoast_Meta' ) ) {
	require_once FRONTITY_MAIN_PATH . 'plugins/class-frontity-headtags-plugin.php';
}
