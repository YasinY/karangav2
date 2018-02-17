<?php
/**
 * @package Karanga
 */
/*
Plugin Name: Karanga API
Plugin URI: http://captech.de/
Description: A plugin which makes requests to the karanga api, making it possible to show galleries requested from it by storing every kind of gallery at the local storage.
Version: 1
Author: Yasin Yazici
Author URI: http://github.com/YasinY/
Text Domain: karanga
*/

if (!defined('ABSPATH')) 
{
	require_once( "../../../wp-load.php" );
}

//FILESYSTEM

DEFINE('KARANGA_DIR_PATH', plugin_dir_path(__FILE__));
DEFINE('KARANGA_DATA_PATH', KARANGA_DIR_PATH . 'data/');
DEFINE('KARANGA_CSS_FILES_PATH', KARANGA_DATA_PATH . 'css/');
DEFINE('JSON_DIRECTORY_PATH', KARANGA_DATA_PATH . 'json/');
DEFINE('JSON_LIST_PATH',   JSON_DIRECTORY_PATH . 'liste.json');
DEFINE('TINYMCE_PLUGIN_PATH', KARANGA_DATA_PATH . 'tinymce/');
DEFINE('TINYMCE_JAVA_SCRIPTS_PATH', TINYMCE_PLUGIN_PATH . 'javascript/');
DEFINE('TINYMCE_MAIN_JS_FILE_PATH', TINYMCE_JAVA_SCRIPTS_PATH . 'karanga-galleries.js');
DEFINE('TINYMCE_VIEWS_PATH', TINYMCE_PLUGIN_PATH . 'views/');


//HTTP LINKS
DEFINE('KARANGA_URL', plugins_url() . '/karangav2/');
DEFINE('KARANGA_DATA_URL', KARANGA_URL . 'data/');
DEFINE('KARANGA_CSS_FILES_URL', KARANGA_DATA_URL . 'css/');
DEFINE('TINYMCE_PLUGIN_URL', KARANGA_DATA_URL . 'tinymce/');
DEFINE('TINYMCE_JAVA_SCRIPTS_URL', TINYMCE_PLUGIN_URL . 'javascript/');
DEFINE('TINYMCE_MAIN_JS_FILE_URL', TINYMCE_JAVA_SCRIPTS_URL . 'karanga-galleries.js');
DEFINE('TINYMCE_VIEWS_URL', TINYMCE_PLUGIN_URL . 'views/');

@require('classes/class.handle-options.php');
@require('classes/class.handle-shortcode.php');
@require('classes/class.menu-creator.php');
@require('classes/class.style-handler.php');
@require('classes/init-tinymce.php');
@require('classes/util-methods.php');
@require(TINYMCE_VIEWS_PATH . 'view-handler.php');

add_action('init',  'initialize_plugin');

if (!empty($_GET['page'])){
	if($_GET['page'] == 'gallery_template_tinymce') {
		(new ViewHandler)->readAndPrintView('gallery-template.php'); //Returns a string
	}
}
	
function initialize_plugin() {
		new MenuCreator();
		new HandleOptions();
		new HandleShortcode();
		new StyleHandler();
}


?>