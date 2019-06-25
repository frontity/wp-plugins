<?php
/**
 * Plugin Name: Plugin One
 * Version: 0.0.1
 */

define('PLUGIN_VERSION', '0.0.1');

function activate()
{ }

function deactivate()
{ }

register_activation_hook(__FILE__, "activate");
register_deactivation_hook(__FILE__, "deactivate");
