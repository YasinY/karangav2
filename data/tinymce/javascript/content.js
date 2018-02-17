jQuery(document).ready(function() { 
	jQuery('button').on('click', function() {
		parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, '[karanga url="' + this.value + '"]');
		parent.tinyMCE.activeEditor.windowManager.close(this);
	});

 });