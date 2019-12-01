<?php
$plugin_dir_url = FRONTITY_MAIN_URL;
$loc            = get_locale();
?>

<div id='root'></div>
<script>
	window.frontity = window.frontity || {
		locale: <?php echo wp_json_encode( $loc ? $loc : '' ); ?>,
		plugins: {}
	};

	<?php
	foreach ( $frontity_plugin_classes as $plugin_class ) {
		// Get the plugin URL.
		$url = wp_json_encode( $plugin_dir_url ? $plugin_dir_url : '' );

		// Get settings from database.
		$settings = get_option( $plugin_class::$settings );
		$settings = wp_json_encode( $settings ? $settings : new stdClass() );

		// Return code to add the plugin's settings.
		echo esc_html(
			'window.frontity.plugins.' . $plugin_class::$plugin_store . '= { url:' .
				$url . ', settings:' . $settings . ' };'
		);
	}
	?>

</script>
