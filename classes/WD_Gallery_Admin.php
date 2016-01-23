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
		add_options_page(
			_x( 'wd Gallery', 'post type general name', 'wd-gallery' ), 
			_x( 'wd Gallery', 'admin menu', 'wd-gallery' ), 
			'edit_users', 
			WD_GALLERY_NAME.'-menu', 
			array($this, 'template_options_page')
		);
	}

	public function template_options_page() {
		
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
		echo $file;
		//exit;
		if ($file == WD_GALLERY_BASENAME) {
			
			// settings link
			$settings_link = "<a href='options-general.php?page=" . WD_GALLERY_NAME . "-menu'>" . __('Settings') . "</a>";
			
			// add settings link to plugin info section
			array_unshift($links, $settings_link);
		}
		return $links;
	}

// end class
}