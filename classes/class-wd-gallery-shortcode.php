<?php

class WD_Gallery_Shortcode {

	public function __construct() {
		add_shortcode( 'wd_gallery', array($this, 'show_shortcode' ) );
		add_action('admin_init', array($this, 'shortcode_button'));
		add_action('admin_footer', array($this, 'get_galleries'));
	}

	public function show_shortcode($atts) {
		if (is_array($atts) && array_key_exists('id', $atts)) {
			$WD_Gallery_Single = new WD_Gallery_Single;
			return $WD_Gallery_Single->show_single($atts['id']);
		} else {
			$WD_Gallery_List = new WD_Gallery_List;
			return $WD_Gallery_List->show_list();
		}
	}

	public function shortcode_button() {
		if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
			add_filter( 'mce_external_plugins', array($this, 'add_buttons' ));
			add_filter( 'mce_buttons', array($this, 'register_buttons' ));
		}
	}

	public function add_buttons( $plugin_array ) {
		global $WD_Gallery;

		$plugin_array['wd_gallery'] = $WD_Gallery->plugin_url. 'assets/js/shortcode-tinymce-button.js';

		return $plugin_array;
	}

	public function register_buttons( $buttons ) {
		array_push( $buttons, 'separator', 'wd_gallery' );
		return $buttons;
	}

	public function get_galleries() {
		global $wpdb;

		echo '<script type="text/javascript">';

		$args = array( 'post_type' => 'wd_gallery', 'posts_per_page' => -1, 'orderby'=> 'title', 'order' => 'ASC');
		$posts = get_posts( $args );
		echo "\n";
		echo 'var shortcodes_button_wd_gallery = [];';
		foreach($posts as $post) {
			echo "\n";
			echo "shortcodes_button_wd_gallery.push({text:'".str_replace("'", "\'", $post->post_title)."',value:'{$post->ID}'});";   
		}

		echo '</script>';
	}

// class end
}