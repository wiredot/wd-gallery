<?php

namespace WP_PG;

use WP_PG\WP_PG_Smarty;

class WP_PG_MB {

	public function __construct() {
		// add meta boxes
		add_action('admin_init', array($this, 'add_meta_boxes'));

		// save meta boxes
		add_action('save_post', array($this, 'save_meta_boxes'), 10, 3);
	}

	public function add_meta_boxes() {
		add_meta_box(
			'wp_pg_mb_images', 
			__('Photos', 'wp-photo-gallery'), 
			array($this, 'show_meta_box'), 
			'wp_pg', 
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

		$smarty = (new WP_PG_Smarty())->get_smarty();
		$smarty->assign('photos', $photos);
		echo $smarty->fetch('photos.html');
	}

	public function save_meta_boxes($post_id, $post, $update) {
		if ( ! isset($_POST['wp_pg_photo_nonce']) || ! wp_verify_nonce($_POST['wp_pg_photo_nonce'], 'wp_pg_photo_insert')) {
			return;
		}

	    if ( ! current_user_can('edit_post', $post_id)) {
	        return;
	    }

	    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
	        return;
	    }

	    if ( $post->post_type != 'wp_pg' ) {
	        return;
	    }

	    if ( isset($_POST['wp_pg_photo']) && is_array($_POST['wp_pg_photo']) ) {
	    	// validate photo ids
	    	$wp_pg_photo = array_map( 'intval', $_POST['wp_pg_photo'] );
	    } else {
	    	return;
	    }

	    if ( isset($_POST['wp_pg_title']) && is_array($_POST['wp_pg_title']) ) {
	    	$wp_pg_title = array_map( 'sanitize_text_field', $_POST['wp_pg_title'] );
	    } else {
	    	return;
	    }

	    if ( isset($_POST['wp_pg_caption']) && is_array($_POST['wp_pg_caption']) ) {
	    	$wp_pg_caption = array_map( 'sanitize_text_field', $_POST['wp_pg_caption'] );
	    } else {
	    	return;
	    }

	    if ( isset($_POST['wp_pg_alt']) && is_array($_POST['wp_pg_alt']) ) {
	    	$wp_pg_alt = array_map( 'sanitize_text_field', $_POST['wp_pg_alt'] );
	    } else {
	    	return;
	    }

	    foreach ($wp_pg_photo as $key => $photo_id) {
			$title = '';
			$caption = '';
			$alt = '';

			if (isset($wp_pg_title[$key])) {
				$title = $wp_pg_title[$key];
			}
			
			if (isset($wp_pg_caption[$key])) {
				$caption = $wp_pg_caption[$key];
			}

			if (isset($wp_pg_alt[$key])) {
				$alt = $wp_pg_alt[$key];
			}

			$this->update_image_data($photo_id, $title, $caption, $alt);
		}

	    update_post_meta($post_id, 'photos', $wp_pg_photo);
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