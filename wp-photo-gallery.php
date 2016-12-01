<?php
/**
 * Plugin Name: WP Photo Gallery
 * Plugin URI:  http://wiredot.com/wp-photo-gallery
 * Description: WP Photo Gallery plugin
 * Author: WireDot Labs
 * Version: 1.1.0
 * Text Domain: wp-photo-gallery
 * Domain Path: /languages
 * Author URI: http://wiredot.com/
 * License: GPLv2 or later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// load composer libraries
require __DIR__ . '/vendor/autoload.php';

define( 'WPPG_PATH', dirname( __FILE__ ) );
define( 'WPPG_URL', plugin_dir_url( __FILE__ ) );
define( 'WPPG_BASENAME', plugin_basename( __FILE__ ) );
define( 'WPPG_NAME', dirname( plugin_basename( __FILE__ ) ) );

use Wiredot\WPPG\Core;

register_activation_hook( __FILE__, 'activate_wp-photo-gallery' );

function activate_wp_photo_gallery() {
	// return Core::activate();
}

function WPPG() {
	return Core::run();
}

WPPG();
