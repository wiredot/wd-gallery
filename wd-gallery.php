<?php
/**
 * Plugin Name: wd Gallery
 * Plugin URI:  http://wiredot.com/wd-gallery
 * Description: Photo Gallery 
 * Author: WireDot Labs
 * Version: 1.0.3
 * Text Domain: wd-gallery
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

define( 'WD_GALLERY_PATH', dirname( __FILE__ ) );
define( 'WD_GALLERY_URL', plugin_dir_url( __FILE__ ) );
define( 'WD_GALLERY_BASENAME', plugin_basename( __FILE__ ) );
define( 'WD_GALLERY_NAME', dirname( plugin_basename( __FILE__ ) ) );
use WD_Gallery\WD_Gallery;

register_activation_hook( __FILE__, 'activate_wd_gallery' );

function activate_wd_gallery() {
	return WD_Gallery::activate();
}

function WD_Gallery() {
	return WD_Gallery::run();
}

WD_Gallery();
