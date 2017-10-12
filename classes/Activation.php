<?php

namespace Wiredot\WP_GALLERY;

use Wiredot\Preamp\Core as Preamp;

class Activation {

	public function __construct() {
		register_post_type(
			'wp-gallery',
			array(
				'rewrite' => array( 'slug' => 'wp-gallery' ),
			)
		);
		flush_rewrite_rules( false );

		add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );
	}

	public function activated_plugin( $plugin ) {
		if ( WP_GALLERY_BASENAME == $plugin ) {
			wp_safe_redirect( admin_url( 'edit.php?post_type=wp-gallery&page=getting_started' ) );
			exit;
		}
	}

}
