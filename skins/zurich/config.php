<?php

$wp_photo_gallery_skin_config = array(
	'id' => 'zurich',
	'name' => 'Zurich',
	'css' => array(
		'media' => 'all',
		'dependencies' => array(),
		'version' => null,
		'files' => array(
			'fresco' => 'assets/fresco/css/fresco/fresco.css',
			'zurich' => 'assets/css/zurich.css'
		)
	),
	'js' => array(
		'footer' => true,
		'dependencies' => array('jquery'),
		'version' => null,
		'files' => array(
			'frescojs' => 'assets/fresco/js/fresco/fresco.js'
		)
	),
	'author' => 'wiredot',
	'photos' => array(
		'thumbnail' => array(
			'w' => 200,
			'h' => 200,
			'zc' => 1,
		),
		'big_image' => array(
			'w' => 1024,
		)
	)
);