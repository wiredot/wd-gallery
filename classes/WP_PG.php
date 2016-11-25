<?php

namespace WP_PG;

use Wiredot\Preamp\Core;
use Wiredot\Preamp\Fields\Input;

class WP_PG {

	private static $instance = null;

	private $active_theme_name;

	public $active_theme;

	private function __construct() {
		$Preamp = Core::run(WD_GALLERY_PATH.'/config/');
		// print_r(get_declared_classes());
		// add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain') );
		//$input = new Input('asd');

		// echo $input->html();
		// if (is_admin()) {
		// 	// init all admin functionality
		// 	new WP_PG_Admin();
		// }

		// // init Custom Post Type
		// new WP_PG_CPT();

		// // init Meta Boxes
		// new WP_PG_MB();
		
		// $WP_PG_Theme_Directory = new WP_PG_Theme_Directory();
		// $this->active_theme_name = $WP_PG_Theme_Directory->get_active_theme();

		// $this->active_theme = new WP_PG_Theme($this->active_theme_name);

		// // init shortcodes
		// new WP_PG_Shortcode($this->active_theme);
	}

	public function get_active_theme() {
		return $this->active_theme_name;
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_PG ) ) {
			self::$instance = new WP_PG;
		}
		return self::$instance;
	}

	public static function activate() {
		$WP_PG_CPT = new WP_PG_CPT;
		$WP_PG_CPT->create_post_type();
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

		if ($post->post_type == 'wp_pg') {
			$single_template = $this->plugin_dir . '/single-wp_pg.php';
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
