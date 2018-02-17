<?php 
class HandleShortcode {

	function __construct() {
		add_shortcode('karanga', array($this, 'pull_quote_shortcode'));
	}
	function pull_quote_shortcode( $atts ) {
		$output = '';
		$attributtes = shortcode_atts( array(
			'url' => 'none',
			), $atts );
		$url = wp_kses_post( $attributtes['url'] );
		$gallery = UtilMethods::handle_article_list($url);
		foreach($gallery['outfits'] as $outfit) {
			$output .= '<li>';
			$output .= '<img class="gallery-image" src="' . $outfit['images']['outfit']['file'] . '" alt="" />';
			$output .= '<span class="text-content"> <span> ' . $outfit['name'] . ' </span> </span>';
			$output .= '</li>';
		}
		$output = '<ul class="img-list"> ' . $output;
		$output .= '</ul>';
		return $output;
	}
}
?>