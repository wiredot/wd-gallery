<?php

namespace WP_PG;

class WP_PG_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array($this, 'admin_css') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_js') );

		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
	}

	public function admin_css() {
		wp_enqueue_style( 'wp_pg', WP_PG_URL . 'assets/css/wp-photo-gallery.css' );
	}

	public function admin_js() {
		wp_enqueue_script( 'wp_pg', WP_PG_URL . 'assets/js/wp-photo-gallery.js', array('jquery'), '1.0.0', true );
	}

	public function add_action_links($links, $file) {
		// run for this plugin
		if ($file == WP_PG_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wp_pg&page=themes'>" . __('Themes', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

// end class
}