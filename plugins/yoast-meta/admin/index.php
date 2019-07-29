<?php
$plugin_dir_url = FRONTITY_YOAST_META_URL;
$locale = get_locale();
$settings = get_option(Frontity_Yoast_Meta::$settings);
?>

<div id='root'></div>
<script>
  window.frontity = {
    locale: <?php echo json_encode($locale ? $locale : ''); ?>,
    plugins: {
      yoast: {
        url: <?php echo json_encode($plugin_dir_url ? $plugin_dir_url : ''); ?>,
        settings: <?php echo json_encode($settings ? $settings : new stdClass()); ?>,
      }
    }
  };
</script>