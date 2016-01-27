<?php

namespace WD_Gallery;

use WP_Query;

class WD_Gallery_List {

	private $active_theme;

	public function __construct($active_theme = 'admin') {
		$this->active_theme = $active_theme;
	}

	public function show_list() {
		global $wd_gallery_query;

		$wd_gallery_query = $this->get_list();

		$smarty = (new WD_Gallery_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
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