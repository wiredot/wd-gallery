<?php

namespace WD_Gallery;

class WD_Gallery_Admin {

	public function __construct() {
		add_action('admin_menu', array($this, 'admin_menu'));

		add_action( 'admin_enqueue_scripts', array($this, 'admin_css') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_js') );

		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);
	}

	public function admin_menu() {
		// add options page
		add_submenu_page( 
			'edit.php?post_type=wd_gallery', 
			'themesss', 
			__( 'Themes', 'wd-gallery' ),
			'read', 
			'themes', 
			array($this, 'template_themes_page')
		);
	}

	public function template_themes_page() {
		
		echo 'asd';
	}

	public function admin_css() {
		wp_enqueue_style( 'wd_gallery', WD_GALLERY_URL . 'assets/css/wd_gallery.css' );
	}

	public function admin_js() {
		wp_enqueue_script( 'wd_gallery', WD_GALLERY_URL . 'assets/js/wd_gallery.js', array('jquery'), '1.0.0', true );
	}

	public function action_links($links, $file) {
		// run for this plugin
		if ($file == WD_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wd_gallery&page=themes'>" . __('Themes', 'wd-gallery') . "</a>";
		}
		return $links;
	}

// end class
}