<?php

namespace WD_Gallery;

class WD_Gallery_Theme {

	public $name;

	public $css;

	public $js;

	public function __construct($name) {
		$this->name = $name;
		$this->get_theme_config();
	}

	public function get_theme_config() {
		$config_file = WD_GALLERY_PATH.'/themes/'.$this->name.'/'.$this->name.'.config.php';

		if (file_exists($config_file)) {
			require $config_file;
			print_r($wdg_theme_config);

			if (isset($wdg_theme_config['css'])) {
				$this->css = $wdg_theme_config['css'];
			}
		
			if (isset($wdg_theme_config['js'])) {
				$this->js = $wdg_theme_config['js'];
			}
		}
	}

// class end
}