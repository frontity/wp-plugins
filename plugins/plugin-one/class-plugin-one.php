<?php

class Plugin_One
{
  function should_run()
  {
    if (!class_exists("Main_Plugin")) {
      $this->run();
    } else {
      add_action("admin_notices", array($this, "show_warning"));
    };
  }

  function show_warning()
  {
    echo
      '<div class="notice notice-warning">' .
        '<h2>' . 'Plugin One' . '</h2>' .
        '<p>' .
        'We noticed that you have the <b>Main Plugin</b> activated, ' .
        'which includes <b>Plugin One</b>. ' .
        '</p>' .
        '<p>' .
        'You can safely uninstall this plugin and keep using its functionality from the <b>Main Plugin</b>' .
        '</p>' .
        '</div>';
  }

  function run()
  {
    echo "Echo from Plugin One";
  }
}
