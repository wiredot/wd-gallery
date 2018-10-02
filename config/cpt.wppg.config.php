<?php

$config['custom_post_type']['wp-gallery'] = array(
	'active' => true,
	'labels' => array(
		'name'               => 'WP Gallery',
		'singular_name'      => 'WP Gallery',
		'menu_name'          => _x( 'WP Gallery', 'admin menu', 'wp-gallery' ),
		'name_admin_bar'     => 'WP Gallery',
		'add_new'            => _x( 'Add New Gallery', 'gallery', 'wp-gallery' ),
		'add_new_item'       => __( 'Add New Gallery', 'wp-gallery' ),
		'new_item'           => __( 'New Gallery', 'wp-gallery' ),
		'edit_item'          => __( 'Edit Gallery', 'wp-gallery' ),
		'view_item'          => __( 'View Gallery', 'wp-gallery' ),
		'all_items'          => __( 'All Galleries', 'wp-gallery' ),
		'search_items'       => __( 'Search Gallery', 'wp-gallery' ),
		'not_found'          => __( 'No Gallery found.', 'wp-gallery' ),
		'not_found_in_trash' => __( 'No Gallery found in Trash.', 'wp-gallery' ),
		'featured_image'     => __( 'Gallery Cover', 'wp-gallery' ),
		'remove_featured_image'  => __( 'Remove Gallery Cover', 'wp-gallery' ),
		'use_featured_image'     => __( 'Use as Gallery Cover', 'wp-gallery' ),
		'set_featured_image'     => __( 'Set Gallery Cover', 'wp-gallery' ),
	),
	'messages' => array(
		1  => __( 'Gallery updated.', 'wp-gallery' ),
		2  => __( 'Gallery updated.', 'wp-gallery' ),
		3  => __( 'Gallery deleted.', 'wp-gallery' ),
		4  => __( 'Gallery updated.', 'wp-gallery' ),
		5  => __( 'Gallery restored to revision from %revision%', 'wp-gallery' ),
		6  => __( 'Gallery published.', 'wp-gallery' ),
		7  => __( 'Gallery saved.', 'wp-gallery' ),
		8  => __( 'Gallery submitted.', 'wp-gallery' ),
		9  => __( 'Gallery scheduled for: <strong>%date%</strong>.', 'wp-gallery' ),
		// translators: Publish box date format, see http://php.net/date
		// date_i18n( __( 'M j, Y @ G:i', 'wp-gallery' ), strtotime( $post->post_date ) )
	// ),
	10 => __( 'Gallery draft updated.', 'wp-gallery' ),
	),
	'description' => __( 'Description.', 'wp-gallery' ),
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
	'rewrite' => array( 'slug' => 'wp-gallery' ),
	'query_var' => true,
	'can_export' => true,
	'delete_with_user' => true,
	'custom_menu_icon' => 'assets/images/wp-gallery.svg',
);

$config['meta_box']['wp-gallery-photos'] = array(
	'active' => true,
	'type' => 'post',
	'name' => __( 'Photos', 'wp-gallery' ),
	'post_type' => array( 'wp-gallery', 'post' ),
	'context' => 'normal', // normal | advanced | side
	'priority' => 'high', // high | core | default | low
	'fields' => array(
		'photos' => array(
			'type' => 'upload',
			'label' => __( 'Photos', 'wp-gallery' ),
			'labels' => array(
				'button' => __( 'Add Photos', 'wp-gallery' ),
				'button_window' => __( 'Add Photos', 'wp-gallery' ),
				'title' => __( 'Upload or Choose Photos', 'wp-gallery' ),
			),
			'attributes' => array(
				'multiple' => true,
				'filetype' => 'image',
			),
		),
	),
);

$config['admin_custom_columns']['gallery'] = array(
	'post_type' => 'wp-gallery',
	'columns' => array(
		'featured_image',
		'title',
		'date',
	),
);
