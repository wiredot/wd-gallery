<?php

namespace WD_Gallery;

class WD_Gallery_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array($this, 'admin_css') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_js') );

		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
	}

	public function admin_css() {
		wp_enqueue_style( 'wd_gallery', WD_GALLERY_URL . 'assets/css/wd-gallery.css' );
	}

	public function admin_js() {
		wp_enqueue_script( 'wd_gallery', WD_GALLERY_URL . 'assets/js/wd-gallery.js', array('jquery'), '1.0.0', true );
	}

	public function add_action_links($links, $file) {
		// run for this plugin
		if ($file == WD_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wd_gallery&page=themes'>" . __('Themes', 'wd-gallery') . "</a>";
		}
		return $links;
	}

// end class
}