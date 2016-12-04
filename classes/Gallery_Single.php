<?php

namespace Wiredot\WP_Photo_Gallery;

use WP_Query;
use Wiredot\Preamp\Twig;

class Gallery_Single {

	private $gallery_id;

	private $skin;

	public function __construct($gallery_id) {
		$this->gallery_id = $gallery_id;
	}

	public function get_single() {

		$Skins = Skin_Factory::init();
		$Active_Skin = $Skins->get_active_skin_object();
		$Active_Skin->enqueue_css();
		$Active_Skin->enqueue_js();

		$photos = get_post_meta( $this->gallery_id, 'wppg-photos', true );

		$Twig = new Twig($Active_Skin->get_directory().'/templates/');
		return $Twig->twig->render('wp-photo-gallery-single.html', array(
			'photos' => $photos
		));

		// $smarty = (new WP_PG_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
		// return $smarty->fetch('wp-photo-gallery-list.html');
		// $Twig = new Twig;
		// echo $Twig->twig->render('wp-photo-gallery-list.html');
	}

	public function get_post() {
		$args = array(
			'post_type' => 'wp-photo-gallery',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
		);

		return new WP_Query( $args );
	}

// class end
}