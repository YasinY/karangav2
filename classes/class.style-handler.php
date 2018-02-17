<?php
class StyleHandler {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array($this, 'register_styles' ));
	}

		/**
		* ONLY WORKS IN FRONT-END!
		*
		*/
	function register_styles() {
		wp_register_style('front_end_gallery_style', KARANGA_CSS_FILES_URL . 'gallery.css');
		wp_enqueue_style('front_end_gallery_style'); 
	}


}

?>