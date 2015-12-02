<?php


global $CP_Smarty;
// register the prefilter

function smarty_block_loop($params, $content, $template, &$repeat) {
	global $WD_Gallery_Smarty;
	$return = '';
	rewind_posts();
	while ( have_posts() ) : the_post();
		$WD_Gallery_Smarty->smarty->assign('key', $key);
		$WD_Gallery_Smarty->smarty->assign('post', $post);
		$return.= $WD_Gallery_Smarty->smarty->fetch('string:'.$content);
		$key++;
	endwhile;

	return $return;
}

