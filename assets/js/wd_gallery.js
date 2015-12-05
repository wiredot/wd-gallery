jQuery(document).ready(function($){
	wdgInitSortable($);
	wdgInitPhotos($);
});

function wdgInitSortable($) {
	$('.wd_gallery_mb').sortable();
}

function wdgInitPhotos($) {
	$('.wd_gallery_remove').click(function(event) {
		event.preventDefault();
		$(this).parent('.wd_gallery_photo').slideUp(300, function(){
			$(this).remove();
		});
	});
}