<?php

class WD_Gallery {

	var $plugin_file;
	var $plugin_basename;
	var $plugin_dir;
	var $plugin_url;
	var $menu_slug = 'wd-gallery-menu';

	public function __construct($plugin_file = '', $option_name = null) {

		$this->plugin_file = $plugin_file;
		$this->plugin_basename = plugin_basename($this->plugin_file);
		$this->plugin_dir = dirname($plugin_file);
		$this->plugin_url = plugin_dir_url( $plugin_file );

		// add activation & deactivation actions
		add_action('activate_' . $this->plugin_basename, array($this, 'activate'));
		add_action('deactivate_' . $this->plugin_basename, array($this, 'deactivate'));

		// intialize settings menu
		add_action('admin_menu', array($this, 'admin_menu'));

		add_action( 'admin_enqueue_scripts', array($this, 'admin_css') );

		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);

		spl_autoload_register(array($this, 'class_autoloader'));

		// load composer components
		require $this->plugin_dir . '/lib/composer/vendor/autoload.php';

		//add_filter( 'single_template', array($this, 'get_custom_post_type_template' ));
	}

	public function activate() {
		$WD_Gallery_CPT = new WD_Gallery_CPT;
		$WD_Gallery_CPT->create_post_type();
		flush_rewrite_rules();

		$this->init_directory(WP_CONTENT_DIR.'/cache');
		$this->init_directory(WP_CONTENT_DIR.'/cache/wd_gallery');
		$this->init_directory(WP_CONTENT_DIR.'/cache/wd_gallery/templates_c');
		$this->init_directory(WP_CONTENT_DIR.'/cache/wd_gallery/smarty');
	}

	public function deactivate() {
	}

	public function admin_menu() {
		// add options page
		add_options_page(
			_x( 'wd Gallery', 'post type general name', 'wd-gallery' ), 
			_x( 'wd Gallery', 'admin menu', 'wd-gallery' ), 
			'edit_users', 
			$this->menu_slug, 
			array($this, 'template_options_page')
		);
	}

	public function admin_css() {
		// Location of your custom-tinymce-plugin.css file
		wp_enqueue_style( 'custom_tinymce_plugin', $this->plugin_url . 'assets/css/wd_gallery.css' );
	}

	function template_options_page() {
		
		echo 'asd';
	}

	function action_links($links, $file) {
		
		// run for this plugin
		if ($file == $this->plugin_basename) {
			
			// settings link
			$settings_link = "<a href='options-general.php?page=" . $this->menu_slug . "'>" . __('Settings') . "</a>";
			
			// add settings link to plugin info section
			array_unshift($links, $settings_link);
		}
		return $links;
	}

	public function load_class($class_name) {
		global $$class_name;
		$$class_name = new $class_name;
	}

	private function init_directory($dir) {
		if ( ! file_exists($dir)) {
			mkdir($dir, 0755);
		}
	}

	function get_custom_post_type_template($single_template) {
		global $post;

		if ($post->post_type == 'wd_gallery') {
			$single_template = $this->plugin_dir . '/single-wd_gallery.php';
		}
		return $single_template;
	}

	public function class_autoloader($class_name) {
		$class_filename = 'class-'.str_replace('_', '-', strtolower($class_name)).'.php';
		if (file_exists($this->plugin_dir.'/lib/core/'.$class_filename)) {
			include_once $this->plugin_dir.'/lib/core/'.$class_filename;
		}
	}

// class end	
}
