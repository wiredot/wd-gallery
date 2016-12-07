<?php

$preamp['config']['custom_post_type']['wp-photo-gallery'] = array(
	'active' => true,
	'labels' => array(
		'name'               => 'WP Photo Gallery',
		'singular_name'      => 'WP Photo Gallery',
		'menu_name'          => _x( 'Photo Gallery', 'admin menu', 'wp-photo-gallery' ),
		'name_admin_bar'     => 'WP Photo Gallery',
		'add_new'            => _x( 'Add New Photo Gallery', 'gallery', 'wp-photo-gallery' ),
		'add_new_item'       => __( 'Add New Photo Gallery', 'wp-photo-gallery' ),
		'new_item'           => __( 'New Photo Gallery', 'wp-photo-gallery' ),
		'edit_item'          => __( 'Edit Photo Gallery', 'wp-photo-gallery' ),
		'view_item'          => __( 'View Photo Gallery', 'wp-photo-gallery' ),
		'all_items'          => __( 'All Photo Galleries', 'wp-photo-gallery' ),
		'search_items'       => __( 'Search Photo Gallery', 'wp-photo-gallery' ),
		'not_found'          => __( 'No Photo Gallery found.', 'wp-photo-gallery' ),
		'not_found_in_trash' => __( 'No Photo Gallery found in Trash.', 'wp-photo-gallery' ),
		'featured_image'	 => __( 'Gallery Cover', 'wp-photo-gallery' ),
		'remove_featured_image'	 => __( 'Remove Gallery Cover', 'wp-photo-gallery' ),
		'use_featured_image'	 => __( 'Use as Gallery Cover', 'wp-photo-gallery' ),
		'set_featured_image'	 => __( 'Set Gallery Cover', 'wp-photo-gallery' ),
	),
	'messages' => array(
		1  => __( 'Gallery updated.', 'wp-photo-gallery' ),
		2  => __( 'Gallery updated.', 'wp-photo-gallery' ),
		3  => __( 'Gallery deleted.', 'wp-photo-gallery' ),
		4  => __( 'Gallery updated.', 'wp-photo-gallery' ),
		5  => __( 'Gallery restored to revision from %revision%', 'wp-photo-gallery' ),
		6  => __( 'Gallery published.', 'wp-photo-gallery' ),
		7  => __( 'Gallery saved.', 'wp-photo-gallery' ),
		8  => __( 'Gallery submitted.', 'wp-photo-gallery' ),
		9  => __( 'Gallery scheduled for: <strong>%date%</strong>.', 'wp-photo-gallery' ),
			// translators: Publish box date format, see http://php.net/date
			// date_i18n( __( 'M j, Y @ G:i', 'wp-photo-gallery' ), strtotime( $post->post_date ) )
		// ),
		10 => __( 'Gallery draft updated.', 'wp-photo-gallery' )
	),
	'description' => __( 'Description.', 'wp-photo-gallery' ),
	'public' => true,
	'hierarchical' => false,
	'exclude_from_search' => false,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'show_in_nav_menus' => true,
	'show_in_admin_bar' => true,
	'menu_position' => null,
	'menu_icon' => 'dashicons-admin-post',
	'capability_type' => 'post',
	// 'capabilities' => array('edit_posts'),
	// 'map_meta_cap' => false,
	'supports' => array( 'title', 'thumbnail' ), // 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'
	// 'register_meta_box_cb' => true,
	// 'taxonomies' => array(),
	// 'has_archive' => false,
	'rewrite' => array( 'slug' => 'wp-photo-gallery' ),
	'query_var' => true,
	'can_export' => true,
	'delete_with_user' => true,
	'custom_menu_icon' => 'assets/images/wp-photo-gallery.svg',
);

$preamp['config']['meta_box']['wp-photo-gallery-photos'] = array(
	'active' => true,
	'type' => 'post',
	'name' => __( 'Photos', 'wp-photo-gallery' ),
	'post_type' => array('wp-photo-gallery', 'post'),
	'context' => 'normal', // normal | advanced | side
	'priority' => 'high', // high | core | default | low
	'fields' => array(
		'wppg-photos' => array(
			'type' => 'upload',
			'label' => __( 'Photos', 'wp-photo-gallery' ),
			'labels' => array(
				'button' => __( 'Add Photos', 'wp-photo-gallery' ),
				'button_window' => __( 'Add Photos', 'wp-photo-gallery' ),
				'title' => __( 'Upload or Choose Photos', 'wp-photo-gallery' )
			),
			'attributes' => array(
				'multiple' => true,
				'filetype' => 'image'
			)
		),
	)
);

$preamp['config']['admin_custom_columns']['gallery'] = array(
	'post_type' => 'wp-photo-gallery',
	'columns' => array(
		'featured_image',
		'title',
		'date'
	)
);