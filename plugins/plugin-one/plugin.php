<?php
/**
 * Plugin Name: Plugin One
 * Version: 0.0.1
 */

define('FRONTITY_ONE_VERSION', '0.0.1');
define('FRONTITY_ONE_PATH', plugin_dir_path(__FILE__));
define('FRONTITY_ONE_URL', plugin_dir_url(__FILE__));

if (!class_exists("Plugin_One")) {
  require_once FRONTITY_ONE_PATH . "class-plugin-one.php";
}

$plugin_one = new Plugin_One();

add_action('init', array($plugin_one, 'should_run'));

register_activation_hook(__FILE__, 'Plugin_One_Activation');
register_deactivation_hook(__FILE__, 'Plugin_One_Deactivation');

