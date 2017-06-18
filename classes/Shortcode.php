<?php

namespace Wiredot\WP_GALLERY;

use Wiredot\Preamp\Twig;

class Shortcode {

	public function __construct() {
		add_shortcode('wp-photo-gallery', array($this, 'show_shortcode' ));
	}

	public function show_shortcode($atts) {
		if (is_array($atts) && array_key_exists('id', $atts)) {
			$Gallery_Single = new Gallery_Single($atts['id']);
			return $Gallery_Single->get_single();
		} else {
			$Gallery_List = new Gallery_List();
			return $Gallery_List->get_list();
		}
	}
	
}