<?php
/**
 * Plugin Name: Main Plugin
 * Version: 0.0.1
 * Author: Frontity
 */

define('FRONTITY_MAIN_VERSION', '0.0.1');
define('FRONTITY_MAIN_PATH', plugin_dir_path(__FILE__));
define('FRONTITY_MAIN_URL', plugin_dir_url(__FILE__));

require_once FRONTITY_MAIN_PATH . 'require-dev.php';

$main_plugin = new Main_Plugin();
$plugin_one = new Plugin_One();
$plugin_two = new Plugin_Two();

add_action('init', array($main_plugin, 'run'));
add_action('init', array($plugin_one, 'run'));
add_action('init', array($plugin_two, 'run'));
