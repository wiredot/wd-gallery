<?php

namespace WD_Gallery;

use WP_Query;

class WD_Gallery_Single {

	private $active_theme;

	public function __construct($active_theme) {
		$this->active_theme = $active_theme;
	}

	public function show_single($gallery_id) {
		global $WD_Gallery_Smarty, $wd_gallery_query;

		$args = array(
			'post_type' => 'wd_gallery', 
			'p'=> $gallery_id
		);

		$wd_gallery_query = new WP_Query( $args );

		$photos = get_post_meta( $gallery_id, 'photos', true);
		if ( ! is_array($photos) || ! count($photos)) {
			$photos = null;
		}
		$smarty = (new WD_Gallery_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
		$smarty->assign('photos', $photos);
		$return = $smarty->fetch('wd-gallery-single.html');
		return $return;
	}

// class end
}