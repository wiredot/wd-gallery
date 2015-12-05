<?php

class WD_Gallery_List {

	public function __construct() {
	}

	public function show_list() {
		global $WD_Gallery_Smarty, $wd_gallery_query;

		$args = array(
			'post_type' => 'wd_gallery',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
			
		);

		$wd_gallery_query = new WP_Query( $args );

		return $WD_Gallery_Smarty->smarty->fetch('wd-gallery-list.html');
	}

// class end
}