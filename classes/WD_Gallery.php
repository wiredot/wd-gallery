<?php

namespace WD_Gallery;

use WD_Gallery\WD_Gallery_Admin;

class WD_Gallery {

	private static $instance = null;

	private function __construct() {
		if (is_admin()) {
			$WD_Gallery_Admin = new WD_Gallery_Admin();
		}

		// // add activation & deactivation actions
		// add_action('activate_' . $this->plugin_basename, array($this, 'activate'));
		// add_action('deactivate_' . $this->plugin_basename, array($this, 'deactivate'));

		//add_filter( 'single_template', array($this, 'get_custom_post_type_template' ));
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WD_Gallery ) ) {
			self::$instance = new WD_Gallery;
		}
		return self::$instance;
	}

	public function activate() {
		$WD_Gallery_CPT = new WD_Gallery_CPT;
		$WD_Gallery_CPT->create_post_type();
		flush_rewrite_rules();

		$this->init_directory(WP_CONTENT_DIR.'/cache');
		$this->init_directory(WP_CONTENT_DIR.'/cache/wd_gallery');
		$this->init_directory(WP_CONTENT_DIR.'/cache/wd_gallery/templates_c');
		$this->init_directory(WP_CONTENT_DIR.'/cache/wd_gallery/smarty');
	}

	public function deactivate() {
	}

	private function init_directory($dir) {
		if ( ! file_exists($dir)) {
			mkdir($dir, 0755);
		}
	}

	public function get_custom_post_type_template($single_template) {
		global $post;

		if ($post->post_type == 'wd_gallery') {
			$single_template = $this->plugin_dir . '/single-wd_gallery.php';
		}
		return $single_template;
	}

// class end	
}
