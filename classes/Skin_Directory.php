<?php

namespace Wiredot\WP_Photo_Gallery;

use Wiredot\Preamp\Twig;

class Skin_Directory {

	public function __construct() {
		add_action('admin_menu', array($this, 'add_skins_submenu'));

		if (isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['post_type']) && $_GET['post_type'] == 'wp-photo-gallery' && isset($_GET['page']) && $_GET['page'] == 'skins') {
			add_action('init', array($this, 'activate_skin'));
		}
	}

	public function activate_skin() {
		$nonce = $_REQUEST['_wpnonce'];
		$skin = $_GET['skin'];

		if (wp_verify_nonce( $nonce, 'wp-photo-gallery-activate-skin-'.$skin )) {
			update_option( 'wp-photo-gallery-active-skin-id', $skin );
		}

		set_transient( 'wp_photo_gallery_message', __('Skin enabled.', 'wp-photo-gallery'), 2 );
		wp_redirect( '?post_type=wp-photo-gallery&page=skins' );
		exit;
	}

	public function add_skins_submenu() {
		// add options page
		add_submenu_page( 
			'edit.php?post_type=wp-photo-gallery', 
			__( 'Skins', 'wp-photo-gallery' ),
			__( 'Skins', 'wp-photo-gallery' ),
			'read', 
			'skins', 
			array($this, 'skins_page')
		);
	}

	public function skins_page() {
		$Skins = Skin_Factory::init();
		$Twig = new Twig;
		echo $Twig->twig->render('skins.html', array(
			'skins' => $Skins->get_skins(),
			'active_skin_id' => $Skins->get_active_skin_id(),
		));
	}

// end class
}