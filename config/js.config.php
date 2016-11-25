<?php

$preamp['config']['js']['scripts'] = array(
	'footer' => true,
	'front' => false,
	'admin' => true,
	'dependencies' => array('jquery'),
	'files' => array(
		'wp_pg' => WP_PG_URL . 'assets/js/wp-photo-gallery.js'
	),
	'dev_files' => array(

	)
);