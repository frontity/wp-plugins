<?php

class Plugin_One
{
  function should_run()
  {
    if (!class_exists("Main_Plugin")) {
      add_action("admin_menu", array($this, "register_menu"));
      $this->run();
    } else {
      add_action("admin_notices", array($this, "show_warning"));
    };
  }

  function register_menu()
  {
    add_options_page(
      'Plugin One',
      'Plugin One',
      'manage_options',
      'plugin-one'
    );
  }

  function show_warning()
  {
    if (get_current_screen()->id === "plugins") {
      echo
        '<div class="notice notice-warning">' .
          '<h2>' . 'Plugin One' . '</h2>' .
          '<p>' .
          'We noticed that you have activated <b>Main Plugin</b>, ' .
          'which includes <b>Plugin One</b>. ' .
          '</p>' .
          '<p>' .
          'You can safely uninstall this plugin and keep using its functionality from the <b>Main Plugin</b>' .
          '</p>' .
          '</div>';
    }
  }

  function run()
  { }
}
