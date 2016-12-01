<?php

namespace Wiredot\WPPG;

use WP_Query;
use Wiredot\Preamp\Twig;

class Gallery_List {

	public function __construct() {
	}

	public function get_list() {
		global $wp_photo_gallery_query;

		$wp_photo_gallery_query = $this->get_posts();

		return 'list';

		// $smarty = (new WP_PG_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
		// return $smarty->fetch('wp-photo-gallery-list.html');
		// $Twig = new Twig;
		// echo $Twig->twig->render('wp-photo-gallery-list.html');
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