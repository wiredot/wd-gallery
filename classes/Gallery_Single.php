<?php

namespace Wiredot\WP_Gallery;

use WP_Query;
use Wiredot\Copernicus\Twig\Twig;

class Gallery_Single {

	private $gallery_id;

	private $skin;

	public function __construct( $gallery_id ) {
		$this->gallery_id = $gallery_id;
	}

	public function get_single() {
		$Skins = Skin_Factory::init();
		$Active_Skin = $Skins->get_active_skin_object();

		if ( ! WP_Gallery::get_settings( 'hide_css' ) ) {
			$Active_Skin->enqueue_css();
		}

		if ( ! WP_Gallery::get_settings( 'hide_js' ) ) {
			$Active_Skin->enqueue_js();
		}

		$params_thumbnail = $Active_Skin->get_image_params( 'thumbnail' );
		$params_big_image = $Active_Skin->get_image_params( 'big_image' );

		$photos = get_post_meta( $this->gallery_id, 'photos', true );

		$photos_data = array();
		foreach ( $photos as $photo_id ) {
			$alt = get_post_meta( $photo_id, '_wp_attachment_image_alt', true );
			$title = get_the_title( $photo_id );
			$caption = get_the_excerpt( $photo_id );

			$atts = array(
				'title' => $title,
				'alt' => $alt,
			);

			// $Image = new Image( $photo_id, $params_thumbnail, $atts );
			// $thumbnail = $Image->get_image();

			if ( $params_big_image ) {
				// $Image = new Image( $photo_id, $params_big_image, $atts );
				// $big_image = $Image->get_url();
			} else {
				$big_image = null;
			}

			$photos_data[] = array(
				'id' => $photo_id,
				// 'thumbnail' => $thumbnail,
				// 'big_image' => $big_image,
				'title' => $title,
				'alt' => $alt,
				'caption' => get_the_excerpt( $photo_id ),
			);
		}

		$Twig = new Twig();
		return $Twig->twig->render(
			'simple/wp-gallery-single.twig', array(
				'photos' => $photos_data,
			)
		);
	}

	public function get_post() {
		$args = array(
			'post_type' => 'wp-gallery',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
		);

		return new WP_Query( $args );
	}

}
