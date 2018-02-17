<?php
class Alert {
	
	function __construct() {
		add_action('admin_init', array($this, 'register_settings'));
		return $this;
	}

	/**
	 * public due to wordpress accessing it from the outside (obviously)
	 **/
	public function register_settings() {
		register_setting('alert', 'alert_message');
		register_setting('alert', 'alert_code');
	}
	public static function print_alert() {
		$alert_type = $this->get_alert_type();
		$alert_message = get_option('alert_message');
		if($alert_type == "none") {
			return;
		}
		echo '<div class="' . $alert_type . ' notice is-dismissible">';
		echo '<p> ' . $alert_message . '</p>';
		echo '</div>';
		self::set_alert('none', -1);
	}

	public function get_alert_type() {
		switch(get_option('alert_code')) {
			case 0:
			return "updated";
			case 1:
			return "update-nag";
			case 2:
			return "error";
			default:
			return "none";
		}
	}

	public static function set_alert($prefix, $alert_code) {
		update_option('alert_message', $prefix, 'yes');
		update_option('alert_code', $alert_code, 'yes');
	}
}
	?>