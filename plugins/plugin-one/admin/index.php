<?php
$plugin_dir_url = FRONTITY_ONE_URL;
$locale = get_locale();
$settings = get_option('plugin_one_settings');
?>

<div id='root'></div>
<script>
	window.frontity = {
    locale: <?php echo json_encode($locale ? $locale : ''); ?>,
    plugins: {
      pluginOne: {
        url: <?php echo json_encode($plugin_dir_url ? $plugin_dir_url : ''); ?>,
        settings: <?php echo json_encode($settings ? $settings : new stdClass()); ?>,
      }
    }
	};
</script>