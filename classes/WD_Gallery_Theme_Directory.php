<?php

namespace WD_Gallery;

class WD_Gallery_Theme_Directory {

	private $themes;

	private $active_theme;

	public function __construct() {
		$this->themes = $this->find_themes();
		$this->active_theme = $this->find_active_theme();

		//print_r($this);
	}

	public function find_themes() {
		return $this->find_themes_in_directory(WD_GALLERY_PATH.'/themes/');
	}

	private function find_themes_in_directory($directory) {
		$themes = array();

		if (file_exists($directory) && $handle = opendir($directory)) {

			// for each file with .config.php extension
			while (false !== ($filename = readdir($handle))) {

				if ($filename != '.' && $filename != '..' && is_dir(WD_GALLERY_PATH.'/themes/'.$filename)) {
					$themes[] = $filename;
				}
			}
			closedir($handle);
		}

		return $themes;
	}

	public function get_themes($directory) {
		return $this->themes();	
	}

	public function get_active_theme() {
		return 'milan';
		return $this->active_theme;
	}

	public function find_active_theme() {
		$active_theme = get_option( 'wd-gallery-active-theme' );
		if ( $active_theme ) {
			return $active_theme;
		}

		return null;
	}


// class end
}