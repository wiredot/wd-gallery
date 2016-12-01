<?php

namespace Wiredot\WPPG;

use Wiredot\Preamp\Core as Preamp;

class Core {

	private static $instance = null;

	private function __construct() {
		$Preamp = Preamp::run(WPPG_PATH, WPPG_URL);
		// print_r(get_declared_classes());
		// add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );
		//$input = new Input('asd');
		// echo $input->html();
		if (is_admin()) {
			// init all admin functionality
			new Admin();
			new Editor();
			new Skin_Directory();
		} else {
			new Shortcode();
		}

		// // init Custom Post Type
		// new WPPG_CPT();

		// // init Meta Boxes
		// new WPPG_MB();
		
		// $WPPG_Theme_Directory = new WPPG_Theme_Directory();
		// $this->active_theme_name = $WPPG_Theme_Directory->get_active_theme();

		// $this->active_theme = new WPPG_Theme($this->active_theme_name);

		// // init shortcodes
		// new WPPG_Shortcode($this->active_theme);
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Core ) ) {
			self::$instance = new Core;
		}
		return self::$instance;
	}

	public static function activate() {
		$Preamp = Preamp::run(WPPG_PATH, WPPG_URL);
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

		if ($post->post_type == 'wppg') {
			$single_template = $this->plugin_dir . '/single-wppg.php';
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
