jQuery(document).ready(function($){
	
});

function wppgInsertForm(galleryID) {
	if (galleryID > 0) {
		window.send_to_editor("[wp-photo-gallery id="+galleryID+"]");
	} else {
		window.send_to_editor("[wp-photo-gallery]");
	}
}
