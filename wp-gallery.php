<?php
/**
 * Plugin Name: WP Gallery
 * Plugin URI:  https://wiredot.com/wp-gallery/
 * Description: WP Gallery plugin
 * Author: WireDot Labs
 * Version: 1.1.0
 * Text Domain: wp-gallery
 * Domain Path: /languages
 * Author URI: https://wiredot.com/labs/
 * License: GPLv2 or later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// load composer libraries
require __DIR__ . '/vendor/autoload.php';

define( 'WP_GALLERY_PATH', dirname( __FILE__ ) );
define( 'WP_GALLERY_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_GALLERY_BASENAME', plugin_basename( __FILE__ ) );
define( 'WP_GALLERY_NAME', dirname( plugin_basename( __FILE__ ) ) );

use Wiredot\WP_GALLERY\Core;
use Wiredot\WP_GALLERY\Activation;

register_activation_hook( __FILE__, 'activate_wp_gallery' );

function activate_wp_gallery() {
	return new Activation;
}

function wp_gallery() {
	return Core::run();
}

wp_gallery();
