<?php

namespace Wiredot\WP_Photo_Gallery;

use Wiredot\Preamp\Twig;

class Settings {

	public function __construct() {
		
		add_action('admin_menu', array($this, 'add_settings_menu'));
	}

	public function add_settings_menu() {
		add_options_page(
			__('WP Photo Gallery'),
			__('WP Photo Gallery'),
			'manage_options',
			'wp-photo-gallery-settings',
			array($this, 'settings_page')
		);
	}

	public function settings_page() {
		$Twig = new Twig();
		echo $Twig->twig->render('settings.html');
	}

// class end
}