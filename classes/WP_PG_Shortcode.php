<?php

namespace WP_PG;

class WP_PG_Shortcode {

	private $active_theme;

	public function __construct($active_theme) {
		$this->active_theme = $active_theme;

		add_shortcode( 'wp_pg', array($this, 'show_shortcode' ) );
		add_action('media_buttons', array($this, 'add_media_button'), 999);
		add_action('admin_footer', array($this, 'add_media_content'));
	}

	public function show_shortcode($atts) {
		if (is_array($atts) && array_key_exists('id', $atts)) {
			$WP_PG_Single = new WP_PG_Single($this->active_theme);
			return $WP_PG_Single->show_single($atts['id']);
		} else {
			$WP_PG_List = new WP_PG_List($this->active_theme);
			return $WP_PG_List->show_list();
		}
	}

	public function add_media_button() {
<<<<<<< HEAD
		echo '<a href="#TB_inline?width=400&amp;inlineId=wp_pg_media_content&amp;width=753&amp;height=657" class="thickbox button wp-photo-gallery-media-button" id="" title="Add WP Photo Gallery"><img src="'.WP_PG_URL.'/assets/images/wp-photo-gallery.svg"> Add WP Photo Gallery</a>';
=======
		echo '<a href="#TB_inline?width=400&amp;inlineId=wp_pg_media_content&amp;width=753&amp;height=657" class="thickbox button wp-photo-gallery-media-button" id="" title="Add WP Photo Gallery"><img src="'.WD_GALLERY_URL.'/assets/images/wp-photo-gallery.svg"> Add WP Photo Gallery</a>';
>>>>>>> b47225ab15bbe143233396b140be51b755efb807
	}

	public function add_media_content() {
		global $wp_pg_query;
		$wp_pg_query = (new WP_PG_List)->get_list();
		$smarty = (new WP_PG_Smarty)->get_smarty();
		$smarty->display('media-button-content.html');
	}

// class end
}