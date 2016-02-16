<?php

namespace WD_Gallery;

use Smarty;

class WD_Gallery_Smarty {

	private $template_dirs = array();
	private $plugins_dirs = array();
	private $compile_dirs = array();
	private $cache_dirs = array();

	private $smarty;

	public function __construct($template = null) {
		if ( ! $template ) {
			$template = WD_GALLERY_PATH . '/templates/';
		}
		
		$template_dirs[] = $template;
		$plugins_dirs[] = WD_GALLERY_PATH . '/smarty-plugins/';

		$this->smarty = new Smarty();
		$this->smarty->addPluginsDir($plugins_dirs);
		$this->smarty->setTemplateDir($template_dirs);
		$this->smarty->setCompileDir(WP_CONTENT_DIR . '/cache/wd-gallery/templates_c/');
		$this->smarty->setCacheDir(WP_CONTENT_DIR . '/cache/wd-gallery/smarty/');

		$WD_Gallery_Smarty_Plugins = new WD_Gallery_Smarty_Plugins;
		$this->smarty->registerPlugin('function', 'the_title', array($WD_Gallery_Smarty_Plugins, 'the_title'));
		$this->smarty->registerPlugin('function', 'wp_nonce_field', array($WD_Gallery_Smarty_Plugins, 'wp_nonce_field'));
		$this->smarty->registerPlugin('function', 'the_permalink', array($WD_Gallery_Smarty_Plugins, 'the_permalink'));
		$this->smarty->registerPlugin('function', 'the_id', array($WD_Gallery_Smarty_Plugins, 'the_id'));
		$this->smarty->registerPlugin('function', 'the_excerpt', array($WD_Gallery_Smarty_Plugins, 'the_excerpt'));
		$this->smarty->registerPlugin('function', 'the_content', array($WD_Gallery_Smarty_Plugins, 'the_content'));
		$this->smarty->registerPlugin('function', 'post_thumbnail_id', array($WD_Gallery_Smarty_Plugins, 'post_thumbnail_id'));
		$this->smarty->registerPlugin('function', 'img', array($WD_Gallery_Smarty_Plugins, 'img'));
		$this->smarty->registerPlugin('function', 'alt', array($WD_Gallery_Smarty_Plugins, 'alt'));
		$this->smarty->registerPlugin('block', 'loop', array($WD_Gallery_Smarty_Plugins, 'loop'));

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