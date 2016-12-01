<?php

namespace Wiredot\WPPG;

class Admin {

	public function __construct() {
		// add setting link on plugin page
		add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
	}

	public function add_action_links($links, $file) {
		// run for this plugin
		if ($file == WPPG_BASENAME) {
			// settings link
			$links[] = "<a href='edit.php?post_type=wp-photo-gallery&page=themes'>" . __('Themes', 'wp-photo-gallery') . "</a>";
		}
		return $links;
	}

// end class
}