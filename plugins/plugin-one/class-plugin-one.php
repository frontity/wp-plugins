<?php

class Plugin_One
{
  function should_run()
  {
    if (!class_exists("Main_Plugin")) {
      add_action("admin_menu", array($this, "register_menu"));
      add_action("admin_enqueue_scripts", array($this, "register_script"));
      $this->run();
    } else {
      add_action("admin_notices", array($this, "render_warning"));
    };
  }

  function register_menu()
  {
    add_options_page(
      'Plugin One',
      'Plugin One',
      'manage_options',
      'plugin-one',
      function () {
        require_once FRONTITY_ONE_PATH . "admin/index.php";
      }
    );
  }

  function register_script($hook)
  {
    if ('settings_page_plugin-one' === $hook) {
      wp_register_script(
        'frontity_one_admin_js',
        FRONTITY_ONE_URL . 'admin/build/bundle.js',
        array(),
        FRONTITY_ONE_VERSION,
        true
      );
      wp_enqueue_script('frontity_one_admin_js');
    }
  }

  function render_warning()
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

  function save_settings()
  {
    $data = json_decode(stripslashes($_POST["data"]), true);
    if ($data) update_option('plugin_one_settings', $data);
    wp_send_json($data);
  }

  function run()
  {
    add_action('wp_ajax_frontity_save_plugin_one_settings', array($this, 'save_settings'));
  }
}

function Plugin_One_Activation() {
  $settings = get_option('plugin_one_settings');
  if (!$settings) {
    update_option('plugin_one_settings', array(
      'value' => 1,
    ));
  }
}

function Plugin_One_Deactivation() {
  $settings = get_option('plugin_one_settings');
  $settings["value"] = 0;
  update_option('plugin_one_settings', $settings);
}