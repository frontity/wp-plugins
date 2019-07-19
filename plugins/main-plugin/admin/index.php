<?php
$plugin_dir_url = FRONTITY_MAIN_URL;
$locale = get_locale();
$plugin_one_settings = get_option('plugin_one_settings');
?>

<div id='root'></div>
<script>
  window.frontity = window.frontity || {
    locale: <?php echo json_encode($locale ? $locale : ''); ?>,
    plugins: {}
  };

  window.frontity.plugins.pluginOne: {
    url: <?php echo json_encode($plugin_dir_url ? $plugin_dir_url : ''); ?>,
    settings: <?php echo json_encode($plugin_one_settings ? $plugin_one_settings : new stdClass()); ?>,
  };
</script>