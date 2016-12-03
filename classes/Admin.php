<?php

namespace Wiredot\WP_Photo_Gallery;

class Admin {

	public function __construct() {
		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
		add_filter('plugin_row_meta', array($this, 'add_row_meta'), 10, 2);
		add_action('save_post', array($this, 'add_shortcode'), 10, 2);
		add_action( 'admin_menu', array( $this, 'add_admin_menus') );
	}

	public function add_action_links($links, $file) {
		// run for this plugin
		if ($file == WP_PHOTO_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wp-photo-gallery&page=skins'>" . __('Skins', 'wp-photo-gallery') . "</a>";
			$links[] = "<a href='edit.php?post_type=wp-photo-gallery&page=skins'>" . __('Settings', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

	public function add_row_meta($links, $file) {
		// run for this plugin
		if ($file == WP_PHOTO_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='index.php?page=wp-photo-gallery-welcome'>" . __('Getting Started', 'wp-photo-gallery') . "</a>";
			$links[] = "<a href='edit.php?post_type=wp-photo-gallery&page=skins'>" . __('Support', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

	public function show_shortcode($atts) {
		if (is_array($atts) && array_key_exists('id', $atts)) {
			$Gallery_Single = new Gallery_Single($atts['id']);
			return $Gallery_Single->get_single();
		} else {
			$Gallery_List = new Gallery_List();
			return $Gallery_List->get_list();
		}
	}

	public function add_shortcode($post_id, $post) {
		if ($post->post_type == 'wp-photo-gallery') {
			global $wpdb;
			
			$wpdb->update(
				$wpdb->posts,
				array(
					'post_content' => '[wp-photo-gallery id='.$post_id.']'
				),
				array(
					'ID' => $post_id
				)
			);
		}
	}

	public function add_admin_menus() {
		add_dashboard_page(
			__( 'Welcome to WP Photo Gallery', 'wp-photo-gallery' ),
			__( 'Welcome to WP Photo Gallery', 'wp-photo-gallery' ),
			'manage_options',
			'wp-photo-gallery-welcome',
			array( $this, 'welcome_page' )
		);

		remove_submenu_page( 'index.php', 'wp-photo-gallery-welcome' );
	}

	public function welcome_page() {
		echo 'asd';
	}

// end class
}