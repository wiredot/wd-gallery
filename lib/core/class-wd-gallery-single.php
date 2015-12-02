<?php

class WD_Gallery_Single {

	public function __construct() {
	}

	public function show_single() {
		global $WD_Gallery_Smarty, $post, $posts;

		$old_post = $post;

		$args = array( 'post_type' => 'wd_gallery', 'posts_per_page' => -1, 'orderby'=> 'title', 'order' => 'ASC');
		$posts = get_posts( $args );

		$return = $WD_Gallery_Smarty->smarty->fetch('wd-gallery-single.html');
		$post = $old_post;

		return $return;
	}

// class end
}