<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * WP get_the_content function
 *
 * Type:     function
 * Name:     get_the_title
 * Purpose:  print out a title
 *
 */
function smarty_function_img($params, $template) {

	if ( ! isset($params['id'])) {
		return null;
	}
	$post_thumbnail_id = $params['id'];

	$WD_Gallery_Image = new WD_Gallery_Image;
	return $WD_Gallery_Image->get_image($post_thumbnail_id, $params);
}
