<?php
/*
  Plugin Name: wd Gallery
  Plugin URI:  http://wiredot.com/
  Description: Photo Gallery 
  Author: wiredot
  Version: 1.0.0 a1
  Author URI: http://wiredot.com/
  License: GPLv2 or later
 */

require_once 'lib/core/class-wd-gallery.php';
$WD_Gallery = new WD_Gallery(__FILE__, 'wd_gallery');

$WD_Gallery_CPT = new WD_Gallery_CPT();
$WD_Gallery_MB = new WD_Gallery_MB();
$WD_Gallery_Smarty = new WD_Gallery_Smarty();
