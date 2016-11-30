<?php

$preamp['config']['custom_post_type']['wppg'] = array(
	'active' => true,
	'labels' => array(
		'name'               => _x( 'WP Photo Gallery', 'post type general name', 'wp-photo-gallery' ),
		'singular_name'      => _x( 'WP Photo Gallery', 'post type singular name', 'wp-photo-gallery' ),
		'menu_name'          => _x( 'Photo Gallery', 'admin menu', 'wp-photo-gallery' ),
		'name_admin_bar'     => _x( 'WP Photo Gallery', 'add new on admin bar', 'wp-photo-gallery' ),
		'add_new'            => _x( 'Add New Photo Gallery', 'add new', 'wp-photo-gallery' ),
		'add_new_item'       => __( 'Add New Photo Gallery', 'wp-photo-gallery' ),
		'new_item'           => __( 'New Photo Gallery', 'wp-photo-gallery' ),
		'edit_item'          => __( 'Edit Photo Gallery', 'wp-photo-gallery' ),
		'view_item'          => __( 'View Photo Gallery', 'wp-photo-gallery' ),
		'all_items'          => __( 'All Photo Galleries', 'wp-photo-gallery' ),
		'search_items'       => __( 'Search Photo Gallery', 'wp-photo-gallery' ),
		'parent_item_colon'  => __( 'Parent Photo Gallery:', 'wp-photo-gallery' ),
		'not_found'          => __( 'No Photo Gallery found.', 'wp-photo-gallery' ),
		'not_found_in_trash' => __( 'No Photo Gallery found in Trash.', 'wp-photo-gallery' )
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
	'menu_icon' => WPPG_URL.'/assets/images/wp-photo-gallery.svg',
);

$preamp['config']['meta_box']['photos'] = [
	'active' => true,
	'type' => 'post',
	'name' => __( 'Photos', 'wp-photo-gallery' ),
	'post_type' => array('wppg', 'post'),
	'context' => 'normal', // normal | advanced | side
	'priority' => 'high', // high | core | default | low
	'fields' => array(
		'text_field' => array(
			'type' => 'text',
			'label' => __( 'Text field', 'wp-photo-gallery' )
		),
		'email_field' => array(
			'type' => 'email',
			'label' => __( 'Email field', 'wp-photo-gallery' )
		),
		'date_field' => array(
			'type' => 'date',
			'label' => __( 'Date field', 'wp-photo-gallery' )
		),
		'editor_field' => array(
			'type' => 'editor',
			'label' => __( 'Editor field', 'wp-photo-gallery' )
		),
		'textarea_field' => array(
			'type' => 'textarea',
			'label' => __( 'Textarea field', 'wp-photo-gallery' )
		),
		'checkbox_field' => array(
			'type' => 'checkbox',
			'label' => __( 'Checkbox', 'wp-photo-gallery' )
		),
		'checkboxes_field' => array(
			'type' => 'checkbox',
			'label' => __( 'Checkboxes', 'wp-photo-gallery' ),
			'options' => array(
				1 => 'no',
				2 => 'yes'
			)
		),
		'select_field' => array(
			'type' => 'select',
			'label' => __( 'Select field', 'wp-photo-gallery' ),
			'attributes' => array(
				'multiple' => false,
			),
			'options' => array(
				-1 => '-- select --',
				1 => 'no',
				2 => 'yes'
			)
		),
		'radio_field' => array(
			'type' => 'radio',
			'label' => __( 'Radio field', 'wp-photo-gallery' ),
			'options' => array(
				1 => 'no',
				2 => 'yes'
			)
		),
		'upload' => array(
			'type' => 'upload',
			'label' => __( 'Upload', 'wp-photo-gallery' ),
			'labels' => array(
				'button' => __( 'Add Files', 'wp-photo-gallery' ),
				'button_window' => __( 'Add Files', 'wp-photo-gallery' ),
				'title' => __( 'Upload or Choose Files', 'wp-photo-gallery' )
			),
			'attributes' => array(
				'multiple' => true,
				'filetype' => 'image'
			)
		),
	)
];