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
function smarty_function_alt($params, $template) {

	// default params
	$default_params = array(
		'id' => null
	);

	// merge default params with the provided ones
	$params = array_merge($default_params, $params);

	if ( ! isset($params['id'])) {
		$params['id'] = get_the_id();
	}

	return get_post_meta( $params['id'], '_wp_attachment_image_alt', true );
}
