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
		echo '<a href="#TB_inline?width=480&amp;inlineId=wd_gallery_media_content&amp;width=753&amp;height=657" class="thickbox button" id="" title="Add wd Gallery"><span class=""></span> Add wd Gallery</a>';
	}

	public function add_media_content() {
		echo '<div id="wd_gallery_media_content" style="display:none;">
			<div class="wrap">
                media_contentmedia_content
        	</div>';
	}

// class end
}