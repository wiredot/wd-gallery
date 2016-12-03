<?php

namespace Wiredot\WP_Photo_Gallery;

class Welcome {

	public function __construct() {
		add_action( 'activated_plugin', array($this, 'welcome' ));
	}

	public static function welcome( $plugin ) {
		if ( $plugin == WP_PHOTO_GALLERY_BASENAME ) {
			wp_safe_redirect( admin_url('index.php?page=wp-photo-gallery-welcome&activate=1') );
			exit;
		}
	}

// end class
}