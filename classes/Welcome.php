<?php

namespace Wiredot\WP_Gallery;

use Wiredot\Copernicus\Twig\Twig;

class Welcome {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
	}

	public function add_admin_menus() {
		add_submenu_page(
			'edit.php?post_type=wp-gallery',
			__( 'Getting Started', 'wp-gallery' ),
			__( 'Getting Started', 'wp-gallery' ),
			'read',
			'getting_started',
			array( $this, 'welcome_page' )
		);
	}

	public function welcome_page() {
		if ( isset( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'getting-started';
		}

		$Twig = new Twig();
		echo $Twig->twig->render(
			'welcome.twig', array(
				'tab' => $tab,
			)
		);
	}

}
