<?php
$plugin_dir_url = FRONTITY_ONE_URL;
$loc            = get_locale();
$settings       = get_option( Plugin_One::$settings );
?>

<div id='root'></div>
<script>
	window.frontity = {
	locale: <?php echo wp_json_encode( $loc ? $loc : '' ); ?>,
	plugins: {
		pluginOne: {
			url: <?php echo wp_json_encode( $plugin_dir_url ? $plugin_dir_url : '' ); ?>,
			settings: <?php echo wp_json_encode( $settings ? $settings : new stdClass() ); ?>,
		}
	}
	};
</script>
