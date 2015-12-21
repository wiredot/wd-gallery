<?php

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
		
		$WD_Gallery_Smarty->smarty->assign('photos', $photos);
		$return = $WD_Gallery_Smarty->smarty->fetch('wd-gallery-single.html');
		return $return;
	}

// class end
}