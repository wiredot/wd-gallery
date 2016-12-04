<?php

namespace Wiredot\WP_Photo_Gallery;

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

		$this->register_css();
		$this->register_js();
	}

	public function register_css() {
		if ( ! isset($this->css['files']) || ! is_array($this->css['files'])) {
			return;
		}

		foreach ($this->css['files'] as $key => $css) {
			wp_register_style( $key, $this->url . '/' .$css, $this->css['dependencies'], $this->css['version'], $this->css['media'] );
			// wp_enqueue_style( $key );
		}
	}

	public function enqueue_css() {
		if ( ! isset($this->css['files']) || ! is_array($this->css['files'])) {
			return;
		}

		foreach ($this->css['files'] as $key => $css) {
			wp_enqueue_style( $key );
		}
	}

	public function register_js() {
		if ( ! isset($this->js['files']) || ! is_array($this->js['files'])) {
			return;
		}
		
		foreach ($this->js['files'] as $key => $js) {
			wp_deregister_script($key);
			wp_register_script($key, $this->url . '/' . $js, $this->js['dependencies'], $this->js['version'], $this->js['footer']);
		}
	}

	public function enqueue_js() {
		if ( ! isset($this->js['files']) || ! is_array($this->js['files'])) {
			return;
		}
		
		foreach ($this->js['files'] as $key => $js) {
			wp_enqueue_script( $key );
		}
	}

	public function get_directory() {
		return $this->directory;
	}

// class end
}