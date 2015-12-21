<?php

class WD_Gallery_Image {

	public function __construct() {
	}

	public function get_image($id, $params, $attr = array()) {
		$default_params = array(
			'w' => 100
		);

		$params = array_merge($default_params, $params);

		$default_attr = array(
			'cache' => true,
			'mode' => 'tag',
			'echo' => false,
			'class' => null,
			'alt' => null,
			'title' => null,
			'id' => null
		);

		$attr = array_merge($default_attr, $attr);

		if (isset($params['alt'])) {
			$attr['alt'] = $params['alt'];
		}

		if (isset($params['title'])) {
			$attr['title'] = $params['title'];
		}

		$image_details = $this->get_image_details($id, $params);
		if ( ! is_array($image_details) ) {
			return null;
		}

		if ( ! $image_details['cached'] || ! $attr['cache'] ) {
			$image_details['cached'] = $this->render_image($image_details, $params);
		}

		if ( ! $image_details['cached'] ) {
			return null;
		}

		if ($attr['mode'] == 'tag') {
			$image = $this->get_image_tag($image_details, $params, $attr);
		} else {
			$image =  $image_details['upload_url'].$image_details['filename'];
		}

		if ($attr['echo']) {
			echo $image;
		} else {
			return $image;
		}
	}

	public function get_image_details($id, $params) {
		$image_details = array();
		$old_image_metadata = wp_get_attachment_metadata( $id );
		if ( ! $old_image_metadata ) {
			return null;
		}

		$wp_upload_dir = wp_upload_dir();
		$image_details['upload_url'] = $wp_upload_dir['baseurl'].'/'.dirname($old_image_metadata['file']).'/';
		$image_details['upload_dir'] = $wp_upload_dir['basedir'].'/'.dirname($old_image_metadata['file']).'/';
		$image_details['old_filename'] = basename($old_image_metadata['file']);
		$image_details['old_extension'] = pathinfo($image_details['old_filename'], PATHINFO_EXTENSION);
		$image_details['old_name'] = basename($image_details['old_filename'], '.' . $image_details['old_extension']);
		$image_details['name'] = $this->get_filename($image_details['old_name'], $params);
		$image_details['extension'] = $image_details['old_extension'];
		$image_details['filename'] = $image_details['name'].'.'.$image_details['old_extension'];

		$image_details['cached'] = false;
		
		if (file_exists($image_details['upload_dir'].$image_details['filename'])) {
			$image_details['cached'] = true;
		}

		return $image_details;
	}

	public function get_filename($old_name, $params) {
		$name = $old_name;
		if (isset($params['w'])) {
			$name.= '_'.$params['w'];
		}

		if (isset($params['h'])) {
			$name.= '_'.$params['h'];
		}

		return $name;
	}

	public function render_image($image_details, $params) {
		$phpThumb = new phpThumb();

		$phpThumb->setSourceFilename($image_details['upload_dir'].$image_details['old_filename']);

		foreach ($params as $key => $s) {
			$phpThumb->setParameter($key, $s);
		}

		if ($phpThumb->GenerateThumbnail()) {
			if ($phpThumb->RenderToFile($image_details['upload_dir'].$image_details['filename'])) {

				$phpThumb->purgeTempFiles();

				return 1;
			}
		}

		return null;
	}

	public function get_image_tag($image_details, $params, $attr) {
		$tag = '<img src="'; 
		$tag.= $image_details['upload_url'].$image_details['filename'];
		$tag.= '"';

		if ($attr['class']) {
			$tag.= ' class="'.$attr['class'].'"';
		}
		
		if ($attr['id']) {
			$tag.= ' id="'.$attr['id'].'"';
		}
		
		if (isset($params['alt']) && $attr['alt']) {
			$tag.= ' alt="'.$attr['alt'].'"';
		}

		if (isset($params['title']) && $attr['title']) {
			$tag.= ' title="'.$attr['title'].'"';
		}
		
		if ($params['w']) {
			$tag.= ' width="'.$params['w'].'"';
		}

		if (isset($params['h']) && $params['h']) {
			$tag.= ' height="'.$params['h'].'"';
		}
		
		$tag.= '>';

		return $tag;
	}

// class end
}