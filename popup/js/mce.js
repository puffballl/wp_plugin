(function() {
    tinymce.PluginManager.add('popup', function( editor, url ) {
        editor.addButton( 'popup', {
            title: 'Hide Popup On this Page / Post',
            icon: 'icon popup',
            onclick: function() {
                editor.insertContent("[hidefbpopup]");
            }
        });
    });
})();