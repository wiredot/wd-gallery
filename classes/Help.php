<?php

namespace Wiredot\WP_GALLERY;

class Help {

	public function __construct() {
		add_action( 'admin_head', array( $this, 'help_tab' ) );
	}

	public function help_tab() {

		$screen = get_current_screen();

		// Return early if we're not on the book post type.
		if ( 'wp-gallery' != $screen->post_type ) {
			return;
		}

		// Setup help tab args.
		$args = array(
			'id'      => 'wp-gallery-getting-started',
			'title'   => __( 'Getting Started', 'wp-gallery' ),
			'content' => '<h3>' . __( 'Getting Started', 'wp-gallery' ) . '</h3>
				<p>' . sprintf( __( 'Follow the instructions on <a href="%s">this page</a>.', 'wp-gallery' ), admin_url( 'index.php?page=wp-gallery-welcome' ) ) . '</p>
			',
		);

		// Add the help tab.
		$screen->add_help_tab( $args );

		// Setup help tab args.
		$args = array(
			'id'      => 'wp-gallery-support',
			'title'   => __( 'Support', 'wp-gallery' ),
			'content' => '<h3>' . __( 'Support', 'wp-gallery' ) . '</h3>
				<p>' . sprintf( __( 'If you have a question or need help, check out our <a href="%s" target="_blank">support page</a>.', 'wp-gallery' ), admin_url( 'index.php?page=wp-gallery-welcome&tab=support' ) ) . '</p>
			',
		);

		// Add the help tab.
		$screen->add_help_tab( $args );

		// Setup help tab args.
		$args = array(
			'id'      => 'wp-gallery-credits',
			'title'   => __( 'Credits', 'wp-gallery' ),
			'content' => '<h3>' . __( 'Credits', 'wp-gallery' ) . '</h3>
				<p>' . sprintf( __( 'Want to learn more about the authors of WP Gallery? Go to <a href="%s">this page</a> for more info.', 'wp-gallery' ), admin_url( 'index.php?page=wp-gallery-welcome&tab=credits' ) ) . '</p>
			',
		);

		// Add the help tab.
		$screen->add_help_tab( $args );
	}

}
