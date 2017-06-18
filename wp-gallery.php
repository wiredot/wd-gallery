<?php
/**
 * Plugin Name: WP Gallery
 * Plugin URI:  https://wiredot.com/wp-photo-gallery/
 * Description: WP Gallery plugin
 * Author: WireDot Labs
 * Version: 1.1.0
 * Text Domain: wp-photo-gallery
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

register_activation_hook( __FILE__, 'activate_WP_GALLERY' );

function activate_WP_GALLERY() {
	return new Activation;
}

function WP_GALLERY() {
	return Core::run();
}

WP_GALLERY();
