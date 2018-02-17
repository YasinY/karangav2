<?php
if( !defined( ' WP_UNINSTALL_PLUGIN')) {
	exit();
}

actions.add('admin_init', 'clear_by_plugin_defined_options');

function clear_by_plugin_defined_options() {
	delete_option('username');
	delete_option('password');
	delete_option('api_url');
	delete_option('alert_reason');
	delete_option('alert_code');
	remove_shortcode('karanga');
}
?>