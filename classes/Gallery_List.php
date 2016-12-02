<?php

namespace Wiredot\WPPG;

use WP_Query;
use Wiredot\Preamp\Twig;

class Gallery_List {

	private $skin;

	public function __construct() {
		$Skins = new Skin_Directory();
		$active_skin = $Skins->get_active_skin();

		$this->skin = new Skin($active_skin['id'], $active_skin['css'], $active_skin['js'], $active_skin['directory'], $active_skin['url']);
	}

	public function get_list() {
		// global $wp_photo_gallery_query;

		$wp_photo_gallery_query = $this->get_posts();
		// var_dump($wp_photo_gallery_query->posts);

		$Twig = new Twig($this->skin->get_directory().'/templates/');
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