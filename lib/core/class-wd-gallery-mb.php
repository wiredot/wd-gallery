<?php

class WD_Gallery_MB {

	public function __construct() {
		// add meta boxes
		add_action('admin_init', array($this, 'add_meta_boxes'));

		// save meta boxes
		add_action('pre_post_update', array($this, 'save_meta_boxes'), 10, 2);
	}

	public function add_meta_boxes() {
		add_meta_box(
			'wd_gallery_mb_images', 
			__('Photos', 'wd-gallery'), 
			array($this, 'show_meta_box'), 
			'wd_gallery', 
			'normal', 
			'high'
		);
	}

	public function show_meta_box($post, $meta_box) {
		global $WD_Gallery_Smarty;

		$photos = get_post_meta( $post->ID, 'photos', true);
		//update_post_meta( $post->ID, 'photos', array(138, 136, 119) );

		$WD_Gallery_Smarty->smarty->assign('photos', $photos);
		echo $WD_Gallery_Smarty->smarty->fetch('admin/photos.html');
	}

// class end
}