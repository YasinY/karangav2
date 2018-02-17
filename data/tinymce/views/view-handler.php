<?php

class ViewHandler {
	


	public function readView($file) {
		ob_start();
		include plugin_dir . $file;
		$html = ob_get_contents();
		ob_end_clean();		
		return $html;
	}

	public function readAndPrintView($file) {
		$windowContent = $this->getWindowContent();
		ob_start();
		include TINYMCE_VIEWS_PATH . $file;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	private function getWindowContent() {
		$list = array();
		$jsonFiles = glob(JSON_DIRECTORY_PATH . '*.json');
		foreach($jsonFiles as $jsonFile) {
			$content = json_decode(file_get_contents($jsonFile), true);
			if(!isset($content['outfits']))
				continue;
            $imageLink = $content['outfits'][0]['images']['outfit']['file'];
            $name = $content['gallery']['name'];
            $url = basename(str_replace(".json", "", $jsonFile));
            array_push($list, array(
            	'name' => $name, 
            	'imageLink' => $imageLink,
            	'url' => $url
            ));
		}
		return $list;
	}
}

?>