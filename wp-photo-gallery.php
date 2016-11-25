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

define( 'WP_PG_PATH', dirname( __FILE__ ) );
define( 'WP_PG_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_PG_BASENAME', plugin_basename( __FILE__ ) );
define( 'WP_PG_NAME', dirname( plugin_basename( __FILE__ ) ) );

use WP_PG\WP_PG;

register_activation_hook( __FILE__, 'activate_wp_pg' );

function activate_wp_pg() {
	return WD_PG::activate();
}

function WD_PG() {
	return WD_PG::run();
}

WD_PG();
