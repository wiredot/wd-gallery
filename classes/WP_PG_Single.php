<?php

namespace WP_PG;

use WP_Query;

class WP_PG_Single {

	private $active_theme;

	public function __construct($active_theme) {
		$this->active_theme = $active_theme;
	}

	public function show_single($gallery_id) {
		global $WP_PG_Smarty, $wp_pg_query;

		$args = array(
			'post_type' => 'wp_pg', 
			'p'=> $gallery_id
		);

		$wp_pg_query = new WP_Query( $args );

		$photos = get_post_meta( $gallery_id, 'photos', true);
		if ( ! is_array($photos) || ! count($photos)) {
			$photos = null;
		}
		$smarty = (new WP_PG_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
		$smarty->assign('photos', $photos);
		$return = $smarty->fetch('wp-photo-gallery-single.html');
		return $return;
	}

// class end
}