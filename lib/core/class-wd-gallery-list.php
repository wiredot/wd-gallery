<?php

class WD_Gallery_List {

	public function __construct() {
	}

	public function show_list() {
		global $WD_Gallery_Smarty;

		return $WD_Gallery_Smarty->smarty->fetch('wd-gallery-list.html');
	}

// class end
}