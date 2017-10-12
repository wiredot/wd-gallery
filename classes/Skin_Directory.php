<?php

namespace Wiredot\WP_GALLERY;

use Wiredot\Preamp\Twig;

class Skin_Directory {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_skins_submenu' ) );

		if ( isset( $_GET['action'] ) && 'activate' == $_GET['action'] && isset( $_GET['post_type'] ) && 'wp-gallery' == $_GET['post_type'] && isset( $_GET['page'] ) && 'skins' == $_GET['page'] ) {
			add_action( 'init', array( $this, 'activate_skin' ) );
		}
	}

	public function activate_skin() {
		$nonce = $_REQUEST['_wpnonce'];
		$skin = $_GET['skin'];

		if ( wp_verify_nonce( $nonce, 'wp-gallery-activate-skin-' . $skin ) ) {
			update_option( 'wp-gallery-active-skin-id', $skin );
		}

		set_transient( 'WP_GALLERY_message', __( 'Skin enabled.', 'wp-gallery' ), 2 );
		wp_redirect( '?post_type=wp-gallery&page=skins' );
		exit;
	}

	public function add_skins_submenu() {
		// add options page
		add_submenu_page(
			'edit.php?post_type=wp-gallery',
			__( 'Skins', 'wp-gallery' ),
			__( 'Skins', 'wp-gallery' ),
			'read',
			'skins',
			array( $this, 'skins_page' )
		);
	}

	public function skins_page() {
		$Skins = Skin_Factory::init();
		$Twig = new Twig;
		echo $Twig->twig->render(
			'skins.twig', array(
				'skins' => $Skins->get_skins(),
				'active_skin_id' => $Skins->get_active_skin_id(),
			)
		);
	}

}
