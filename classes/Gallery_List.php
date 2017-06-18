<?php

namespace Wiredot\WP_GALLERY;

use WP_Query;
use Wiredot\Preamp\Twig;
use Wiredot\Preamp\Image;

class Gallery_List {

	public function __construct() {
	}

	public function get_list() {
		// global $WP_GALLERY_query;
		$Skins = Skin_Factory::init();
		$Active_Skin = $Skins->get_active_skin_object();

		if ( ! CORE::get_settings('hide_css') ) {
			$Active_Skin->enqueue_css();
		}

		if ( ! CORE::get_settings('hide_js') ) {
			$Active_Skin->enqueue_js();
		}

		$params_thumbnail = $Active_Skin->get_image_params('thumbnail');

		$WP_GALLERY_query = $this->get_posts();

		$gallery_data = array();
		foreach ($WP_GALLERY_query->posts as $gallery) {
			$photo_id = get_post_thumbnail_id( $gallery->ID );

			$alt = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
			$title = get_the_title($photo_id);

			$atts = array(
				'title' => $title,
				'alt' => $alt
			);

			$Image = new Image($photo_id, $params_thumbnail, $atts);
			$thumbnail = $Image->get_image();

			$gallery_data[] = array(
				'id' => $gallery->ID,
				'thumbnail' => $thumbnail,
				'permalink' => get_permalink( $gallery->ID ),
				'title' => $gallery->post_title
			);
		}

		$Twig = new Twig($Active_Skin->get_directory().'/templates/');
		return $Twig->twig->render('wp-photo-gallery-list.html', array(
			'galleries' => $gallery_data
		));
	}

	public function get_posts() {
		$args = array(
			'post_type' => 'wp-photo-gallery',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
		);

		return new WP_Query( $args );
	}

}