<?php

namespace WP_PG;

class WP_PG_CPT {

	public function __construct() {
		add_action( 'init', array( $this, 'create_post_type' ) );
		
		if (is_admin()) {
			
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

			add_action('admin_head', array( $this, 'help_tab'));

			add_filter('pre_get_posts', array($this, 'set_list_views_order'));
			
			add_action('manage_posts_custom_column', array($this, 'custom_columns'), 10, 2);

			add_filter('manage_edit-wp_pg_columns', array($this, 'modify_list_view'));

			add_action('save_post', array($this, 'add_shortcode'), 10, 2);
		}
	}

	public function create_post_type() {
		$labels = array(
			'name'               => _x( 'WP Photo Gallery', 'post type general name', 'wp-photo-gallery' ),
			'singular_name'      => _x( 'WP Photo Gallery', 'post type singular name', 'wp-photo-gallery' ),
			'menu_name'          => _x( 'WP Photo Gallery', 'admin menu', 'wp-photo-gallery' ),
			'name_admin_bar'     => _x( 'WP Photo Gallery', 'add new on admin bar', 'wp-photo-gallery' ),
			'add_new'            => _x( 'Add New Gallery', 'add new gallery', 'wp-photo-gallery' ),
			'add_new_item'       => __( 'Add New Gallery', 'wp-photo-gallery' ),
			'new_item'           => __( 'New Gallery', 'wp-photo-gallery' ),
			'edit_item'          => __( 'Edit Gallery', 'wp-photo-gallery' ),
			'view_item'          => __( 'View Gallery', 'wp-photo-gallery' ),
			'all_items'          => __( 'All Galleries', 'wp-photo-gallery' ),
			'search_items'       => __( 'Search Galleries', 'wp-photo-gallery' ),
			'parent_item_colon'  => __( 'Parent Galleries:', 'wp-photo-gallery' ),
			'not_found'          => __( 'No Galleries found.', 'wp-photo-gallery' ),
			'not_found_in_trash' => __( 'No Galleries found in Trash.', 'wp-photo-gallery' )
		);

		register_post_type( 'wp_pg',
			array(
				'labels' => $labels,
				'description' => __( 'Gallery Plugin', 'wp-photo-gallery' ),
				'public' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_in_admin_bar' => true,
				'menu_position' => 80,
				'menu_icon' => WD_GALLERY_URL.'/assets/images/wp-photo-gallery.svg',
				'capability_type' => 'page',
				'hierarchical' => false,
				'supports' => array('title', 'thumbnail', 'page-attributes'),
				'rewrite' => array('slug' => 'wp-photo-gallery'),
				'has_archive' => true,
			)
		);
	}

	function updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['wp_pg'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Gallery updated.', 'wp-photo-gallery' ),
			2  => __( 'Custom field updated.', 'wp-photo-gallery' ),
			3  => __( 'Custom field deleted.', 'wp-photo-gallery' ),
			4  => __( 'Gallery updated.', 'wp-photo-gallery' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Gallery restored to revision from %s', 'wp-photo-gallery' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Gallery published.', 'wp-photo-gallery' ),
			7  => __( 'Gallery saved.', 'wp-photo-gallery' ),
			8  => __( 'Gallery submitted.', 'wp-photo-gallery' ),
			9  => sprintf(
				__( 'Gallery scheduled for: <strong>%1$s</strong>.', 'wp-photo-gallery' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'wp-photo-gallery' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Gallery draft updated.', 'wp-photo-gallery' )
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Gallery', 'wp-photo-gallery' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Gallery', 'wp-photo-gallery' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	public function help_tab() {

		$screen = get_current_screen();

		// Return early if we're not on the book post type.
		if ( 'wp_pg' != $screen->post_type ) {
			return;
		}

		// Setup help tab args.
		$args = array(
			'id'      => 'wdg_getting_started', //unique id for the tab
			'title'   => 'Getting Started', //unique visible title for the tab
			'content' => '<h3>Getting Started</h3><ol>
				<li>Go to WP Photo Gallery and click ‘Add new Gallery’ button</li>
				<li>Type the name of the gallery and add images</li>
				<li>Publish and you have a just created your first photo gallery</li>
			</ol>
			<h4>Creating gallery list page</h4>
			<ol>
				<li>Create a new page or edit and existing one</li>
				<li>Click on ‘Add WP Photo Gallery’ button directly above the Editor</li>
				<li>Press the ‘Insert Shortcode’ button for Galleries overview</li>
				<li>You should have a short code in your editor ([wp_pg])</li>
				<li>Save the page and you\’re done!</li>
			</ol>
			',  //actual help text
		);

		// Add the help tab.
		$screen->add_help_tab( $args );

		$contextual_help = '<h3>' . __('Feedback', 'wp-photo-gallery') . '</h3>' ;
		$contextual_help.= '<p>' . __('Your opinion matters! We would appreciate if you can share what you think about WP Photo Gallery with us. We would love to improve it!', 'wp-photo-gallery') . '</p>' ;
		$contextual_help.= '<p>' . __('Just shoot us an email at <a href="mailto:labs@wiredot.com">labs@wiredot.com</a>', 'wp-photo-gallery') . '</p>' ;

		// Setup help tab args.
		$args = array(
			'id'      => 'wdg_feedback', //unique id for the tab
			'title'   => 'Feedback', //unique visible title for the tab
			'content' => $contextual_help,  //actual help text
		);

		// Add the help tab.
		$screen->add_help_tab( $args );
	}

	public function set_list_views_order($wp_query) {
		if (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] == 'wp_pg') {

			$order = 'ASC';
			if (isset($_GET['order'])) {
				$order = $_GET['order'];
			}

			$orderby = 'menu_order';
			if (isset($_GET['orderby'])) {
				$orderby = $_GET['orderby'];
			}

			$wp_query->set('orderby', $orderby);
			$wp_query->set('order', $order);
		}
	}

	public function custom_columns($column, $post_id) {
		switch($column) {
			case 'featured_image':
				$post_thumbnail_id = get_post_thumbnail_id($post_id);
				
				$params = array(
					'w' => 50,
					'h' => 50,
					'q' => 95,
					'zc' => 1
				);
				
				$attributes = array(
					
				);

				$WP_PG_Image = (new WP_PG_Image($post_thumbnail_id, $params, $attributes))->show_image();
				//echo $WP_PG_Image->get_image($post_thumbnail_id, $params, $attr);
				break;
			default:
				$value = get_post_meta($post_id, $column, 1);
				echo $value;
				break;
		}
	}

	public function modify_list_view($columns) {
		$new_columns = array();

		if (isset($columns['cb'])) {
			$new_columns['cb'] = $columns['cb'];
		}

		$new_columns['featured_image'] = __('Cover', 'wp-photo-gallery');
		$new_columns['title'] = __('Title', 'wp-photo-gallery');
		$new_columns['date'] = __('Date', 'wp-photo-gallery');
		
		return $new_columns;
	}

	public function add_shortcode($post_id, $post) {
		if ($post->post_type == 'wp_pg') {
			global $wpdb;
			
			$wpdb->update(
				$wpdb->posts,
				array(
					'post_content' => '[wp_pg ID='.$post_id.']'
				),
				array(
					'ID' => $post_id
				)
			);
		}
	}

// class end
}