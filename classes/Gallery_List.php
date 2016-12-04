<?php

namespace Wiredot\WP_Photo_Gallery;

use WP_Query;
use Wiredot\Preamp\Twig;

class Gallery_List {

	public function __construct() {
	}

	public function get_list() {
		// global $wp_photo_gallery_query;
		$Skins = Skin_Factory::init();
		$Active_Skin = $Skins->get_active_skin_object();
		$Active_Skin->enqueue_css();
		$Active_Skin->enqueue_js();

		$wp_photo_gallery_query = $this->get_posts();

		$Twig = new Twig($Active_Skin->get_directory().'/templates/');
		return $Twig->twig->render('wp-photo-gallery-list.html', array(
			'galleries' => $wp_photo_gallery_query->posts
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

// class end
}