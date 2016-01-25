<?php

namespace WD_Gallery;

class WD_Gallery_Shortcode {

	public function __construct() {
		add_shortcode( 'wd_gallery', array($this, 'show_shortcode' ) );
		add_action('media_buttons', array($this, 'add_media_button'), 999);
		add_action('admin_footer', array($this, 'add_media_content'));
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

	public function add_media_button() {
		echo '<a href="#TB_inline?width=400&amp;inlineId=wd_gallery_media_content&amp;width=753&amp;height=657" class="thickbox button" id="" title="Add wd Gallery"><span class=""></span> Add wd Gallery</a>';
	}

	public function add_media_content() {
		global $wd_gallery_query;
		$wd_gallery_query = (new WD_Gallery_List)->get_list();
		$smarty = (new WD_Gallery_Smarty)->get_smarty();
		$smarty->display('admin/media-button-content.html');
	}

// class end
}