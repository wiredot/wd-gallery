<?php

namespace Wiredot\WPPG;

use Wiredot\Preamp\Twig;

class Skin_Directory {

	private $skins;

	private $active_skin = 'zurich';

	public function __construct() {
		$this->skins = $this->find_skins();
		$this->active_skin = $this->find_active_skin();

		add_action('admin_menu', array($this, 'add_skins_submenu'));

		if (isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['post_type']) && $_GET['post_type'] == 'wppg' && isset($_GET['page']) && $_GET['page'] == 'skins') {
			add_action('init', array($this, 'activate_skin'));
		}
	}

	private function find_skins() {
		return $this->find_skins_in_directory(WPPG_PATH.'/skins/');
	}

	private function find_skins_in_directory($directory) {
		$skins = array();

		if (file_exists($directory) && $handle = opendir($directory)) {

			// for each file with .config.php extension
			while (false !== ($filename = readdir($handle))) {

				if ($filename != '.' && $filename != '..' && is_dir(WPPG_PATH.'/skins/'.$filename)) {
					include WPPG_PATH.'/skins/'.$filename.'/config.php';
					$skins[$filename] = $wppg_skin_config;
					if (file_exists(WPPG_PATH.'/skins/'.$filename.'/screenshot.png')) {
						$skins[$filename]['screenshot'] = WPPG_URL.'/skins/'.$filename.'/screenshot.png';
					} else {
						$skins[$filename]['screenshot'] = '';
					}
				}
			}
			closedir($handle);
		}

		return $skins;
	}

	public function get_skins() {
		return $this->skins;	
	}

	public function get_active_skin() {
		return $this->active_skin;
	}

	private function find_active_skin() {
		$active_skin = get_option( 'wppg-active-skin' );
		if ( $active_skin ) {
			return $active_skin;
		}

		return 'milan';
	}

	public function activate_skin() {
		$nonce = $_REQUEST['_wpnonce'];
		$skin = $_GET['skin'];

		if (wp_verify_nonce( $nonce, 'wp-photo-gallery-activate-skin-'.$skin )) {
			update_option( 'wppg-active-skin', $skin );
		}

		wp_redirect( '?post_type=wppg&page=skins' );
		exit;
	}

	public function add_skins_submenu() {
		// add options page
		add_submenu_page( 
			'edit.php?post_type=wppg', 
			__( 'Skins', 'wp-photo-gallery' ),
			__( 'Skins', 'wp-photo-gallery' ),
			'read', 
			'skins', 
			array($this, 'skins_page')
		);
	}

	public function skins_page() {
		$Twig = new Twig;
		echo $Twig->twig->render('skins.html', array(
			'skins' => $this->skins,
			'active_skin' => $this->active_skin,
		));
	}

// end class
}