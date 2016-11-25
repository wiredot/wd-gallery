<?php

namespace WP_PG;

use WP_Query;

class WP_PG_List {

	private $active_theme;

	public function __construct($active_theme = 'admin') {
		$this->active_theme = $active_theme;
	}

	public function show_list() {
		global $wp_pg_query;

		$wp_pg_query = $this->get_list();

		$smarty = (new WP_PG_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
		return $smarty->fetch('wp-photo-gallery-list.html');
	}

	public function get_list() {
		$args = array(
			'post_type' => 'wp_pg',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
		);

		return new WP_Query( $args );
	}

// class end
}