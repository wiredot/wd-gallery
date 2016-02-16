<?php

namespace WD_Gallery;

class WD_Gallery_Smarty_Plugins {

	public function the_title($params, $template) {
		$default_params = array(
			'id' => null
		);
	    
	    // merge default params with the provided ones
		$params = array_merge($default_params, $params);
		
		return get_the_title($params['id']);
	}

	public function wp_nonce_field($params, $template) {
		$default_params = array(
			'action' => '-1',
			'name' => '_wpnonce',
			'referer' => false,
			'echo' => false
		);

		$params = array_merge($default_params, $params);

		$nonce = wp_nonce_field($params['action'], $params['name'], $params['referer'], $params['echo']);

		return $nonce;
	}

	public function the_permalink($params, $template) {
		// default params
		$default_params = array(
			'id' => null
		);
	    
	    // merge default params with the provided ones
		$params = array_merge($default_params, $params);

		return get_permalink($params['id']);	
	}

	public function the_id($params, $template) {
		return get_the_id();
	}

	public function the_excerpt( $params, $template ) {
		// default params
		$default_params = array(
			'id' => null
		);

		// merge default params with the provided ones
		$params = array_merge($default_params, $params);

		if ($params['id']) {
			$the_post = get_post($params['id']); 
			return $the_post->post_excerpt;
		}
		
		return get_the_excerpt();
	}

	public function the_content($params, $template) {
		// default params
		$default_params = array(
			'id' => null
		);
	    
	    // merge default params with the provided ones
		$params = array_merge($default_params, $params);
		if ($params['id']) {
			$current_page = get_post($params['id'], ARRAY_A);
			return $current_page['post_content'];
		}
		
		return get_the_content($params['id']);
	}

	public function post_thumbnail_id($params, $template) {
		// default params
		$default_params = array(
			'id' => null
		);
	    
	    // merge default params with the provided ones
		$params = array_merge($default_params, $params);

		return get_post_thumbnail_id($params['id']);	
	}

	public function img($params, $template) {
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

	public function alt($params, $template) {

		// default params
		$default_params = array(
			'id' => null
		);

		// merge default params with the provided ones
		$params = array_merge($default_params, $params);

		if ( ! $params['id']) {
			$params['id'] = get_the_id();
		}

		return get_post_meta( $params['id'], '_wp_attachment_image_alt', true );
	}

	public function loop($params, $content, $template, &$repeat) {
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

// end class
}