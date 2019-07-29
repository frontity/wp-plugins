<?php

/**
 * Plugin Name: REST API Yoast Meta by Frontity
 * Version: 0.1.0
 */

define('FRONTITY_YOAST_META_VERSION', '0.1.0');
define('FRONTITY_YOAST_META_PATH', plugin_dir_path(__FILE__));
define('FRONTITY_YOAST_META_URL', plugin_dir_url(__FILE__));

if (!class_exists("Frontity_Yoast_Meta")) {
  require_once FRONTITY_YOAST_META_PATH . "class-frontity-yoast-meta.php";
}

$frontity_yoast_meta = new Frontity_Yoast_Meta();

add_action('init', array($frontity_yoast_meta, 'should_run'));

register_deactivation_hook(__FILE__, 'Frontity_Yoast_Meta_Deactivation');
register_activation_hook(__FILE__, 'Frontity_Yoast_Meta_Activation');
