<?php

namespace Wiredot\WPPG;

use WP_Query;
use Wiredot\Preamp\Twig;

class Gallery_Single {

	private $gallery_id;

	public function __construct($gallery_id) {
		$this->gallery_id = $gallery_id;
	}

	public function get_single() {

		return 'gallery'.$this->gallery_id;

		// $smarty = (new WP_PG_Smarty($this->active_theme->get_path().'/templates/'))->get_smarty();
		// return $smarty->fetch('wp-photo-gallery-list.html');
		// $Twig = new Twig;
		// echo $Twig->twig->render('wp-photo-gallery-list.html');
	}

	public function get_post() {
		$args = array(
			'post_type' => 'wppg',
			'order' => 'ASC',
			'orderby' => 'menu_order',
			'posts_per_page' => '-1',
		);

		return new WP_Query( $args );
	}

// class end
}