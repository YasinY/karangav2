<?php

add_action( 'admin_head', 'add_tinymce' );

function add_tinymce() {
	global $typenow;

    // Only on Post Type: post and page
	if( ! in_array( $typenow, array( 'post', 'page' ) ) )
		return ;

	add_filter( 'mce_external_plugins', 'initialize_tiny_mce_script' );
    // Add to line 1 form WP TinyMCE
	add_filter( 'mce_buttons', 'register_tinymce_button' );
}

// Inlcude the JS for TinyMCE
function initialize_tiny_mce_script( $plugin_array ) {
	$plugin_array['karanga_mce_plugin'] = TINYMCE_MAIN_JS_FILE_URL;
	return $plugin_array;
}

// Add the button key for address via JS
function register_tinymce_button( $buttons ) {

	array_push( $buttons, 'karanga_mce_plugin' );
	return $buttons;
}

?>