<?php

namespace WD_Gallery;

use Smarty;

class WD_Gallery_Smarty {

	private $template_dirs = array();
	private $plugins_dirs = array();
	private $compile_dirs = array();
	private $cache_dirs = array();

	private $smarty;

	public function __construct($template = WD_GALLERY_PATH . '/templates/') {
		$template_dirs[] = $template;
		$plugins_dirs[] = WD_GALLERY_PATH . '/smarty-plugins/';

		$this->smarty = new Smarty();
		$this->smarty->addPluginsDir($plugins_dirs);
		$this->smarty->setTemplateDir($template_dirs);
		$this->smarty->setCompileDir(WP_CONTENT_DIR . '/cache/wd-gallery/templates_c/');
		$this->smarty->setCacheDir(WP_CONTENT_DIR . '/cache/wd-gallery/smarty/');

		$this->smarty->registerFilter('pre', array($this, 'block_loop_literal'));

		$this->smarty->force_compile = true;
	}

	public function get_smarty() {
		return $this->smarty;
	}

	public function block_loop_literal($tpl_source, $template) {
    	$tpl_source = preg_replace("/({loop .*})/", '$1{literal}', $tpl_source);
    	$tpl_source = preg_replace("/({loop})/", '$1{literal}', $tpl_source);
    	$tpl_source = preg_replace("/({\/loop})/", '{/literal}$1', $tpl_source);
    	return $tpl_source;
	}

// class end
}