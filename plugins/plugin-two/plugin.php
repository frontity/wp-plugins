<?php

/**
 * Plugin Name: Plugin Two
 * Version: 0.0.1
 */

define('FRONTITY_TWO_VERSION', '0.0.1');
define('FRONTITY_TWO_PATH', plugin_dir_path(__FILE__));
define('FRONTITY_TWO_URL', plugin_dir_url(__FILE__));

if (!class_exists("Plugin_Two")) {
  require_once FRONTITY_TWO_PATH . "class-plugin-two.php";
}

$plugin_two = new Plugin_Two();

add_action('init', array($plugin_two, 'should_run'));

register_activation_hook(__FILE__, 'Plugin_Two::activate');
register_deactivation_hook(__FILE__, 'Plugin_Two::deactivate');
