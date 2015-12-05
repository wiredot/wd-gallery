<?php

class WD_Gallery_MB {

	public function __construct() {
		// add meta boxes
		add_action('admin_init', array($this, 'add_meta_boxes'));

		// save meta boxes
		add_action('save_post', array($this, 'save_meta_boxes'), 10, 3);
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
		if ( ! is_array($photos) ) {
			$photos = null;
		}
		//update_post_meta( $post->ID, 'photos', array(138, 136, 119) );

		$WD_Gallery_Smarty->smarty->assign('photos', $photos);
		echo $WD_Gallery_Smarty->smarty->fetch('admin/photos.html');
	}

	public function save_meta_boxes($post_id, $post, $update) {
		if ( ! isset($_POST['meta-box-nonce']) || ! wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__))) {
			//return $post_id;
		}

	    if ( ! current_user_can('edit_post', $post_id)) {
	        return $post_id;
	    }

	    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	        return $post_id;
	    }

	    $slug = 'wd_gallery';
	    if ( $slug != $post->post_type ) {
	        return $post_id;
	    }

	    $wd_gallery_photo = '';

	    if (isset($_POST['wd_gallery_photo'])) {
	        $wd_gallery_photo = $_POST['wd_gallery_photo'];
	    }   
	    update_post_meta($post_id, 'photos', $wd_gallery_photo);
	}

// class end
}