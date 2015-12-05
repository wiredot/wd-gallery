<?php


global $CP_Smarty;
// register the prefilter

function smarty_block_loop($params, $content, $template, &$repeat) {
	global $WD_Gallery_Smarty, $wd_gallery_query, $post, $page;

	$old_page = $page;
	$old_post = $post;
	
	$return = '';

	$key = 0;

	if ( $wd_gallery_query->have_posts() ) {
		while ( $wd_gallery_query->have_posts() ) {
			$wd_gallery_query->the_post();
			$WD_Gallery_Smarty->smarty->assign('key', $key);
			$return.= $WD_Gallery_Smarty->smarty->fetch('string:'.$content);
			$key++;
		}
	}

	$page = $old_page;
	$post = $old_post;

	return $return;
}

