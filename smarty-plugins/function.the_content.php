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
function smarty_function_the_content($params, $template) {

	// default params
	$default_params = array(
		'id' => null
	);
    
    // merge default params with the provided ones
	$params = array_merge($default_params, $params);
	if ($params['id']) {
		$current_page = get_post($params['id'], ARRAY_A);
print_r($current_page);
		return $current_page['post_content'];
	}
	
	return get_the_content($params['id']);
}
