<?php

namespace Wiredot\WPPG;

class Skin {

	private $id;

	private $directory;

	private $url;

	private $css = array();

	private $js = array();

	public function __construct($id, $css, $js, $directory, $url) {
		$this->id = $id;
		$this->css = $css;
		$this->js = $js;
		$this->directory = $directory;
		$this->url = $url;

		add_filter( 'wp_enqueue_scripts', array($this, 'add_css') );
		add_filter( 'wp_enqueue_scripts', array($this, 'add_js') );
	}

	public function add_css() {
		foreach ($this->css as $key => $css) {
			wp_enqueue_style( $key, $this->url . '/' .$css );
		}
	}

	public function add_js() {
		foreach ($this->js as $key => $js) {
			wp_enqueue_script( $key, $this->url . '/' . $js, array('jquery'), '1.0.0', true );
		}
	}

	public function get_directory() {
		return $this->directory;
	}

// class end
}