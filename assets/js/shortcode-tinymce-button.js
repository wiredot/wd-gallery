
(function() {
    tinymce.PluginManager.add('wd_gallery', function( editor )
    {
        editor.addButton('wd_gallery', {
            title: 'wd Gallery',
            icon: 'icon dashicons-format-gallery',
                    onclick: function() {
                      editor.windowManager.open( {
                            title: 'wd Gallery',
                            body: [{
                                type: 'listbox',
                                name: 'gallery',
                                text: 'Select Gallery',
                                values: shortcodes_button_wd_gallery
                            }],       
                            onsubmit: function(e) {
                                editor.insertContent( '[wd_gallery ID=' + e.data.gallery + ']');
                            },
                        });
                    }
        });

    });
})();




     