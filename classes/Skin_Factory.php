<?php

namespace Wiredot\WP_Photo_Gallery;

use Wiredot\Preamp\Twig;

class Skin_Factory {

	private static $instance = null;

	private $skins;

	private $active_skin_id = 'zurich';

	private function __construct() {
		$this->skins = $this->find_skins();

		$active_skin_id = $this->find_active_skin_id();

		if ($active_skin_id) {
			$this->active_skin_id = $active_skin_id;
		}

		add_action('wp_enqueue_scripts', array($this, 'init_skins'));
	}

	public static function init() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Skin_Factory ) ) {
			self::$instance = new Skin_Factory;
		}
		return self::$instance;
	}

	public function init_skins() {
		$active_skin_id = $this->find_active_skin_id();

		if ($active_skin_id) {
			$this->active_skin_id = $active_skin_id;
		}

		$active_skin = $this->skins[$this->active_skin_id];
		$Active_Skin = new Skin($active_skin);

		$this->active_skin_object = $Active_Skin;
	}

	private function find_skins() {
		return $this->find_skins_in_directory(WP_PHOTO_GALLERY_PATH.'/skins/', WP_PHOTO_GALLERY_URL.'skins/');
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
		if (get_the_id()) {
			$active_skin_id = get_post_meta( get_the_id(), 'wppg-skin', true );
		}

		if ( ! isset($active_skin_id) || ! $active_skin_id ) {
			$active_skin_id = get_option( 'wp-photo-gallery-active-skin-id' );
		}

		if ( $active_skin_id ) {
			return $active_skin_id;
		}

		return null;
	}

	public function get_active_skin_object() {
		return $this->active_skin_object;
	}

	public function get_skin_object($skin_id) {
		if ( ! isset($this->skins[$skin_id])) {
			return null;
		}

		$skin = $this->skins[$skin_id];
		return new Skin($skin);
	}

	public function get_skins() {
		return $this->skins;
	}

	public function get_active_skin_id() {
		return $this->active_skin_id;
	}

}