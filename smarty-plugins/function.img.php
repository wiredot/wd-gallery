<?php

use WD_Gallery\WD_Gallery_Image;

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

	$possible_attributes = array(
		'class', 'alt', 'idtag', 'title'
	);

	$attributes = array();
	foreach ($possible_attributes as $attr) {
		if (isset($params[$attr])) {
			$attributes[$attr] = $params[$attr];
			unset($params[$attr]);
		}
	}

	$WD_Gallery_Image = new WD_Gallery_Image($post_thumbnail_id, $params, $attributes);

	if (isset($params['link']) && $params['link']) {
		return $WD_Gallery_Image->get_url();
	}
	
	return $WD_Gallery_Image->get_image();
}
