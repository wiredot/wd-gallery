jQuery(document).ready(function($){
	$('#insert-wd-gallery').click(open_media_window);
});

function open_media_window() {
	editor.windowManager.open( {
        title: 'wd Gallery',
        body: [{
            type: 'listbox',
            name: 'gallery',
            text: 'Select Gallery',
            values: shortcodes_button_wd_gallery
        }]
    });
}