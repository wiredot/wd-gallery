<?php

namespace WD_Gallery;

use WD_Gallery\WD_Gallery_Smarty;

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
		$photos = get_post_meta( $post->ID, 'photos', true);
		if ( ! is_array($photos) ) {
			$photos = null;
		}
		//update_post_meta( $post->ID, 'photos', array(138, 136, 119) );

		$smarty = (new WD_Gallery_Smarty())->get_smarty();
		$smarty->assign('photos', $photos);
		echo $smarty->fetch('admin/photos.html');
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

	    if (isset($_POST['wd_gallery_title'])) {
	        $wd_gallery_title = $_POST['wd_gallery_title'];
	    }

	    if (isset($_POST['wd_gallery_caption'])) {
	        $wd_gallery_caption = $_POST['wd_gallery_caption'];
	    }

	    if (isset($_POST['wd_gallery_alt'])) {
	        $wd_gallery_alt = $_POST['wd_gallery_alt'];
	    }

	    foreach ($_POST['wd_gallery_photo'] as $key => $photo_id) {
			$title = '';
			$caption = '';
			$alt = '';

			if (isset($wd_gallery_title[$key])) {
				$title = $wd_gallery_title[$key];
			}
			
			if (isset($wd_gallery_caption[$key])) {
				$caption = $wd_gallery_caption[$key];
			}

			if (isset($wd_gallery_alt[$key])) {
				$alt = $wd_gallery_alt[$key];
			}

			$this->update_image_data($photo_id, $title, $caption, $alt);
		}

	    update_post_meta($post_id, 'photos', $wd_gallery_photo);
	}

	public function update_image_data($id, $title, $caption, $alt = '') {
		global $wpdb;

		$wpdb->update(
			$wpdb->posts,
			array(
				'post_title' => $title,
				'post_excerpt' => $caption
			),
			array(
				'ID' => $id
			)
		);

		if ($alt) {
			update_post_meta( $id, '_wp_attachment_image_alt', $alt );
		} else {
			delete_post_meta( $id, '_wp_attachment_image_alt' );
		}
	}

// class end
}