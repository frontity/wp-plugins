<?php
$plugin_dir_url = FRONTITY_MAIN_URL;
$locale = get_locale();
?>

<div id='root'></div>
<script>
  window.frontity = window.frontity || {
    locale: <?php echo json_encode($locale ? $locale : ''); ?>,
    plugins: {}
  };

  <?php
    foreach ($frontity_plugin_classes as $plugin_class) {
      // Get the plugin URL
      $url = json_encode($plugin_dir_url ? $plugin_dir_url : '');

      // Get settings from database
      $settings = get_option($plugin_class::$settings);
      $settings = json_encode($settings ? $settings : new stdClass());

      // Return code to add the plugin's settings
      echo "
      window.frontity.plugins." . $plugin_class::$plugin_store . " = {
        url: " . $url . ",
        settings: " . $settings . "
      };";
    }
  ?>

</script>