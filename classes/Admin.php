<?php

namespace Wiredot\WP_Photo_Gallery;

class Admin {

	public function __construct() {
		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
		add_filter('plugin_row_meta', array($this, 'add_row_meta'), 10, 2);
		add_filter('bulk_post_updated_messages', array($this, 'bulk_post_updated_messages_filter'), 10, 2);
		add_action('admin_head', array( $this, 'help_tab'));
		add_action('save_post', array($this, 'add_shortcode'), 10, 2);
	}

	public function add_action_links($links, $file) {
		// run for this plugin
		if ($file == WP_PHOTO_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wp-photo-gallery&page=skins'>" . __('Skins', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

	public function add_row_meta($links, $file) {
		// run for this plugin
		if ($file == WP_PHOTO_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='index.php?page=wp-photo-gallery-welcome'>" . __('Getting Started', 'wp-photo-gallery') . "</a>";
			$links[] = "<a href='index.php?page=wp-photo-gallery-welcome&tab=support'>" . __('Support', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

	public function show_shortcode($atts) {
		if (is_array($atts) && array_key_exists('id', $atts)) {
			$Gallery_Single = new Gallery_Single($atts['id']);
			return $Gallery_Single->get_single();
		} else {
			$Gallery_List = new Gallery_List();
			return $Gallery_List->get_list();
		}
	}

	public function add_shortcode($post_id, $post) {
		if ($post->post_type == 'wp-photo-gallery') {
			global $wpdb;
			
			$wpdb->update(
				$wpdb->posts,
				array(
					'post_content' => '[wp-photo-gallery id='.$post_id.']'
				),
				array(
					'ID' => $post_id
				)
			);
		}
	}

	function bulk_post_updated_messages_filter( $bulk_messages, $bulk_counts ) {
	    $bulk_messages['wp-photo-gallery'] = array(
	        'updated'   => _n( '%s Gallery updated.', '%s Galleries updated.', $bulk_counts['updated'] ),
	        'locked'    => _n( '%s Gallery not updated, somebody is editing it.', '%s Galleries not updated, somebody is editing them.', $bulk_counts['locked'] ),
	        'deleted'   => _n( '%s Gallery permanently deleted.', '%s Galleries permanently deleted.', $bulk_counts['deleted'] ),
	        'trashed'   => _n( '%s Gallery moved to the Trash.', '%s Galleries moved to the Trash.', $bulk_counts['trashed'] ),
	        'untrashed' => _n( '%s Gallery restored from the Trash.', '%s Galleries restored from the Trash.', $bulk_counts['untrashed'] ),
	    );

	    return $bulk_messages;

	}

	public function help_tab() {

		$screen = get_current_screen();

		// Return early if we're not on the book post type.
		if ( 'wp-photo-gallery' != $screen->post_type ) {
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
				<li>You should have a short code in your editor ([wp-photo-gallery])</li>
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

}