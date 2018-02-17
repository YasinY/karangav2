<?php

/**
 * Could do something like this ;)
 **/
class UtilMethods {

	/**
	 * Checks if there are is an existing file given as parameter in the url ({@param url}).
	 * if not it creates the file directly. If it does exist, the method works with the timestamp of the file,
	 * checking if its older than 30 minutes, if so, it makes a request to the API, replacing the deprecated content
	 * with newer ones, then returning it as a decoded json string
	 *
	 * {@param url} the filename to check
	 **/
	public static function handle_article_list($url) {
		$url = str_replace('"', '', $url);
		$files = glob(JSON_DIRECTORY_PATH . '*.json');
		if(count($files) < 1) {
			self::write_json_files();
			return;
		}
		foreach($files as $file) {
			$data_name = basename(str_replace('.json', '', $file));
			if(!($data_name == $url)) {
				continue;
			} 
			$time_file = filemtime($file);
			$time_now = date('U');
			$time_passed = ($time_now - $time_file);
			$time_required = (30 * 60);
			if($time_passed >= $time_required) {
				self::write_to_json($file, $url);
			} 
			return json_decode(file_get_contents($file), true);
		}
		return "Nothing"; //We're never gonna get to this point..
	}
	/**
	 *
	 * 
	 **/
	public static function write_json_files() {
		$gallery = self::get_gallery_ids();
		$failed_galleries = "";
		if(isset($gallery['error'])) {
			Alert::set_alert("There was en error accessing the gallery id's", 2);
				return; //So the writing does not happen
			} else {
				foreach($gallery['list'] as $value) {
					$url = str_replace('"', "", json_encode($value['url']));
					$content =  self::get_gallery_in_json($url);
					if (strpos($content, 'error') !== false) {
						$failed_galleries .= $url . ', ';
					}
					$no_fails = ($failed_galleries == "");
					Alert::set_alert(($no_fails) ? "Saved data to path: " . JSON_DIRECTORY_PATH  : "Some galleries failed to load: " . $failed_galleries, ($no_fails) ? 0 : 1);
					if (strpos($failed_galleries, $url) !== false) {
						continue;
					} else {
						file_put_contents(JSON_DIRECTORY_PATH . $url . ".json", $content);
					}
				}
			}
		}

		private static function write_to_json($file, $url) {
			$gallery = self::get_gallery_in_json($url);
			if(isset($gallery['error']) && $gallery['error'] != 200) {
				Alert::set_alert("There was an error accessing the gallery id's", 2);
				return; //So the writing does not happen
			} else {
				file_put_contents($file, $gallery);
			}
		}
		public static function get_gallery_ids() {
			return (new Karanga)->gallery_list(get_option('api_url'), get_option('username'), get_option('password'));
		}

		public static function get_gallery_in_json($url) {
			return json_encode((new Karanga)->article_list(get_option('api_url'), get_option('username'), get_option('password'), $url));
		}
	}

	?>