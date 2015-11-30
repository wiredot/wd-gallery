<?php

class WD_Gallery_CPT {

	public function __construct() {
		add_action( 'init', array( $this, 'create_post_type' ) );
	}

	public function create_post_type() {
		register_post_type( 'wd_gallery',
			array(
				'labels' => array(
					'name' => __( 'wd Gallery' ),
					'singular_name' => __( 'wd Gallery' )
				),
				'public' => true,
				'has_archive' => true,
			)
		);
	}
}