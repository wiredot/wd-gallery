<?php

namespace Wiredot\WP_GALLERY;

use Wiredot\Preamp\Twig;
use WP_Query;

class Editor {

	public function __construct() {
		add_action( 'media_buttons', array( $this, 'add_media_button' ), 999 );
		add_action( 'admin_footer', array( $this, 'add_media_button_content' ) );
	}

	public function add_media_button() {
		$Twig = new Twig;
		echo $Twig->twig->render( 'media-button.twig' );
	}

	public function add_media_button_content() {
		$Twig = new Twig;
		echo $Twig->twig->render( 'media-button-content.twig' );
	}

}
