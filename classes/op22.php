<?php
//@include('class.json-data.php');
class Shortcode {
	public function __construct() {

		add_filter( 'mce_external_plugins', array($this, 'wpse18719_tiny_mce_before_init' ));
		add_filter( 'mce_buttons', array($this, 'wpse18719_mce_buttons' ));
	//	add_action('admin_head', array($this, 'lb_add_tinymce'));

	}


	function wpse18719_tiny_mce_before_init( $initArray )
	{
		$images = "var karangaimages = {'None':'None'";
		$string1 = "[function(editor) {";

		$string2 = "
			editor.addButton('h2', {
				title : 'Karanga Galleries shortcuts',
				text: 'Karanga Galleries',
				cmd: 'open_window'
			});
editor.addCommand('open_window', function() {
	var windowManager = editor.windowManager.open({
		title: 'Galleries',
		height: 420,
		width: 800,
		body: [
			{
			type   : 'listbox',
			name   : 'gallery_list',
			label  : 'Galleries',
			onselect: function() {
				var value = this.value();
				if(value === 'select_gallery') {
					return;
				}
				var valueFormat = '[karanga url=\"' + value + '\"]';

				tinyMCE.activeEditor.windowManager.setParams(valueFormat);
				var image = jQuery('<img/>').attr('src', \"\").attr('style', 'width: 450px; height: 320px; padding-left: 20%;').attr('id', 'previewImage');
				for(var key in karangaimages) {
					if(key == 'None')
						continue;
					if(karangaimages.hasOwnProperty(key) && value == key) {
						//alert(key + ' => ' + karangaimages[key]);
						console.log('found ' + karangaimages[key]);
						if(!jQuery('#previewImage').length) {
							jQuery('#mceu_59-body').after(image);
						} 
						jQuery('#previewImage').attr('src', karangaimages[key]);
						tinyMCE.activeEditor.dom.setHTML('prev', '<img src=\" + karangaimages[key] + \" />');
					}
				}


			},
                    "; //FIRST PART
$string3 = "values: [{ text: 'Please select a gallery', value: 'select_gallery'}"; // DYNAMIC PART
$string4 = "],
	},
	//TB HERE
],
buttons: [{
	text: 'Submit',
	onclick: function() {
		tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, window.parent.tinyMCE.activeEditor.windowManager.getParams());
		parent.tinyMCE.activeEditor.windowManager.close(this);
	}
}, {
	text: 'Cancel',
	onclick: 'close'
}],
})
});
}][0]"; // LAST PART
$gallery = (new Karanga)->gallery_list(get_option('api_url'), get_option('username'), get_option('password'));
	if(!empty($gallery['error']) && $gallery['error'] != 200) {
					//$this->set_alert("Couldn't retrieve file, please check your data. ERROR: " . $gallery['error_text'], 2);
		return;
	} 
	foreach($gallery['list'] as $value) {
		$url = str_replace('"', "", json_encode($value['url']));
		$name = str_replace('"', "", json_encode($value['name']));
		$string3 .= ", {text: '" . $name . " [" . $url . "]', value: '" . $url ."'}";
		$json_file = JSON_DIRECTORY_PATH . $url . '.json';
		$content = json_decode(file_get_contents($json_file), true);
        $images .= (isset($content['outfits'][0]['images']['outfit']['file']) ? ", '" . $url . "':'" . $content['outfits'][0]['images']['outfit']['file'] .  "'" : ", 'None':'None'");
	}
	$images .= '};';

$initArray['setup'] = $string1 . $images . $string2 . $string3 . $string4;
return $initArray;
}

function wpse18719_mce_buttons( $mce_buttons )
{
	$mce_buttons[] = 'h2';
	return $mce_buttons;
}
}
?>

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
	$plugin_array['karanga_galleries'] = TINYMCE_MAIN_JS_FILE_URL;
	return $plugin_array;
}

// Add the button key for address via JS
function register_tinymce_button( $buttons ) {

	array_push( $buttons, 'karanga_button' );
	return $buttons;
}

?>

( function() {
    tinymce.PluginManager.add( 'karanga_galleries', function( editor, url ) {

        editor.addButton('karanga_button', {
          title : 'Karanga Galleries shortcuts',
          text: 'Karanga Galleries',
          cmd: 'open_window'
      });

        editor.addCommand('open_window', function() { 
         editor.windowManager.open({
            title: 'Galleries',
            height: 420,
            width: 800,
            file: 

        });
     });
    })		
} )();