<?php

namespace WD_Gallery;

class WD_Gallery_CPT {

	public function __construct() {
		add_action( 'init', array( $this, 'create_post_type' ) );
		
		if (is_admin()) {
			
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

			add_action( 'contextual_help', array( $this, 'help_text'), 10, 3 );

			add_action('admin_head', array( $this, 'help_tab'));

			add_filter('pre_get_posts', array($this, 'set_list_views_order'));
			
			add_action('manage_posts_custom_column', array($this, 'custom_columns'), 10, 2);

			add_filter('manage_edit-wd_gallery_columns', array($this, 'modify_list_view'));

			add_action('save_post', array($this, 'add_shortcode'), 10, 2);
		}
	}

	public function create_post_type() {
		$labels = array(
			'name'               => _x( 'wd Gallery', 'post type general name', 'wd-gallery' ),
			'singular_name'      => _x( 'wd Gallery', 'post type singular name', 'wd-gallery' ),
			'menu_name'          => _x( 'wd Gallery', 'admin menu', 'wd-gallery' ),
			'name_admin_bar'     => _x( 'wd Gallery', 'add new on admin bar', 'wd-gallery' ),
			'add_new'            => _x( 'Add New Gallery', 'add new gallery', 'wd-gallery' ),
			'add_new_item'       => __( 'Add New Gallery', 'wd-gallery' ),
			'new_item'           => __( 'New Gallery', 'wd-gallery' ),
			'edit_item'          => __( 'Edit Gallery', 'wd-gallery' ),
			'view_item'          => __( 'View Gallery', 'wd-gallery' ),
			'all_items'          => __( 'All Galleries', 'wd-gallery' ),
			'search_items'       => __( 'Search Galleries', 'wd-gallery' ),
			'parent_item_colon'  => __( 'Parent Galleries:', 'wd-gallery' ),
			'not_found'          => __( 'No Galleries found.', 'wd-gallery' ),
			'not_found_in_trash' => __( 'No Galleries found in Trash.', 'wd-gallery' )
		);

		register_post_type( 'wd_gallery',
			array(
				'labels' => $labels,
				'description' => __( 'Gallery Plugin', 'wd-gallery' ),
				'public' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_in_admin_bar' => true,
				'menu_position' => 80,
				'menu_icon' => WD_GALLERY_URL.'/assets/images/wd-gallery.svg',
				'capability_type' => 'page',
				'hierarchical' => false,
				'supports' => array('title', 'thumbnail', 'page-attributes'),
				'rewrite' => array('slug' => 'wd-gallery'),
				'has_archive' => true,
			)
		);
	}

	function updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['wd_gallery'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Gallery updated.', 'wd-gallery' ),
			2  => __( 'Custom field updated.', 'wd-gallery' ),
			3  => __( 'Custom field deleted.', 'wd-gallery' ),
			4  => __( 'Gallery updated.', 'wd-gallery' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Gallery restored to revision from %s', 'wd-gallery' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Gallery published.', 'wd-gallery' ),
			7  => __( 'Gallery saved.', 'wd-gallery' ),
			8  => __( 'Gallery submitted.', 'wd-gallery' ),
			9  => sprintf(
				__( 'Gallery scheduled for: <strong>%1$s</strong>.', 'wd-gallery' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'wd-gallery' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Gallery draft updated.', 'wd-gallery' )
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Gallery', 'wd-gallery' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Gallery', 'wd-gallery' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	public function help_text( $contextual_help, $screen_id, $screen ) {
		//$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
		if ( 'wd_gallery' == $screen->id ) {
		$contextual_help =
		  '<p>' . __('Things to remember when adding or editing a book:', 'wd-gallery') . '</p>' .
		  '<ul>' .
		  '<li>' . __('Specify the correct genre such as Mystery, or Historic.', 'wd-gallery') . '</li>' .
		  '<li>' . __('Specify the correct writer of the book.  Remember that the Author module refers to you, the author of this book review.', 'wd-gallery') . '</li>' .
		  '</ul>' .
		  '<p>' . __('If you want to schedule the book review to be published in the future:', 'wd-gallery') . '</p>' .
		  '<ul>' .
		  '<li>' . __('Under the Publish module, click on the Edit link next to Publish.', 'wd-gallery') . '</li>' .
		  '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.', 'wd-gallery') . '</li>' .
		  '</ul>' .
		  '<p><strong>' . __('For more information:', 'wd-gallery') . '</strong></p>' .
		  '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>', 'wd-gallery') . '</p>' .
		  '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'wd-gallery') . '</p>' ;
		} elseif ( 'edit-wd_gallery' == $screen->id ) {
		$contextual_help =
		  '<p>' . __('This is the help screen displaying the table of books blah blah blah.', 'wd-gallery') . '</p>' ;
		}
		return $contextual_help;
	}

	public function help_tab() {

		$screen = get_current_screen();

		// Return early if we're not on the book post type.
		if ( 'wd_gallery' != $screen->post_type ) {
			return;
		}

		// Setup help tab args.
		$args = array(
			'id'      => 'you_custom_id', //unique id for the tab
			'title'   => 'Custom Help', //unique visible title for the tab
			'content' => '<h3>Help Title</h3><p>Help content</p>',  //actual help text
		);

		// Add the help tab.
		$screen->add_help_tab( $args );
	}

	public function set_list_views_order($wp_query) {
		if (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] == 'wd_gallery') {

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

				$WD_Gallery_Image = (new WD_Gallery_Image($post_thumbnail_id, $params, $attributes))->show_image();
				//echo $WD_Gallery_Image->get_image($post_thumbnail_id, $params, $attr);
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

		$new_columns['featured_image'] = __('Cover', 'wd-gallery');
		$new_columns['title'] = __('Title', 'wd-gallery');
		$new_columns['date'] = __('Date', 'wd-gallery');
		
		return $new_columns;
	}

	public function add_shortcode($post_id, $post) {
		if ($post->post_type == 'wd_gallery') {
			global $wpdb;
			
			$wpdb->update(
				$wpdb->posts,
				array(
					'post_content' => '[wd_gallery ID='.$post_id.']'
				),
				array(
					'ID' => $post_id
				)
			);
		}
	}

// class end
}