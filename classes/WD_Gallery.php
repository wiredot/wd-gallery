<?php

namespace WD_Gallery;

class WD_Gallery {

	private static $instance = null;

	private $active_theme_name;

	public $active_theme;

	private function __construct() {
		add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );

		if (is_admin()) {
			// init all admin functionality
			new WD_Gallery_Admin();
		}

		// init Custom Post Type
		new WD_Gallery_CPT();

		// init Meta Boxes
		new WD_Gallery_MB();
		
		$WD_Gallery_Theme_Directory = new WD_Gallery_Theme_Directory();
		$this->active_theme_name = $WD_Gallery_Theme_Directory->get_active_theme();

		$this->active_theme = new WD_Gallery_Theme($this->active_theme_name);

		// init shortcodes
		new WD_Gallery_Shortcode($this->active_theme);
	}

	public function get_active_theme() {
		return $this->active_theme_name;
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WD_Gallery ) ) {
			self::$instance = new WD_Gallery;
		}
		return self::$instance;
	}

	public static function activate() {
		$WD_Gallery_CPT = new WD_Gallery_CPT;
		$WD_Gallery_CPT->create_post_type();
		flush_rewrite_rules();

		self::init_directory(WP_CONTENT_DIR.'/cache');
		self::init_directory(WP_CONTENT_DIR.'/cache/wd-gallery');
		self::init_directory(WP_CONTENT_DIR.'/cache/wd-gallery/templates_c');
		self::init_directory(WP_CONTENT_DIR.'/cache/wd-gallery/smarty');
	}

	public function deactivate() {
	}

	private static function init_directory($dir) {
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

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wd-gallery',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

// class end	
}
