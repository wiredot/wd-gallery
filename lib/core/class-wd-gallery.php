<?php

class WD_Gallery {
	private $wd_g_path;

	public function __construct($plugin_file = '', $option_name = null) {
		$this->wd_g_path = dirname($plugin_file);

		spl_autoload_register(array($this, 'my_autoloader'));

		new WD_Gallery_CPT;
		new WD_Gallery_MB;
	}

	public function my_autoloader($class_name) {
		$class_filename = 'class-'.str_replace('_', '-', strtolower($class_name)).'.php';
		if (file_exists($this->wd_g_path.'/lib/core/'.$class_filename)) {
			include_once $this->wd_g_path.'/lib/core/'.$class_filename;
		}
	}



// class end	
}
