<?php

namespace Wiredot\WPPG;

use Wiredot\Preamp\Twig;
use WP_Query;

class Editor {

	public function __construct() {
		add_action('media_buttons', array($this, 'add_media_button'), 999);
		add_action('admin_footer', array($this, 'add_media_button_content'));
	}

	public function add_media_button() {
		echo '<a href="#TB_inline?width=400&amp;inlineId=wppg_media_content&amp;width=753&amp;height=657" class="thickbox button wp-photo-gallery-media-button" id="" title="Add WP Photo Gallery"><img src="'.WPPG_URL.'/assets/images/wp-photo-gallery.svg"> Add WP Photo Gallery</a>';
	}

	public function add_media_button_content() {
		// global $wppg_query;
		// $List = new Gallery_List;
		// $wppg_query = $List->get_list();
		// print_r($wppg_query);
		// $wppg_query = (new Gallery_List)->get_list();
		// $smarty = (new WP_PG_Smarty)->get_smarty();
		// $smarty->display('media-button-content.html');

		// $post = $wppg_query;
		// $page = $wppg_query;
		$Twig = new Twig;
		echo $Twig->twig->render('media-button-content.html');
	}

// end class
}