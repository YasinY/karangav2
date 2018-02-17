<?php
/**
* Creates and registers options for use later on the 
* {@link pagecontent.php} file
**/
@include('Karanga.php');
@include('class.alert.php');
//@include('util-methods.php');
class HandleOptions {


	public function __construct() {
		add_action('admin_init', array($this, 'register_options'));
		if(isset($_POST['save_data'])) {
			add_action('admin_init', array($this, 'update_options'));
		} else if(isset($_POST['update_galleries'])) {
			add_action('admin_init', array($this, 'update_galleries'));
		}

		if(get_option('code') != -1) {
			$alert = new Alert();
			add_action('admin_notices', array($alert, 'print_alert'));
		}
	}


/**
 * Adds options into the database if they do not exist already, and 
 * registers them so the form handling the settings group {@link user_data} 
 * has permission to update 
 * public due to wordpress accessing it from the outside (obviously)
 **/
public function register_options() {
	register_setting('user_data', 'username');
	register_setting('user_data', 'password');
	register_setting('user_data', 'api_url');
}
public function update_options() {
	if ( empty($_POST['isengard']) || !wp_verify_nonce( $_POST['isengard'], 'handle_data' ) ) {
		Alert::set_alert("You don't have the needed privileges to do this.", 2);
		return;
	}
	update_option("username", get_option('username'), "yes");
	update_option("password", get_option('password'), "yes");
	update_option("api_url", get_option('api_url'), "yes");
	Alert::set_alert("Updated data.", 0);
}
public function update_galleries() {
	if (empty($_POST['isengard']) || !wp_verify_nonce( $_POST['isengard'], 'handle_data' ) ) {
		Alert::set_alert("You don't have the needed privileges to do this.", 2);
		return;
	}
	$failed_galleries = "";
	$successful_galleries = "";
	$karanga = new Karanga();
	$api_url = get_option('api_url');
	$username = get_option('username');
	$password = get_option('password');
	$gallery = UtilMethods::get_gallery_ids();
	if(!empty($gallery['error']) && $gallery['error'] != 200) {
		Alert::set_alert("Couldn't retrieve file, please check your data. ERROR: " . $gallery['error_text'], 2);
				return; //So the loop is not being executed
			}
			foreach($gallery['list'] as $value) {
				$url = $value['url'];
				$result = UtilMethods::handle_article_list(json_encode($url));
				$failed = ($failed_galleries == "");
				if($result == "Nothing") {
					$failed_galleries .= $url . ' ';
				} else {
					$successful_galleries .= $url . ', ';
				}
					Alert::set_alert(($failed) ? "Done updating with all galleries and no failures." : "Done updating galleries: " . $successful_galleries . " but with following failures: " . $failed_galleries, ($failed) ? 0 : 1);
			} 
		}

	}
	?>