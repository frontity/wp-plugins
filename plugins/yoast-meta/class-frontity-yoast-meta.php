<?php

class Frontity_Yoast_Meta
{
  public static $menu_title = 'Yoast Meta';
  public static $menu_slug = 'frontity-yoast-meta';
  public static $settings = 'frontity_yoast_settings';
  public static $script = 'frontity_yoast_meta_admin_js';

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
      Frontity_Yoast_Meta::$menu_title,
      'Yoast Meta',
      'manage_options',
      Frontity_Yoast_Meta::$menu_slug,
      function () {
        require_once FRONTITY_YOAST_META_PATH . "admin/index.php";
      }
    );
  }

  function register_script($hook)
  {
    if ('settings_page_' . Frontity_Yoast_Meta::$menu_slug === $hook) {
      wp_register_script(
        Frontity_Yoast_Meta::$script,
        FRONTITY_YOAST_META_URL . 'admin/build/bundle.js',
        array(),
        FRONTITY_YOAST_META_VERSION,
        true
      );
      wp_enqueue_script(Frontity_Yoast_Meta::$script);
    }
  }

  function render_warning()
  {
    if (get_current_screen()->id === "plugins") {
      echo
        '<div class="notice notice-warning">' .
          '<h2>' . 'Yoast Meta' . '</h2>' .
          '<p>' .
          'We noticed that you have activated <b>Main Plugin</b>, ' .
          'which includes <b>Yoast Meta</b>. ' .
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
    if ($data) update_option(Frontity_Yoast_Meta::$settings, $data);
    wp_send_json($data);
  }

  function run()
  {
    add_action('wp_ajax_frontity_save_' . Frontity_Yoast_Meta::$settings, array($this, 'save_settings'));
  }
}

function Frontity_Yoast_Meta_Activation()
{
  $settings = get_option(Frontity_Yoast_Meta::$settings);
  if (!$settings) {
    update_option(Frontity_Yoast_Meta::$settings, array(
      'value' => 1,
    ));
  }
}

function Frontity_Yoast_Meta_Deactivation()
{
  // $settings = get_option(Frontity_Yoast_Meta::$settings);
  // $settings["value"] = 0;
  // update_option(Frontity_Yoast_Meta::$settings, $settings);
}
