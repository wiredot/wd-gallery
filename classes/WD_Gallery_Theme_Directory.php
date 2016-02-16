<?php

namespace WD_Gallery;

class WD_Gallery_Theme_Directory {

	private $themes;

	private $active_theme = 'zurich';

	public function __construct() {
		$this->themes = $this->find_themes();
		$this->active_theme = $this->find_active_theme();

		add_action('admin_menu', array($this, 'add_themes_submenu'));

		if (isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['post_type']) && $_GET['post_type'] == 'wd_gallery' && isset($_GET['page']) && $_GET['page'] == 'themes') {
			add_action('init', array($this, 'activate_theme'));
		}
	}

	private function find_themes() {
		return $this->find_themes_in_directory(WD_GALLERY_PATH.'/themes/');
	}

	private function find_themes_in_directory($directory) {
		$themes = array();

		if (file_exists($directory) && $handle = opendir($directory)) {

			// for each file with .config.php extension
			while (false !== ($filename = readdir($handle))) {

				if ($filename != '.' && $filename != '..' && is_dir(WD_GALLERY_PATH.'/themes/'.$filename)) {
					include WD_GALLERY_PATH.'/themes/'.$filename.'/config.php';
					$themes[$filename] = $wdg_theme_config;
					if (file_exists(WD_GALLERY_PATH.'/themes/'.$filename.'/screenshot.png')) {
						$themes[$filename]['screenshot'] = WD_GALLERY_URL.'/themes/'.$filename.'/screenshot.png';
					} else {
						$themes[$filename]['screenshot'] = '';
					}
				}
			}
			closedir($handle);
		}

		return $themes;
	}

	public function get_themes() {
		return $this->themes;	
	}

	public function get_active_theme() {
		return $this->active_theme;
	}

	private function find_active_theme() {
		$active_theme = get_option( 'wd-gallery-active-theme' );
		if ( $active_theme ) {
			return $active_theme;
		}

		return 'milan';
	}

	public function activate_theme() {
		$nonce = $_REQUEST['_wpnonce'];
		$theme = $_GET['theme'];

		if (wp_verify_nonce( $nonce, 'wd-gallery-activate-theme-'.$theme )) {
			update_option( 'wd-gallery-active-theme', $theme );
		}

		wp_redirect( '?post_type=wd_gallery&page=themes' );
		exit;
	}

	public function add_themes_submenu() {
		// add options page
		add_submenu_page( 
			'edit.php?post_type=wd_gallery', 
			__( 'Themes', 'wd-gallery' ),
			__( 'Themes', 'wd-gallery' ),
			'read', 
			'themes', 
			array($this, 'themes_page')
		);
	}

	public function themes_page() {
		$smarty = (new WD_Gallery_Smarty)->get_smarty();
		$smarty->assign('active_theme', $this->get_active_theme());
		$smarty->assign('themes', $this->get_themes());
		$smarty->display('themes.html');
	}

// class end
}