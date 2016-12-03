jQuery(document).ready(function($){
	wpPhotoGalleryTabs($);
});

function wpPhotoGalleryTabs($) {
	$('.wp-photo-gallery-wrap .nav-tab').on('click', function() {
            var which = $(this).attr('rel');
            $('.wp-photo-gallery-wrap .nav-tab').removeClass('nav-tab-active');
            $('.wp-photo-gallery-wrap .tab-content').removeClass('active');
            $(this).addClass('nav-tab-active');
            $('.wp-photo-gallery-wrap .tab-' + which).addClass('active');
        });
}

function wppgInsertForm(galleryID) {
	if (galleryID > 0) {
		window.send_to_editor("[wp-photo-gallery id="+galleryID+"]");
	} else {
		window.send_to_editor("[wp-photo-gallery]");
	}
}

//# sourceMappingURL=wp-photo-gallery.js.map
