<?php

namespace Wiredot\WP_Photo_Gallery;

class Skin {

	private $id;

	private $config;

	public function __construct($config) {
		$this->config = $config;

		$this->register_css();
		$this->register_js();
	}

	public function register_css() {
		if ( ! isset($this->config['css']['files']) || ! is_array($this->config['css']['files'])) {
			return;
		}

		foreach ($this->config['css']['files'] as $key => $css) {
			wp_register_style( $key, $this->config['url'] . '/' .$css, $this->config['css']['dependencies'], $this->config['css']['version'], $this->config['css']['media'] );
			// wp_enqueue_style( $key );
		}
	}

	public function enqueue_css() {
		if ( ! isset($this->config['css']['files']) || ! is_array($this->config['css']['files'])) {
			return;
		}

		foreach ($this->config['css']['files'] as $key => $css) {
			wp_enqueue_style( $key );
		}
	}

	public function register_js() {
		if ( ! isset($this->config['js']['files']) || ! is_array($this->config['js']['files'])) {
			return;
		}
		
		foreach ($this->config['js']['files'] as $key => $js) {
			wp_deregister_script($key);
			wp_register_script($key, $this->config['url'] . '/' . $js, $this->config['js']['dependencies'], $this->config['js']['version'], $this->config['js']['footer']);
		}
	}

	public function enqueue_js() {
		if ( ! isset($this->config['js']['files']) || ! is_array($this->config['js']['files'])) {
			return;
		}
		
		foreach ($this->config['js']['files'] as $key => $js) {
			wp_enqueue_script( $key );
		}
	}

	public function get_directory() {
		return $this->config['directory'];
	}

	public function get_image_params($size) {
		if ( ! isset($this->config['photos'][$size])) {
			return null;
		}

		return $this->config['photos'][$size];
	}

// class end
}