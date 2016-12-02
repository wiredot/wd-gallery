<?php

namespace Wiredot\WPPG;

use Wiredot\Preamp\Twig;

class Skin_Directory {

	private $skins;

	private $active_skin_id = 'zurich';

	private $active_skin_object;

	public function __construct() {
		$this->skins = $this->find_skins();
		$active_skin_id = $this->find_active_skin_id();

		if ($active_skin_id) {
			$this->active_skin_id = $active_skin_id;
		}
		
		$active_skin = $this->skins[$this->active_skin_id];
		$Active_Skin = new Skin($active_skin['id'], $active_skin['css'], $active_skin['js'], $active_skin['directory'], $active_skin['url']);

		$this->active_skin_object = $Active_Skin;

		add_action('admin_menu', array($this, 'add_skins_submenu'));

		if (isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['post_type']) && $_GET['post_type'] == 'wp-photo-gallery' && isset($_GET['page']) && $_GET['page'] == 'skins') {
			add_action('init', array($this, 'activate_skin'));
		}
	}

	private function find_skins() {
		return $this->find_skins_in_directory(WPPG_PATH.'/skins/', WPPG_URL.'skins/');
	}

	private function find_skins_in_directory($directory, $url) {
		$skins = array();

		if (file_exists($directory) && $handle = opendir($directory)) {

			// for each file with .config.php extension
			while (false !== ($filename = readdir($handle))) {

				if ($filename != '.' && $filename != '..' && is_dir($directory.$filename)) {
					include $directory.$filename.'/config.php';
					$skins[$filename] = $wp_photo_gallery_skin_config;
					if (file_exists($directory.$filename.'/screenshot.png')) {
						$skins[$filename]['screenshot'] = $url.$filename.'/screenshot.png';
					} else {
						$skins[$filename]['screenshot'] = '';
					}
					$skins[$filename]['directory'] = $directory.$filename;
					$skins[$filename]['url'] = $url.$filename;
				}
			}
			closedir($handle);
		}

		return $skins;
	}

	private function find_active_skin_id() {
		$active_skin_id = get_option( 'wp-photo-gallery-active-skin-id' );
		if ( $active_skin_id ) {
			return $active_skin_id;
		}

		return null;
	}

	public function get_active_skin_object() {
		return $this->active_skin_object;
	}

	public function activate_skin() {
		$nonce = $_REQUEST['_wpnonce'];
		$skin = $_GET['skin'];

		if (wp_verify_nonce( $nonce, 'wp-photo-gallery-activate-skin-'.$skin )) {
			update_option( 'wp-photo-gallery-active-skin-id', $skin );
		}

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
		$Twig = new Twig;
		echo $Twig->twig->render('skins.html', array(
			'skins' => $this->skins,
			'active_skin_id' => $this->active_skin_id,
		));
	}

// end class
}