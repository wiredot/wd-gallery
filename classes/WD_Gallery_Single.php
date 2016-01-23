<?php

namespace WD_Gallery;

use WP_Query;

class WD_Gallery_Single {

	public function __construct() {
	}

	public function show_single($gallery_id) {
		global $WD_Gallery_Smarty, $wd_gallery_query;

		$args = array(
			'post_type' => 'wd_gallery', 
			'p'=> $gallery_id
		);

		$wd_gallery_query = new WP_Query( $args );

		$photos = get_post_meta( $gallery_id, 'photos', true);
		
		$smarty = (new WD_Gallery_Smarty)->get_smarty();
		$smarty->assign('photos', $photos);
		$return = $smarty->fetch('wd-gallery-single.html');
		return $return;
	}

// class end
}