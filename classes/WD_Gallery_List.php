<?php

namespace WD_Gallery;

use WP_Query;

class WD_Gallery_List {

	public function show_list() {
		global $wd_gallery_query;

		$wd_gallery_query = $this->get_list();

		$smarty = (new WD_Gallery_Smarty)->get_smarty();
		return $smarty->fetch('wd-gallery-list.html');
	}

	public function get_list() {
		$args = array(
			'post_type' => 'wd_gallery',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
		);

		return new WP_Query( $args );
	}

// class end
}