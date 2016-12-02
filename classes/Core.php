<?php

namespace Wiredot\WP_Photo_Gallery;

use Wiredot\Preamp\Core as Preamp;

class Core {

	private static $instance = null;

	private function __construct() {
		$Preamp = Preamp::run(WP_PHOTO_GALLERY_PATH, WP_PHOTO_GALLERY_URL);
		// print_r(get_declared_classes());
		// add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );
		//$input = new Input('asd');
		// echo $input->html();
		
		new Skin_Directory();
		
		if (is_admin()) {
			// init all admin functionality
			new Admin();
			new Editor();
		} else {
			new Shortcode();
		}

		// // init Custom Post Type
		// new WP_Photo_Gallery_CPT();

		// // init Meta Boxes
		// new WP_Photo_Gallery_MB();
		
		// $WP_Photo_Gallery_Theme_Directory = new WP_Photo_Gallery_Theme_Directory();
		// $this->active_theme_name = $WP_Photo_Gallery_Theme_Directory->get_active_theme();

		// $this->active_theme = new WP_Photo_Gallery_Theme($this->active_theme_name);

		// // init shortcodes
		// new WP_Photo_Gallery_Shortcode($this->active_theme);
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Core ) ) {
			self::$instance = new Core;
		}
		return self::$instance;
	}

	public static function activate() {
		$Preamp = Preamp::run(WP_PHOTO_GALLERY_PATH, WP_PHOTO_GALLERY_URL);
		flush_rewrite_rules();

		self::init_directory(WP_CONTENT_DIR.'/cache');
		self::init_directory(WP_CONTENT_DIR.'/cache/wp-photo-gallery');
		self::init_directory(WP_CONTENT_DIR.'/cache/wp-photo-gallery/templates_c');
		self::init_directory(WP_CONTENT_DIR.'/cache/wp-photo-gallery/smarty');
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

		if ($post->post_type == 'wp-photo-gallery') {
			$single_template = $this->plugin_dir . '/single-wp-photo-gallery.php';
		}
		return $single_template;
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wp-photo-gallery',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

// class end	
}
