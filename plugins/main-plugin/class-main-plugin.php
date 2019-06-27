<?php

class Main_Plugin
{
  function register_menu()
  {
    add_menu_page(
      'Main Plugin',
      'Main Plugin',
      'manage_options',
      'main-plugin',
      function () {
        require_once FRONTITY_MAIN_PATH . "admin/index.php";
      }
    );
  }

  function register_script($hook)
  {
    if ('toplevel_page_main-plugin' === $hook) {
      wp_register_script(
        'frontity_main_admin_js',
        FRONTITY_MAIN_URL . 'admin/build/bundle.js',
        array(),
        FRONTITY_MAIN_VERSION,
        true
      );
      wp_enqueue_script('frontity_main_admin_js');
    }
  }

  function run()
  {
    add_action('admin_menu', array($this, 'register_menu'));
    add_action("admin_enqueue_scripts", array($this, "register_script"));
  }
}
