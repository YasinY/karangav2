<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="./data/tinymce/javascript/content.js"></script>
<link rel="stylesheet" href="./data/css/editor-gallery.css">
<?php 	

		//var_dump($windowContent); exit;
if(count($windowContent) < 1) {
echo '<h2>No galleries found. Please request them, see Karanga settings-page as reference. ';
}
		foreach($windowContent as $value) {
			if(sizeof($value) < 3) {
				continue;
			}
			echo '<div class="content-wrapper">';
		echo '<img src="' . $value['imageLink'] . '" class="gallery-image" />';
		echo '<div class="properties">';
		echo '<p>Name: ' . $value['name'] . ' </p>';
		echo '<p>Shortcut: ' . $value['url'] . ' </p>';
		echo '<button id="' . $value['name'] . '" value="' . $value['url'] . '">Add shortcode </button>';
		echo '</div>';
		echo '</div>';
		} 
		?>