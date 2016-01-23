<?php

use WD_Gallery\WD_Gallery_Smarty;

function smarty_block_loop($params, $content, $template, &$repeat) {
	global $wd_gallery_query, $post, $page;

	$old_page = $page;
	$old_post = $post;
	
	$return = '';

	$key = 0;

	if ( $wd_gallery_query->have_posts() ) {
		while ( $wd_gallery_query->have_posts() ) {
			$wd_gallery_query->the_post();
			$smarty = (new WD_Gallery_Smarty)->get_smarty();
			$smarty->assign('key', $key);
			$return.= $smarty->fetch('string:'.$content);
		}
	}

	$page = $old_page;
	$post = $old_post;

	return $return;
}

