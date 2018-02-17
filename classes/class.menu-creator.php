<?php
@require('class.page-content.php');
class MenuCreator {

function __construct() {
	add_action('admin_menu', array($this, 'create_menu'));
}
/**
 * Creates a menu in the administrator selection of menus and loads 
 * its content from the {@link PageContent} class through the create_page_content method
 **/
	function create_menu() {
		//TODO EDIT!
		if (!empty($GLOBALS['admin_page_hooks']['request_manager_menu'])) {
			add_action('admin_head', array($this,'throw_error'));
			die(throw_error());
			return;
		}
		if(function_exists('add_menu_page')) {
			add_menu_page('Request', 'Karanga', 'manage_options', "request_manager_menu", array($this, 'create_page_content'));
		} 
	}
	function create_page_content() {
		return (new PageContent)->create_page_content();
	}

	function throw_error() {
		return "Failed to load menu, please make sure you have updated this plugin and deactivated identical ones.";
	}
}

?>