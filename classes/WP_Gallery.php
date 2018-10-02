<?php

namespace Wiredot\WP_Gallery;

use Wiredot\Copernicus\CP;

class WP_Gallery {

	private static $instance = null;

	private static $settings;

	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

		$CP = CP::run( WP_GALLERY_PATH, WP_GALLERY_URL );

		self::$settings = get_option( 'wp-gallery' );

		if ( is_admin() ) {
			// init all admin functionality
			new Admin();
			new Editor();
			new Settings();
			new Welcome();
			new Help();
		} else {
			new Shortcode();
		}
	}

	public static function run() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Gallery ) ) {
			self::$instance = new WP_Gallery;
		}
		return self::$instance;
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wp-gallery',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	public static function get_settings( $option = null ) {
		if ( isset( self::$settings[ $option ] ) ) {
			return self::$settings[ $option ];
		}

		return null;
	}
}
