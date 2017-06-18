jQuery(document).ready(function($){
	wpPhotoGalleryTabs($);
});

function wpPhotoGalleryTabs($) {
	$('.wp-gallery-wrap .nav-tab').on('click', function() {
            var which = $(this).attr('rel');
            $('.wp-gallery-wrap .nav-tab').removeClass('nav-tab-active');
            $('.wp-gallery-wrap .tab-content').removeClass('active');
            $(this).addClass('nav-tab-active');
            $('.wp-gallery-wrap .tab-' + which).addClass('active');
        });
}

function wppgInsertForm(galleryID) {
	if (galleryID > 0) {
		window.send_to_editor("[wp-gallery id="+galleryID+"]");
	} else {
		window.send_to_editor("[wp-gallery]");
	}
}

//# sourceMappingURL=wp-gallery.js.map
