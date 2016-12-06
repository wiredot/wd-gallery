<?php

namespace Wiredot\WP_Photo_Gallery;

class Help {

	public function __construct() {
		add_action('admin_head', array( $this, 'help_tab'));
	}

	public function help_tab() {

		$screen = get_current_screen();

		// Return early if we're not on the book post type.
		if ( 'wp-photo-gallery' != $screen->post_type ) {
			return;
		}

		// Setup help tab args.
		$args = array(
			'id'      => 'wp-photo-gallery-getting-started',
			'title'   => __('Getting Started', 'wp-photo-gallery'),
			'content' => '<h3>'.__('Getting Started', 'wp-photo-gallery').'</h3>
				<p>Follow the instructions on <a href="'.admin_url('index.php?page=wp-photo-gallery-welcome').'">this page</a>.</p>
			',
		);

		// Add the help tab.
		$screen->add_help_tab( $args );

		// Setup help tab args.
		$args = array(
			'id'      => 'wp-photo-gallery-support',
			'title'   => __('Support', 'wp-photo-gallery'),
			'content' => '<h3>'.__('Support', 'wp-photo-gallery').'</h3>
				<p>If you have a question or need help, check out our <a href="'.admin_url('index.php?page=wp-photo-gallery-welcome&tab=support').'">support page</a>.</p>
			',
		);

		// Add the help tab.
		$screen->add_help_tab( $args );

		// Setup help tab args.
		$args = array(
			'id'      => 'wp-photo-gallery-credits',
			'title'   => __('Credits', 'wp-photo-gallery'),
			'content' => '<h3>'.__('Credits', 'wp-photo-gallery').'</h3>
				<p>Want to learn more about the authors of WP Photo Gallery? Go to <a href="'.admin_url('index.php?page=wp-photo-gallery-welcome&tab=credits').'">this page</a> for more info.</p>
			',
		);

		// Add the help tab.
		$screen->add_help_tab( $args );
	}

}