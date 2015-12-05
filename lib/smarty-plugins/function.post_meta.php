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
function smarty_function_post_meta($params, $template) {

	// default params
	$default_params = array(
		'id' => null,
		'key' => '',
		'assign' => null
	);

	// merge default params with the provided ones
	$params = array_merge($default_params, $params);

	if ( ! isset($params['id'])) {
		return null;
	}

	return get_post_meta( $params['id'], $params['key'], true );
}
