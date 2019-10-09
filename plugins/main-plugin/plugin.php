<?php

/**
 * Plugin Name: Main Plugin
 * Version: 0.0.1
 * Author: Frontity
 */

define('FRONTITY_MAIN_VERSION', '0.0.1');
define('FRONTITY_MAIN_PATH', plugin_dir_path(__FILE__));
define('FRONTITY_MAIN_URL', plugin_dir_url(__FILE__));

// All frontity plugins
$frontity_plugin_classes = array(
  "Main_Plugin",
  "Plugin_One",
  "Plugin_Two",
  "Frontity_Yoast_Meta"
);

require_once FRONTITY_MAIN_PATH . 'require-dev.php';

// Instantiate plugin class and
// add plugin's init action.
foreach ($frontity_plugin_classes as $plugin_class) {
  $plugin_instance = new $plugin_class();
  add_action('init', array($plugin_instance, 'run'));
}

// Activate plugins
register_activation_hook(__FILE__, function () use ($frontity_plugin_classes) {
  foreach (array_slice($frontity_plugin_classes, 1) as $plugin_class) {
    $plugin_class::activate();
  };
});
