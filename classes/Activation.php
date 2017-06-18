<?php

namespace Wiredot\WP_GALLERY;

use Wiredot\Preamp\Core as Preamp;

class Activation {

	public function __construct() {
		register_post_type( 'wp-photo-gallery', 
			array(
				'rewrite' => array( 'slug' => 'wp-photo-gallery' ),
			)
		);
		flush_rewrite_rules(false);

		add_action( 'activated_plugin', array($this, 'activated_plugin' ));
	}

	public function activated_plugin( $plugin ) {
		if ( $plugin == WP_GALLERY_BASENAME ) {
			wp_safe_redirect( admin_url('index.php?page=wp-photo-gallery-welcome&activate=1') );
			exit;
		}
	}

}