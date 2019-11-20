<?php
/**
 * File that renders the plugin admin page.
 *
 * @package Frontity_Headtags
 */

$plugin_dir_url = FRONTITY_HEADTAGS_URL;
$loc            = get_locale();
$settings       = get_option( 'frontity_headtags_settings' );
?>

<div id='root'></div>
<script>
window.frontity = {
locale: <?php echo wp_json_encode( $loc ? $loc : '' ); ?>,
plugins: {
headtags: {
	url: <?php echo wp_json_encode( $plugin_dir_url ? $plugin_dir_url : '' ); ?>,
	settings: <?php echo wp_json_encode( $settings ? $settings : new stdClass() ); ?>,
}
}
};
</script>
