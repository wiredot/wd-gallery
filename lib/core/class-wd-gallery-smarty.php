<?php

class WD_Gallery_Smarty {

	public $smarty;

	public function __construct() {
		global $WD_Gallery;

		$template_dirs[] = $WD_Gallery->plugin_dir . '/templates/';
		$plugins_dirs[] = $WD_Gallery->plugin_dir . '/lib/smarty-plugins/';

		$template_dirs[] = get_stylesheet_directory() . '/templates/';
		$plugins_dirs[] = get_stylesheet_directory() . '/lib/smarty-plugins/';

		$this->smarty = new Smarty();
		$this->smarty->addPluginsDir($plugins_dirs);
		$this->smarty->setTemplateDir($template_dirs);

		$this->smarty->setCompileDir(WP_CONTENT_DIR . '/cache/wd_gallery/templates_c/');
		$this->smarty->setCacheDir(WP_CONTENT_DIR . '/cache/wd_gallery/smarty/');

		$this->smarty->registerFilter('pre', array($this, 'block_loop_literal'));

		$this->smarty->force_compile = true;
	}

	public function block_loop_literal($tpl_source, $template) {
    	$tpl_source = preg_replace("/({loop .*})/", '$1{literal}', $tpl_source);
    	$tpl_source = preg_replace("/({loop})/", '$1{literal}', $tpl_source);
    	$tpl_source = preg_replace("/({\/loop})/", '{/literal}$1', $tpl_source);
    	return $tpl_source;
	}

// class end
}