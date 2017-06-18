<?php

namespace Wiredot\WP_GALLERY;

class Admin {

	public function __construct() {
		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
		add_filter('plugin_row_meta', array($this, 'add_row_meta'), 10, 2);
		add_filter('bulk_post_updated_messages', array($this, 'bulk_post_updated_messages_filter'), 10, 2);
		add_action('save_post', array($this, 'add_shortcode'), 10, 2);
	}

	public function add_action_links($links, $file) {
		// run for this plugin
		if ($file == WP_GALLERY_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wp-photo-gallery&page=skins'>" . __('Skins', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

	public function add_row_meta($links, $file) {
		// run for this plugin
		if ($file == WP_GALLERY_BASENAME) {
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

}